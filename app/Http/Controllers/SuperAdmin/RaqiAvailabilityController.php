<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\RaqiMonthlyAvailability;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RaqiAvailabilityController extends Controller
{
    /**
     * Display a listing of all raqis' availability.
     */
    public function index()
    {
        $currentDate = Carbon::now();
        $endDate = (clone $currentDate)->addMonth();
        
        // Get all practitioners (raqis)
        $practitioners = User::where('role', 'admin')->get();
        
        // Get all availabilities for statistics (without pagination)
        $allAvailabilities = RaqiMonthlyAvailability::where('availability_date', '>=', $currentDate->format('Y-m-d'))
            ->where('availability_date', '<=', $endDate->format('Y-m-d'))
            ->get();
        
        // Get statistics for summary cards
        $totalAvailabilities = $allAvailabilities->count();
        $availableDays = $allAvailabilities->where('is_available', true)->count();
        $unavailableDays = $allAvailabilities->where('is_available', false)->count();
        
        return view('superadmin.raqi-availability.index', compact('practitioners', 'totalAvailabilities', 'availableDays', 'unavailableDays'));
    }
    
    /**
     * Show the form for creating a new availability.
     */
    public function create()
    {
        $practitioners = User::where('role', 'admin')->get();
        return view('superadmin.raqi-availability.create', compact('practitioners'));
    }
    
    /**
     * Store a newly created availability in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'practitioner_id' => 'required|exists:users,id',
            'availability_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'slot_duration' => 'required|integer|min:15|max:120',
            'is_available' => 'sometimes|boolean',
            'notes' => 'nullable|string',
        ]);
        
        // Check if an availability already exists for this date and practitioner
        $existingAvailability = RaqiMonthlyAvailability::where('practitioner_id', $validated['practitioner_id'])
            ->where('availability_date', $validated['availability_date'])
            ->first();
            
        if ($existingAvailability) {
            return redirect()->route('superadmin.raqi-availability.index')
                ->with('error', 'This practitioner already has availability set for this date. Please edit the existing one.');
        }
        
        // Set default values
        $validated['is_available'] = (bool)$request->input('is_available', true);
        
        RaqiMonthlyAvailability::create($validated);
        
        return redirect()->route('superadmin.raqi-availability.index')
            ->with('success', 'Availability has been set successfully.');
    }
    
    /**
     * Show the form for editing the specified availability.
     */
    public function edit(RaqiMonthlyAvailability $availability)
    {
        $practitioners = User::where('role', 'admin')->get();
        return view('superadmin.raqi-availability.edit', compact('availability', 'practitioners'));
    }
    
    /**
     * Update the specified availability in storage.
     */
    public function update(Request $request, RaqiMonthlyAvailability $availability)
    {
        $validated = $request->validate([
            'practitioner_id' => 'required|exists:users,id',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'slot_duration' => 'required|integer|min:15|max:120',
            'is_available' => 'sometimes|boolean',
            'notes' => 'nullable|string',
        ]);
        
        // Set default values
        $validated['is_available'] = (bool)$request->input('is_available', true);
        
        $availability->update($validated);
        
        return redirect()->route('superadmin.raqi-availability.index')
            ->with('success', 'Availability has been updated successfully.');
    }
    
    /**
     * Remove the specified availability from storage.
     */
    public function destroy(RaqiMonthlyAvailability $availability)
    {
        // Check if there are any appointments for this date and practitioner
        $hasAppointments = Appointment::where('practitioner_id', $availability->practitioner_id)
            ->where('appointment_date', $availability->availability_date)
            ->exists();
            
        if ($hasAppointments) {
            return redirect()->route('superadmin.raqi-availability.index')
                ->with('error', 'Cannot delete availability as there are appointments scheduled for this date.');
        }
        
        $availability->delete();
        
        return redirect()->route('superadmin.raqi-availability.index')
            ->with('success', 'Availability has been deleted successfully.');
    }
    
    /**
     * Show the specified availability.
     */
    public function show(RaqiMonthlyAvailability $availability)
    {
        $availability->load('practitioner');
        
        // Get appointments for this date and practitioner
        $appointments = Appointment::where('practitioner_id', $availability->practitioner_id)
            ->where('appointment_date', $availability->availability_date)
            ->with('user')
            ->get();
        
        return view('superadmin.raqi-availability.show', compact('availability', 'appointments'));
    }

    /**
     * Show availability for a specific practitioner.
     */
    public function byPractitioner(User $practitioner)
    {
        $currentDate = Carbon::now();
        $endDate = (clone $currentDate)->addMonth();
        
        $availabilities = RaqiMonthlyAvailability::where('practitioner_id', $practitioner->id)
            ->where('availability_date', '>=', $currentDate->format('Y-m-d'))
            ->where('availability_date', '<=', $endDate->format('Y-m-d'))
            ->orderBy('availability_date')
            ->orderBy('start_time')
            ->paginate(20);
        
        // Get all appointments for this practitioner in the date range
        $appointments = Appointment::where('practitioner_id', $practitioner->id)
            ->where('appointment_date', '>=', $currentDate->format('Y-m-d'))
            ->where('appointment_date', '<=', $endDate->format('Y-m-d'))
            ->get()
            ->groupBy(function($appointment) {
                return \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d');
            });
        
        // Get statistics for this practitioner
        $totalAvailabilities = RaqiMonthlyAvailability::where('practitioner_id', $practitioner->id)
            ->where('availability_date', '>=', $currentDate->format('Y-m-d'))
            ->where('availability_date', '<=', $endDate->format('Y-m-d'))
            ->count();
        $availableDays = RaqiMonthlyAvailability::where('practitioner_id', $practitioner->id)
            ->where('availability_date', '>=', $currentDate->format('Y-m-d'))
            ->where('availability_date', '<=', $endDate->format('Y-m-d'))
            ->where('is_available', true)
            ->count();
        $unavailableDays = RaqiMonthlyAvailability::where('practitioner_id', $practitioner->id)
            ->where('availability_date', '>=', $currentDate->format('Y-m-d'))
            ->where('availability_date', '<=', $endDate->format('Y-m-d'))
            ->where('is_available', false)
            ->count();
        
        return view('superadmin.raqi-availability.by-practitioner', compact(
            'practitioner', 
            'availabilities', 
            'appointments', 
            'currentDate', 
            'endDate', 
            'totalAvailabilities', 
            'availableDays', 
            'unavailableDays'
        ));
    }
} 