<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use App\Models\RaqiSessionType;
use App\Models\Invoice;

class AppointmentController extends Controller
{
    /**
     * Display a listing of all appointments (super admin can see all)
     */
    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'practitioner', 'sessionType', 'invoice']);
            
        // Search by Appointment No
        if ($request->filled('appointment_no')) {
            $query->where('appointment_no', 'like', '%' . $request->appointment_no . '%');
        }
        
        // Search by Patient Name
        if ($request->filled('patient_name')) {
            $query->whereHas('patient', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->patient_name . '%');
            });
        }
        
        // Search by Patient Phone
        if ($request->filled('patient_phone')) {
            $query->whereHas('patient', function($q) use ($request) {
                $q->where('phone', 'like', '%' . $request->patient_phone . '%');
            });
        }
        
        // Filter by Payment Status
        if ($request->filled('payment_status')) {
            if ($request->payment_status === 'paid') {
                $query->whereHas('invoice', function($q) {
                    $q->where('status', 'paid');
                });
            } elseif ($request->payment_status === 'unpaid') {
                $query->whereHas('invoice', function($q) {
                    $q->where('status', '!=', 'paid');
                });
            } elseif ($request->payment_status === 'no_invoice') {
                $query->doesntHave('invoice');
            }
        }
        
        // Filter by Treatment Type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        // Filter by Appointment Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by Date Range
        if ($request->filled('date_from')) {
            $query->whereDate('appointment_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('appointment_date', '<=', $request->date_to);
        }
        
        $appointments = $query->orderBy('id', 'desc')->paginate(15);
        
        // Preserve query parameters in pagination links
        $appointments->appends($request->all());
        
        return view('superadmin.appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = User::where('role', 'patient')->where('is_active', true)->get();
        $practitioners = User::where('role', 'admin')->where('is_active', true)->get();
        $sessionTypes = RaqiSessionType::all();

        // Build available dates for all practitioners
        $availableDates = [];
        foreach ($practitioners as $practitioner) {
            $dates = \App\Models\RaqiMonthlyAvailability::where('practitioner_id', $practitioner->id)
                ->where('is_available', true)
                ->where('availability_date', '>=', now()->toDateString()) // Only present and future dates
                ->get()
                ->map(function($date) use ($practitioner) {
                    // Get booked times for this date
                    $bookedTimes = \App\Models\Appointment::where('practitioner_id', $practitioner->id)
                        ->where('appointment_date', $date->availability_date)
                        ->where('status', '!=', 'cancelled')
                        ->pluck('appointment_time')
                        ->map(function($time) {
                            return \Carbon\Carbon::parse($time)->format('H:i');
                        })
                        ->toArray();
                    
                    return [
                        'availability_date' => \Carbon\Carbon::parse($date->availability_date)->format('Y-m-d'),
                        'is_available' => $date->is_available,
                        'start_time' => \Carbon\Carbon::parse($date->start_time)->format('H:i'),
                        'end_time' => \Carbon\Carbon::parse($date->end_time)->format('H:i'),
                        'slot_duration' => $date->slot_duration,
                        'booked_times' => $bookedTimes
                    ];
                })->toArray();
            $availableDates[$practitioner->id] = $dates;
        }

        // Debug output
        \Log::info('SuperAdmin Available Dates:', $availableDates);

        return view('superadmin.appointments.create', compact('patients', 'practitioners', 'sessionTypes', 'availableDates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Build validation rules based on treatment type
        $rules = [
            'user_id' => 'required|exists:users,id',
            'practitioner_id' => 'required|exists:users,id',
            'type' => 'required|in:ruqyah,hijama',
            'appointment_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'appointment_end_time' => 'required|date_format:H:i',
            'symptoms' => 'nullable|string',
            'notes' => 'nullable|string',
        ];
        
        // For Ruqyah, session_type_id is required. For Hijama, it's optional
        if ($request->type === 'ruqyah') {
            $rules['session_type_id'] = 'required|exists:raqi_session_types,id';
        } else {
            $rules['session_type_id'] = 'nullable|exists:raqi_session_types,id';
        }
        
        $request->validate($rules);

        // For Hijama appointments, get both Head Cupping and Body Cupping pricing to store in appointments table
        $headCuppingData = null;
        $bodyCuppingData = null;
        
        if ($request->type === 'hijama' && !$request->session_type_id) {
            $hijamaSessionTypes = \App\Models\RaqiSessionType::where('practitioner_id', $request->practitioner_id)
                ->whereIn('type', ['head_cupping', 'body_cupping'])
                ->get();
                
            // Debug: Log what we found in superadmin controller
            \Log::info('SuperAdmin Hijama Session Types Query', [
                'practitioner_id' => $request->practitioner_id,
                'found_types' => $hijamaSessionTypes->pluck('type', 'id')->toArray(),
                'count' => $hijamaSessionTypes->count()
            ]);
                
            foreach ($hijamaSessionTypes as $hijamaType) {
                if ($hijamaType->type === 'head_cupping') {
                    $headCuppingData = $hijamaType;
                    \Log::info('SuperAdmin Found Head Cupping', ['fee' => $hijamaType->fee, 'id' => $hijamaType->id]);
                } elseif ($hijamaType->type === 'body_cupping') {
                    $bodyCuppingData = $hijamaType;
                    \Log::info('SuperAdmin Found Body Cupping', ['fee' => $hijamaType->fee, 'id' => $hijamaType->id]);
                }
            }
            
            // Set session type to Head Cupping as primary (for backward compatibility)
            $primarySessionType = $headCuppingData ?: $bodyCuppingData;
            if ($primarySessionType) {
                $request->merge(['session_type_id' => $primarySessionType->id]);
            }
        }

        // Enhanced duplicate booking prevention
        $existingAppointment = \App\Models\Appointment::where('practitioner_id', $request->practitioner_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->whereIn('status', ['pending', 'approved'])
            ->first();
            
        if ($existingAppointment) {
            return back()->withErrors([
                'appointment_time' => 'This time slot is already booked. Please choose another time or date.',
                'appointment_date' => 'This date/time combination is not available.'
            ])->withInput();
        }

        // Check if the date is actually available in the practitioner's schedule
        $availability = \App\Models\RaqiMonthlyAvailability::where('practitioner_id', $request->practitioner_id)
            ->where('availability_date', $request->appointment_date)
            ->where('is_available', true)
            ->first();
            
        if (!$availability) {
            return back()->withErrors([
                'appointment_date' => 'This date is not available in the practitioner\'s schedule.'
            ])->withInput();
        }

        $sessionType = \App\Models\RaqiSessionType::find($request->session_type_id);

        $appointmentData = [
            'appointment_no' => \App\Models\Appointment::generateAppointmentNo($request->type),
            'user_id' => $request->user_id,
            'practitioner_id' => $request->practitioner_id,
            'type' => $request->type,
            'session_type_id' => $request->session_type_id,
            'session_type_name' => $request->type === 'hijama' ? 'hijama' : $sessionType?->type,
            'session_type_fee' => $sessionType?->fee,
            'session_type_min_duration' => $sessionType?->min_duration,
            'session_type_max_duration' => $sessionType?->max_duration,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'appointment_end_time' => $request->appointment_end_time,
            'symptoms' => $request->symptoms,
            'notes' => $request->notes,
            'status' => 'pending',
            'created_by' => auth()->id(),
        ];
        
        // Add Hijama-specific pricing fields if this is a Hijama appointment
        if ($request->type === 'hijama') {
            $appointmentData['head_cupping_fee'] = $headCuppingData?->fee;
            $appointmentData['head_cupping_min_duration'] = $headCuppingData?->min_duration;
            $appointmentData['head_cupping_max_duration'] = $headCuppingData?->max_duration;
            $appointmentData['body_cupping_fee'] = $bodyCuppingData?->fee;
            $appointmentData['body_cupping_min_duration'] = $bodyCuppingData?->min_duration;
            $appointmentData['body_cupping_max_duration'] = $bodyCuppingData?->max_duration;
            
            // Debug: Log what we're storing in superadmin
            \Log::info('SuperAdmin Storing Hijama Pricing Data', [
                'head_cupping_fee' => $appointmentData['head_cupping_fee'],
                'head_cupping_min_duration' => $appointmentData['head_cupping_min_duration'],
                'head_cupping_max_duration' => $appointmentData['head_cupping_max_duration'],
                'body_cupping_fee' => $appointmentData['body_cupping_fee'],
                'body_cupping_min_duration' => $appointmentData['body_cupping_min_duration'],
                'body_cupping_max_duration' => $appointmentData['body_cupping_max_duration']
            ]);
        }
        
        $appointment = \App\Models\Appointment::create($appointmentData);

        // Create invoice after appointment
        $invoiceNo = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);
        Invoice::create([
            'invoice_no' => $invoiceNo,
            'appointment_id' => $appointment->id,
            'patient_id' => $appointment->user_id,
            'practitioner_id' => $appointment->practitioner_id,
            'amount' => $appointment->session_type_fee ?? 0,
            'status' => 'unpaid',
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('superadmin.appointments.show', $appointment)
            ->with('success', 'Appointment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        $appointment->load(['practitioner', 'patient', 'sessionType', 'treatment']);
        $questions = \App\Models\Question::where('category', $appointment->type)->where('is_active', true)->get();
        $answers = \App\Models\QuestionAnswer::where('appointment_id', $appointment->id)->pluck('answer', 'question_id');
        return view('superadmin.appointments.show', compact('appointment', 'questions', 'answers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        $patients = User::where('role', 'patient')->where('is_active', true)->get();
        $practitioners = User::where('role', 'admin')->where('is_active', true)->get();
        
        // Get all session types for JavaScript (flat array)
        $sessionTypesForJs = \App\Models\RaqiSessionType::all();
        
        // Get all session types for Blade template (original collection)
        $sessionTypes = \App\Models\RaqiSessionType::all();
        
        // Build available dates for all practitioners
        $availableDates = [];
        foreach ($practitioners as $practitioner) {
            // Determine available treatment types based on specialization
            $availableTypes = collect();
            if ($practitioner->specialization === 'ruqyah_healing') {
                $availableTypes = collect(['ruqyah']);
            } elseif ($practitioner->specialization === 'hijama_cupping') {
                $availableTypes = collect(['hijama']);
            } elseif ($practitioner->specialization === 'both') {
                $availableTypes = collect(['ruqyah', 'hijama']);
            }
            
            // Get available dates for this practitioner
            $dates = \App\Models\RaqiMonthlyAvailability::where('practitioner_id', $practitioner->id)
                ->where('is_available', true)
                ->where('availability_date', '>=', now()->toDateString()) // Only present and future dates
                ->get()
                ->map(function($date) use ($practitioner) {
                    // Get booked times for this date, always format as H:i
                    $bookedTimes = \App\Models\Appointment::where('practitioner_id', $practitioner->id)
                        ->where('appointment_date', $date->availability_date)
                        ->where('status', '!=', 'cancelled')
                        ->pluck('appointment_time')
                        ->map(function($time) {
                            return \Carbon\Carbon::parse($time)->format('H:i');
                        })
                        ->toArray();
                    
                    return [
                        'availability_date' => \Carbon\Carbon::parse($date->availability_date)->format('Y-m-d'),
                        'is_available' => $date->is_available,
                        'start_time' => \Carbon\Carbon::parse($date->start_time)->format('H:i'),
                        'end_time' => \Carbon\Carbon::parse($date->end_time)->format('H:i'),
                        'slot_duration' => $date->slot_duration,
                        'booked_times' => $bookedTimes
                    ];
                })->toArray();
            $availableDates[$practitioner->id] = $dates;
        }
        
        // Get available treatment types for all practitioners
        $availableTypes = [];
        foreach ($practitioners as $practitioner) {
            if ($practitioner->specialization === 'ruqyah_healing') {
                $availableTypes[$practitioner->id] = ['ruqyah'];
            } elseif ($practitioner->specialization === 'hijama_cupping') {
                $availableTypes[$practitioner->id] = ['hijama'];
            } elseif ($practitioner->specialization === 'both') {
                $availableTypes[$practitioner->id] = ['ruqyah', 'hijama'];
            } else {
                $availableTypes[$practitioner->id] = [];
            }
        }
        
        $serverToday = now()->format('Y-m-d');
        
        return view('superadmin.appointments.edit', [
            'appointment' => $appointment,
            'patients' => $patients,
            'practitioners' => $practitioners,
            'sessionTypes' => $sessionTypes,
            'sessionTypesForJs' => $sessionTypesForJs,
            'availableDates' => $availableDates,
            'availableTypes' => $availableTypes,
            'serverToday' => $serverToday,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'practitioner_id' => 'required|exists:users,id',
            'type' => 'required|in:ruqyah,hijama',
            'session_type_id' => 'required|exists:raqi_session_types,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'appointment_end_time' => 'required|date_format:H:i',
            'symptoms' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected,completed',
            'notes' => 'nullable|string',
        ]);

        $validated['updated_by'] = \Illuminate\Support\Facades\Auth::id();
        
        // If session_type_id is provided, also update the session type details
        if (!empty($validated['session_type_id'])) {
            $sessionType = \App\Models\RaqiSessionType::find($validated['session_type_id']);
            if ($sessionType) {
                $validated['session_type_name'] = $sessionType->type;
                $validated['session_type_fee'] = $sessionType->fee;
                $validated['session_type_min_duration'] = $sessionType->min_duration;
                $validated['session_type_max_duration'] = $sessionType->max_duration;
            }
        }
        
        $appointment->update($validated);

        return redirect()->route('superadmin.appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('superadmin.appointments.index')
            ->with('success', 'Appointment deleted successfully.');
    }

    /**
     * Approve an appointment
     */
    public function approve(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'approval_notes' => 'nullable|string',
        ]);

        $appointment->update([
            'status' => 'approved',
            'approved_by' => \Illuminate\Support\Facades\Auth::id(),
            'approved_at' => now(),
            'approval_notes' => $validated['approval_notes'] ?? null,
        ]);

        // Send notification to patient
        $approvedBy = \Illuminate\Support\Facades\Auth::user();
        NotificationService::appointmentApproved($appointment, $approvedBy);
        \App\Services\NotificationService::promptPatientToAnswerQuestions($appointment);

        return redirect()->route('superadmin.appointments.index')
            ->with('success', 'Appointment approved successfully.');
    }

    /**
     * Reject an appointment
     */
    public function reject(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $appointment->update([
            'status' => 'rejected',
            'rejected_by' => \Illuminate\Support\Facades\Auth::id(),
            'rejected_at' => now(),
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        // Send notification to patient
        $rejectedBy = \Illuminate\Support\Facades\Auth::user();
        NotificationService::appointmentRejected($appointment, $rejectedBy, $validated['rejection_reason']);

        return redirect()->route('superadmin.appointments.index')
            ->with('success', 'Appointment rejected successfully.');
    }

    /**
     * Complete an appointment
     */
    public function complete(Appointment $appointment)
    {
        $appointment->update(['status' => 'completed']);

        // Send notification to patient
        $completedBy = \Illuminate\Support\Facades\Auth::user();
        NotificationService::appointmentCompleted($appointment, $completedBy);

        return redirect()->route('superadmin.appointments.index')
            ->with('success', 'Appointment marked as completed.');
    }
}