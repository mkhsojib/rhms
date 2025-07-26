<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\RaqiMonthlyAvailability;
use App\Models\User;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::with(['practitioner'])
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('patient.appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get all active practitioners for filtering on frontend
        // We'll filter them dynamically based on treatment type selection
        $practitioners = User::where('role', 'admin')
            ->where('is_active', true)
            ->get();

        // Build available dates for each practitioner as full objects
        $availableDates = [];
        foreach ($practitioners as $practitioner) {
            $dates = \App\Models\RaqiMonthlyAvailability::where('practitioner_id', $practitioner->id)
                ->where('is_available', true)
                ->get()
                ->map(function($date) {
                    return [
                        'availability_date' => \Carbon\Carbon::parse($date->availability_date)->format('Y-m-d'),
                        'is_available' => $date->is_available,
                        'start_time' => \Carbon\Carbon::parse($date->start_time)->format('H:i'),
                        'end_time' => \Carbon\Carbon::parse($date->end_time)->format('H:i'),
                        'slot_duration' => $date->slot_duration
                    ];
                })->toArray();
            $availableDates[$practitioner->id] = $dates;
        }

        return view('patient.appointments.create', compact('practitioners', 'availableDates'));
    }

    /**
     * Store a newly created appointment in storage.
     */
    public function store(Request $request)
    {
        // DEEP DEBUG: Log all incoming request data
        Log::info('FULL RAW REQUEST DATA', $request->all());
        
        // Validate basic fields first
        $rules = [
            'practitioner_id' => 'required|exists:users,id',
            'type' => 'required|in:ruqyah,hijama',
            'appointment_date' => 'required|date_format:Y-m-d',
            'appointment_time' => 'required|date_format:H:i',
            'symptoms' => 'nullable|string',
        ];
        
        // For Ruqyah, session_type_id is required
        // For Hijama, session_type_id is optional
        if ($request->type === 'ruqyah') {
            $rules['session_type_id'] = 'required|exists:raqi_session_types,id';
        } else if ($request->type === 'hijama') {
            $rules['session_type_id'] = 'nullable|exists:raqi_session_types,id';
        }
        
        $request->validate($rules);
        
        $user = Auth::user();

        // Prevent double booking: check if slot is already booked
        $alreadyBooked = Appointment::where('practitioner_id', $request->practitioner_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->where('status', '!=', 'cancelled')
            ->exists();
        if ($alreadyBooked) {
            return back()->withErrors(['appointment_time' => 'This time slot is already booked for the selected practitioner. Please choose another.'])->withInput();
        }
        
        $sessionType = null;
        $headCuppingData = null;
        $bodyCuppingData = null;
        
        if ($request->session_type_id) {
            $sessionType = \App\Models\RaqiSessionType::find($request->session_type_id);
        } elseif ($request->type === 'hijama') {
            // For Hijama, get both Head Cupping and Body Cupping pricing to store in appointments table
            $hijamaSessionTypes = \App\Models\RaqiSessionType::where('practitioner_id', $request->practitioner_id)
                ->whereIn('type', ['head_cupping', 'body_cupping'])
                ->get();
                
            // Debug: Log what we found
            \Log::info('Hijama Session Types Query', [
                'practitioner_id' => $request->practitioner_id,
                'found_types' => $hijamaSessionTypes->pluck('type', 'id')->toArray(),
                'count' => $hijamaSessionTypes->count()
            ]);
                
            foreach ($hijamaSessionTypes as $hijamaType) {
                if ($hijamaType->type === 'head_cupping') {
                    $headCuppingData = $hijamaType;
                    \Log::info('Found Head Cupping', ['fee' => $hijamaType->fee, 'id' => $hijamaType->id]);
                } elseif ($hijamaType->type === 'body_cupping') {
                    $bodyCuppingData = $hijamaType;
                    \Log::info('Found Body Cupping', ['fee' => $hijamaType->fee, 'id' => $hijamaType->id]);
                }
            }
            
            // Set session type to Head Cupping as primary (for backward compatibility)
            $sessionType = $headCuppingData ?: $bodyCuppingData;
        }
        
        // Calculate the end time based on the availability slot duration
        $appointmentEndTime = null;
        $availability = \App\Models\RaqiMonthlyAvailability::where('practitioner_id', $request->practitioner_id)
            ->where('availability_date', $request->appointment_date)
            ->where('is_available', true)
            ->first();
            
        if ($availability) {
            // Calculate end time using the slot duration from availability
            $startTime = \Carbon\Carbon::parse($request->appointment_time);
            $endTime = $startTime->copy()->addMinutes($availability->slot_duration);
            $appointmentEndTime = $endTime->format('H:i');
        }
        
        $appointmentData = [
            'appointment_no' => Appointment::generateAppointmentNo($request->type),
            'user_id' => $user->id,
            'practitioner_id' => $request->practitioner_id,
            'type' => $request->type,
            'session_type_id' => $sessionType?->id, // Use auto-selected session type for Hijama
            'session_type_name' => $request->type === 'hijama' ? 'hijama' : $sessionType?->type,
            'session_type_fee' => $sessionType?->fee ?? 0, // Use practitioner's pricing or default to 0
            'session_type_min_duration' => $sessionType?->min_duration,
            'session_type_max_duration' => $sessionType?->max_duration,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'appointment_end_time' => $appointmentEndTime,
            'symptoms' => $request->symptoms,
            'status' => 'pending',
            'created_by' => $user->id,
        ];
        
        // Add Hijama-specific pricing fields if this is a Hijama appointment
        if ($request->type === 'hijama') {
            $appointmentData['head_cupping_fee'] = $headCuppingData?->fee;
            $appointmentData['head_cupping_min_duration'] = $headCuppingData?->min_duration;
            $appointmentData['head_cupping_max_duration'] = $headCuppingData?->max_duration;
            $appointmentData['body_cupping_fee'] = $bodyCuppingData?->fee;
            $appointmentData['body_cupping_min_duration'] = $bodyCuppingData?->min_duration;
            $appointmentData['body_cupping_max_duration'] = $bodyCuppingData?->max_duration;
            
            // Debug: Log what we're storing
            \Log::info('Storing Hijama Pricing Data', [
                'head_cupping_fee' => $appointmentData['head_cupping_fee'],
                'head_cupping_min_duration' => $appointmentData['head_cupping_min_duration'],
                'head_cupping_max_duration' => $appointmentData['head_cupping_max_duration'],
                'body_cupping_fee' => $appointmentData['body_cupping_fee'],
                'body_cupping_min_duration' => $appointmentData['body_cupping_min_duration'],
                'body_cupping_max_duration' => $appointmentData['body_cupping_max_duration']
            ]);
        }
        
        $appointment = Appointment::create($appointmentData);

        // Create invoice after appointment
        $invoiceNo = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);
        \App\Models\Invoice::create([
            'invoice_no' => $invoiceNo,
            'appointment_id' => $appointment->id,
            'patient_id' => $appointment->user_id,
            'practitioner_id' => $appointment->practitioner_id,
            'amount' => $appointment->session_type_fee ?? 0,
            'status' => 'unpaid',
            'created_by' => $user->id,
        ]);

        return redirect()->route('patient.appointments.show', $appointment)
            ->with('success', 'Appointment booked successfully. Please wait for approval.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        // Ensure the appointment belongs to the current patient
        if ($appointment->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $appointment->load(['practitioner', 'treatment', 'sessionType']);
        $questions = \App\Models\Question::where('category', $appointment->type)->where('is_active', true)->get();
        $answers = \App\Models\QuestionAnswer::where('appointment_id', $appointment->id)->pluck('answer', 'question_id');
        $hasUnanswered = $questions->count() > 0 && $questions->filter(fn($q) => !isset($answers[$q->id]) || $answers[$q->id] === null || $answers[$q->id] === '')->count() > 0;
        return view('patient.appointments.show', compact('appointment', 'questions', 'answers', 'hasUnanswered'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        // Ensure the appointment belongs to the current patient and is pending
        if ($appointment->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        if ($appointment->status !== 'pending') {
            return redirect()->route('patient.appointments.index')
                ->with('error', 'Cannot edit appointment that is not pending.');
        }

        // Get all raqis (practitioners with admin role)
        $practitioners = User::where('role', 'admin')->get();
        
        // Get ALL available dates from database (no date restrictions)
        $availableDates = RaqiMonthlyAvailability::where('is_available', true)
            ->orderBy('availability_date', 'asc')
            ->get();
            
        // Log all available dates for debugging
        Log::info('All available dates for editing appointment:', $availableDates->pluck('availability_date', 'id')->toArray());
        
        // Group by practitioner_id
        $groupedDates = $availableDates->groupBy('practitioner_id');
        
        $formattedAvailableDates = [];
        foreach ($groupedDates as $practitionerId => $dates) {
            $formattedAvailableDates[$practitionerId] = $dates->map(function($date) {
                // Ensure consistent date format without timezone issues
                $formattedDate = Carbon::parse($date->availability_date)->format('Y-m-d');
                
                return [
                    'availability_date' => $formattedDate,
                    'is_available' => $date->is_available,
                    'start_time' => Carbon::parse($date->start_time)->format('H:i'),
                    'end_time' => Carbon::parse($date->end_time)->format('H:i'),
                    'slot_duration' => $date->slot_duration
                ];
            })->toArray();
        }
        
        // Log the formatted dates for debugging
        Log::info('Formatted available dates for edit view:', $formattedAvailableDates);
        
        // Make sure to include the current appointment date as available
        // This ensures the current date is always selectable even if not in the availability table
        $currentAppointmentDate = $appointment->appointment_date;
        $currentPractitionerId = $appointment->practitioner_id;
        
        // If the current appointment's date is not in the available dates, add it
        if (!isset($formattedAvailableDates[$currentPractitionerId])) {
            $formattedAvailableDates[$currentPractitionerId] = [];
        }
        
        // Check if the current date is already in the available dates
        $dateExists = false;
        foreach ($formattedAvailableDates[$currentPractitionerId] as $date) {
            if ($date['availability_date'] === $currentAppointmentDate) {
                $dateExists = true;
                break;
            }
        }
        
        // If the current date is not in the available dates, add it
        if (!$dateExists) {
            // Add the current appointment date as available
            $formattedAvailableDates[$currentPractitionerId][] = [
                'availability_date' => $currentAppointmentDate,
                'is_available' => true,
                'start_time' => '09:00',  // Default start time
                'end_time' => '19:00',    // Default end time
                'slot_duration' => 60     // Default slot duration
            ];
            
            Log::info('Added current appointment date to available dates:', [
                'practitioner_id' => $currentPractitionerId,
                'date' => $currentAppointmentDate
            ]);
        }
        
        return view('patient.appointments.edit', [
            'appointment' => $appointment,
            'practitioners' => $practitioners,
            'availableDates' => $formattedAvailableDates
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        // Ensure the appointment belongs to the current patient and is pending
        if ($appointment->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        if ($appointment->status !== 'pending') {
            return redirect()->route('patient.appointments.index')
                ->with('error', 'Cannot edit appointment that is not pending.');
        }

        try {
            // Log the raw request data for debugging
            Log::info('Updating appointment - raw request data:', [
                'appointment_id' => $appointment->id,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
            ]);
            
            // Validate the request
            $request->validate([
                'practitioner_id' => 'required|exists:users,id',
                'type' => 'required|in:ruqyah,hijama',
                'appointment_date' => 'required|date',
                'appointment_time' => 'required',
                'appointment_end_time' => 'required|date_format:H:i',
                'symptoms' => 'nullable|string',
            ]);
            
            // Get the date and time from the request
            $appointmentDate = $request->appointment_date;
            $appointmentTimes = explode(',', $request->appointment_time);
            $practitionerId = $request->practitioner_id;
            $treatmentType = $request->type;
            
            // Ensure we have a clean date string without any duplicates
            if (strpos($appointmentDate, $appointmentDate) !== false) {
                // If the date appears twice, take only the first occurrence
                $appointmentDate = substr($appointmentDate, 0, 10);
                Log::warning('Fixed double date specification in update:', ['cleaned_date' => $appointmentDate]);
            }
            
            // If we have multiple time slots, we'll need to delete the current appointment and create new ones
            if (count($appointmentTimes) > 1) {
                // Delete the current appointment
                $appointment->delete();
                
                // Create new appointments for each time slot
                foreach ($appointmentTimes as $singleTimeSlot) {
                    // Skip empty slots
                    if (empty($singleTimeSlot)) {
                        continue;
                    }
                    
                    // Generate a unique appointment number
                    $appointmentNo = 'APT-' . date('Ymd') . '-' . rand(1000, 9999);
                    
                    // Calculate end time for this slot
                    $appointmentEndTime = null;
                    $availability = \App\Models\RaqiMonthlyAvailability::where('practitioner_id', $practitionerId)
                        ->where('availability_date', $appointmentDate)
                        ->where('is_available', true)
                        ->first();
                        
                    if ($availability) {
                        $startTime = \Carbon\Carbon::parse($singleTimeSlot);
                        $endTime = $startTime->copy()->addMinutes($availability->slot_duration);
                        $appointmentEndTime = $endTime->format('H:i');
                    }
                    
                    // Save the appointment using direct SQL to avoid Carbon parsing
                    DB::table('appointments')->insert([
                        'appointment_no'    => $appointmentNo,
                        'user_id'           => $appointment->user_id,
                        'appointment_date'  => $appointmentDate,
                        'appointment_time'  => $singleTimeSlot, // Individual time slot
                        'appointment_end_time' => $appointmentEndTime,
                        'practitioner_id'   => $practitionerId,
                        'type'              => $treatmentType,
                        'symptoms'          => $request->symptoms,
                        'status'            => 'pending',
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ]);
                    
                    Log::info('Created new appointment for time slot during update:', [
                        'date' => $appointmentDate,
                        'time' => $singleTimeSlot
                    ]);
                }
            } else {
                // If we only have one time slot, update the existing appointment
                $singleTimeSlot = $appointmentTimes[0];
                
                // Calculate end time for this slot
                $appointmentEndTime = null;
                $availability = \App\Models\RaqiMonthlyAvailability::where('practitioner_id', $practitionerId)
                    ->where('availability_date', $appointmentDate)
                    ->where('is_available', true)
                    ->first();
                    
                if ($availability) {
                    $startTime = \Carbon\Carbon::parse($singleTimeSlot);
                    $endTime = $startTime->copy()->addMinutes($availability->slot_duration);
                    $appointmentEndTime = $endTime->format('H:i');
                }
                
                // Update the appointment using direct DB update to avoid Carbon parsing
                DB::table('appointments')->where('id', $appointment->id)->update([
                    'appointment_date'  => $appointmentDate,
                    'appointment_time'  => $singleTimeSlot,
                    'appointment_end_time' => $appointmentEndTime,
                    'practitioner_id'   => $practitionerId,
                    'type'              => $treatmentType,
                    'symptoms'          => $request->symptoms,
                    'updated_at'        => now(),
                ]);
                
                Log::info('Updated existing appointment:', [
                    'appointment_id' => $appointment->id,
                    'date' => $appointmentDate,
                    'time' => $singleTimeSlot
                ]);
            }
            
            // Check if this is an AJAX request and return appropriate response
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Your appointment has been updated successfully.',
                    'redirect' => route('patient.appointments.index')
                ]);
            }
            
            return redirect()->route('patient.appointments.index')
                ->with('success', 'Appointment updated successfully.');
                
        } catch (\Exception $e) {
            // Log the full exception details
            Log::error('Error updating appointment: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'raw_request_date' => $request->appointment_date
            ]);
            
            // Return a specific error message
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating appointment: ' . $e->getMessage()
                ], 422);
            }
            
            return back()->with('error', 'Error updating appointment: ' . $e->getMessage());
        }
    }

    
    /**
     * Get available time slots for a specific practitioner, date, and treatment type.
     */
    /**
     * Cancel the specified appointment.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        // Check if the appointment belongs to the authenticated user
        if ($appointment->user_id !== Auth::id()) {
            return redirect()->route('patient.appointments.index')
                ->with('error', 'You are not authorized to cancel this appointment.');
        }

        // Check if the appointment is already approved
        if ($appointment->status !== 'pending') {
            return redirect()->route('patient.appointments.index')
                ->with('error', 'Cannot cancel appointment that is not pending.');
        }

        // Update the appointment status to cancelled using direct DB update
        // This is necessary because the model has timestamps disabled
        $updated = DB::table('appointments')
            ->where('id', $appointment->id)
            ->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancelled_by' => Auth::id()
            ]);

        if (!$updated) {
            return redirect()->route('patient.appointments.index')
                ->with('error', 'Failed to cancel appointment. Please try again.');
        }

        // Log the cancellation
        Log::info('Appointment cancelled', [
            'appointment_id' => $appointment->id,
            'practitioner_id' => $appointment->practitioner_id,
            'date' => $appointment->appointment_date,
            'time' => $appointment->appointment_time,
            'user_id' => Auth::id(),
            'cancelled_at' => now()
        ]);

        return redirect()->route('patient.appointments.index')
            ->with('success', 'Appointment cancelled successfully.');
    }

    /**
     * Get available time slots for a specific practitioner, date, and treatment type.
     */
    public function getAvailableTimeSlots(Request $request)
    {
        $practitionerId = $request->input('practitioner_id');
        $date = $request->input('date');
        Log::info('getAvailableTimeSlots called', ['practitioner_id' => $practitionerId, 'date' => $date]);

        if (!$practitionerId || !$date) {
            return response()->json([]);
        }

        $availability = RaqiMonthlyAvailability::where('practitioner_id', $practitionerId)
            ->where('availability_date', $date)
            ->where('is_available', true)
            ->first();
        Log::info('Availability record found', ['availability' => $availability]);

        if (!$availability) {
            return response()->json([]);
        }

        // Generate all possible time slots for the day
        $slots = $availability->generateTimeSlots();
        Log::info('Generated slots before filtering', ['slots' => $slots]);

        // Get all appointments for this practitioner on this day (including cancelled ones for debugging)
        $allAppointments = Appointment::where('practitioner_id', $practitionerId)
            ->where('appointment_date', $date)
            ->get();
        
        Log::info('All appointments found (including cancelled)', ['appointments' => $allAppointments->toArray()]);
        
        // Filter out cancelled appointments
        $bookedAppointments = $allAppointments->where('status', '!=', 'cancelled');
        
        Log::info('Booked appointments after filtering out cancelled', ['appointments' => $bookedAppointments->toArray()]);

        // Extract booked times and ensure consistent format
        $bookedTimes = $bookedAppointments->pluck('appointment_time')
            ->map(function ($time) {
                // Handle different time formats and ensure H:i format
                if (is_string($time)) {
                    return Carbon::parse($time)->format('H:i');
                }
                return $time->format('H:i');
            })
            ->toArray();
        
        Log::info('Booked times after formatting', ['booked_times' => $bookedTimes]);

        // Filter out the booked slots completely - they won't be shown at all
        $availableSlots = array_filter($slots, function($slot) use ($bookedTimes) {
            $isBooked = in_array($slot['start'], $bookedTimes);
            Log::info('Checking slot', [
                'slot_start' => $slot['start'],
                'slot_end' => $slot['end'],
                'is_booked' => $isBooked,
                'booked_times' => $bookedTimes
            ]);
            return !$isBooked;
        });
        
        Log::info('Available slots after filtering', ['slots' => $availableSlots]);
        return response()->json(array_values($availableSlots));
    }

    // New AJAX methods for patient appointment creation
    public function getSessionTypes(Request $request)
    {
        $practitionerId = $request->input('practitioner_id');
        $treatmentType = $request->input('treatment_type');
        $allPractitioners = $request->input('all_practitioners', false);

        if (!$treatmentType) {
            return response()->json([]);
        }

        // If all_practitioners is true, fetch from all practitioners
        if ($allPractitioners) {
            $query = \App\Models\RaqiSessionType::query();
        } else {
            // Original behavior: require practitioner_id
            if (!$practitionerId) {
                return response()->json([]);
            }
            $query = \App\Models\RaqiSessionType::where('practitioner_id', $practitionerId);
        }

        if ($treatmentType === 'ruqyah') {
            $query->whereIn('type', ['diagnosis', 'short', 'long']);
        } elseif ($treatmentType === 'hijama') {
            $query->whereIn('type', ['head_cupping', 'body_cupping']);
        }

        return response()->json($query->get());
    }

    public function getAvailableDates(Request $request)
    {
        $practitionerId = $request->input('practitioner_id');
        Log::info('getAvailableDates called', ['practitioner_id' => $practitionerId]);
        if (!$practitionerId) {
            return response()->json([]);
        }
        $dates = RaqiMonthlyAvailability::where('practitioner_id', $practitionerId)
            ->where('is_available', true)
            ->where('availability_date', '>=', now()->toDateString())
            ->orderBy('availability_date')
            ->pluck('availability_date');
        Log::info('Available dates found', ['dates' => $dates]);
        return response()->json($dates);
    }

    public function downloadInvoice(Appointment $appointment)
    {
        $user = Auth::user();
        // Only allow the patient to download their own invoice
        if ($appointment->user_id !== $user->id) {
            abort(403);
        }
        $invoice = $appointment->invoice;
        if (!$invoice) {
            return back()->with('error', 'No invoice found for this appointment.');
        }
        // Only allow download if a payment/transaction exists
        if ($invoice->transactions()->count() === 0) {
            return back()->with('error', 'Invoice is not available for download until payment is recorded.');
        }
        $invoice->load(['appointment', 'patient', 'practitioner']);
        $pdf = Pdf::loadView('superadmin.invoices.print', compact('invoice'));
        $filename = 'Invoice_' . $invoice->invoice_no . '.pdf';
        return $pdf->download($filename);
    }
}
