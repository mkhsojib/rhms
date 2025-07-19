<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RaqiMonthlyAvailability;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RaqiAvailabilityController extends Controller
{
    /**
     * Display a listing of the raqi's availability.
     */
    public function index()
    {
        $currentDate = Carbon::now();
        $endDate = (clone $currentDate)->addMonth();
        
        $availabilities = RaqiMonthlyAvailability::where('practitioner_id', Auth::id())
            ->where('availability_date', '>=', $currentDate->format('Y-m-d'))
            ->where('availability_date', '<=', $endDate->format('Y-m-d'))
            ->orderBy('availability_date')
            ->get();
        
        // Get all appointments for this raqi in the date range
        $appointments = Appointment::where('practitioner_id', Auth::id())
            ->where('appointment_date', '>=', $currentDate->format('Y-m-d'))
            ->where('appointment_date', '<=', $endDate->format('Y-m-d'))
            ->get()
            ->groupBy(function($appointment) {
                // Parse the appointment_date string to a Carbon object before formatting
                return \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d');
            });
        
        return view('admin.availability.index', compact('availabilities', 'appointments', 'currentDate', 'endDate'));
    }
    
    /**
     * Show the form for creating a new availability.
     */
    public function create()
    {
        return view('admin.availability.create');
    }
    
    /**
     * Store a newly created availability in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'availability_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'slot_duration' => 'required|integer|min:15|max:120',
            'is_available' => 'sometimes|boolean',
            'notes' => 'nullable|string',
        ]);
        
        // Check if an availability already exists for this date
        $existingAvailability = RaqiMonthlyAvailability::where('practitioner_id', Auth::id())
            ->where('availability_date', $validated['availability_date'])
            ->first();
            
        if ($existingAvailability) {
            return redirect()->route('admin.availability.index')
                ->with('error', 'You already have availability set for this date. Please edit the existing one.');
        }
        
        // Set default values
        $validated['practitioner_id'] = Auth::id();
        $validated['is_available'] = (bool)$request->input('is_available', false);
        
        RaqiMonthlyAvailability::create($validated);
        
        return redirect()->route('admin.availability.index')
            ->with('success', 'Availability has been set successfully.');
    }
    
    /**
     * Show the form for editing the specified availability.
     */
    public function edit(RaqiMonthlyAvailability $availability)
    {
        // Ensure the availability belongs to the current raqi
        if ($availability->practitioner_id !== Auth::id()) {
            abort(403, 'Unauthorized access to availability.');
        }
        
        return view('admin.availability.edit', compact('availability'));
    }
    
    /**
     * Update the specified availability in storage.
     */
    public function update(Request $request, RaqiMonthlyAvailability $availability)
    {
        // Ensure the availability belongs to the current raqi
        if ($availability->practitioner_id !== Auth::id()) {
            abort(403, 'Unauthorized access to availability.');
        }
        
        $validated = $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'slot_duration' => 'required|integer|min:15|max:120',
            'is_available' => 'sometimes|boolean',
            'notes' => 'nullable|string',
        ]);
        
        // Set default values
        $validated['is_available'] = (bool)$request->input('is_available', false);
        
        $availability->update($validated);
        
        return redirect()->route('admin.availability.index')
            ->with('success', 'Availability has been updated successfully.');
    }
    
    /**
     * Remove the specified availability from storage.
     */
    public function destroy(RaqiMonthlyAvailability $availability)
    {
        // Ensure the availability belongs to the current raqi
        if ($availability->practitioner_id !== Auth::id()) {
            abort(403, 'Unauthorized access to availability.');
        }
        
        // Check if there are any appointments for this date
        $hasAppointments = Appointment::where('practitioner_id', Auth::id())
            ->where('appointment_date', $availability->availability_date)
            ->exists();
            
        if ($hasAppointments) {
            return redirect()->route('admin.availability.index')
                ->with('error', 'Cannot delete availability as there are appointments scheduled for this date.');
        }
        
        $availability->delete();
        
        return redirect()->route('admin.availability.index')
            ->with('success', 'Availability has been deleted successfully.');
    }
    
    /**
     * Get available time slots for a specific date and raqi.
     */
    public function getAvailableTimeSlots(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'practitioner_id' => 'required|exists:users,id',
        ]);
        
        $date = $request->input('date');
        $practitionerId = $request->input('practitioner_id');
        
        // Get the availability for this date and raqi
        $availability = RaqiMonthlyAvailability::where('practitioner_id', $practitionerId)
            ->where('availability_date', $date)
            ->where('is_available', true)
            ->first();
            
        if (!$availability) {
            return response()->json([
                'available' => false,
                'message' => 'No availability found for this date.',
                'slots' => []
            ]);
        }
        
        // Get all time slots for this availability
        $allSlots = $availability->generateTimeSlots();
        
        // Get all appointments for this date and raqi
        $bookedSlots = Appointment::where('practitioner_id', $practitionerId)
            ->where('appointment_date', $date)
            ->pluck('appointment_time')
            ->toArray();
        
        // Mark slots as available or booked
        $slots = [];
        foreach ($allSlots as $slot) {
            $isBooked = in_array($slot['start'], $bookedSlots);
            $slots[] = [
                'start' => $slot['start'],
                'end' => $slot['end'],
                'available' => !$isBooked,
            ];
        }
        
        return response()->json([
            'available' => true,
            'message' => 'Available time slots retrieved successfully.',
            'slots' => $slots
        ]);
    }
}
