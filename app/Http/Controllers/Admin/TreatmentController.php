<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $treatments = Treatment::with(['appointment.patient', 'appointment.practitioner'])
            ->where('practitioner_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.treatments.index', compact('treatments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $selectedAppointment = null;
        
        // If appointment_id is provided in the URL, get that specific appointment
        if ($request->has('appointment_id')) {
            $selectedAppointment = Appointment::where('id', $request->appointment_id)
                ->where('practitioner_id', Auth::id())
                ->whereIn('status', ['confirmed', 'approved'])
                ->whereDoesntHave('treatment')
                ->with('patient')
                ->first();
                
            if (!$selectedAppointment) {
                return redirect()->route('admin.treatments.create')
                    ->with('error', 'Invalid appointment or appointment already has a treatment.');
            }
        }
        
        // Get all available appointments for the dropdown (if no specific appointment is selected)
        $appointments = Appointment::where('practitioner_id', Auth::id())
            ->whereIn('status', ['confirmed', 'approved'])
            ->whereDoesntHave('treatment')
            ->with('patient')
            ->get();

        return view('admin.treatments.create', compact('appointments', 'selectedAppointment'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'treatment_type' => 'required|in:ruqyah,hijama,both',
            'treatment_date' => 'required|date',
            'status' => 'required|in:scheduled,in_progress,completed',
            'notes' => 'nullable|string',
            'duration' => 'nullable|integer|min:1|max:480',
            'cost' => 'nullable|numeric|min:0',
        ]);

        // Verify the appointment belongs to the current practitioner
        $appointment = Appointment::where('id', $validated['appointment_id'])
            ->where('practitioner_id', Auth::id())
            ->firstOrFail();

        $validated['practitioner_id'] = Auth::id();
        $validated['created_by'] = Auth::id();

        Treatment::create($validated);

        return redirect()->route('admin.treatments.index')
            ->with('success', 'Treatment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Treatment $treatment)
    {
        // Check if the treatment belongs to the current practitioner
        if ($treatment->practitioner_id !== Auth::id()) {
            abort(403, 'Unauthorized access to treatment.');
        }
        
        $treatment->load(['appointment.patient', 'appointment.practitioner']);
        return view('admin.treatments.show', compact('treatment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Treatment $treatment)
    {
        // Check if the treatment belongs to the current practitioner
        if ($treatment->practitioner_id !== Auth::id()) {
            abort(403, 'Unauthorized access to treatment.');
        }

        $appointments = Appointment::where('practitioner_id', Auth::id())
            ->whereIn('status', ['confirmed', 'approved'])
            ->with('patient')
            ->get();
        
        return view('admin.treatments.edit', compact('treatment', 'appointments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Treatment $treatment)
    {
        // Check if the treatment belongs to the current practitioner
        if ($treatment->practitioner_id !== Auth::id()) {
            abort(403, 'Unauthorized access to treatment.');
        }

        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'treatment_type' => 'required|in:ruqyah,hijama,both',
            'treatment_date' => 'required|date',
            'status' => 'required|in:scheduled,in_progress,completed',
            'notes' => 'nullable|string',
            'duration' => 'nullable|integer|min:1|max:480',
            'cost' => 'nullable|numeric|min:0',
        ]);

        // Verify the appointment belongs to the current practitioner
        $appointment = Appointment::where('id', $validated['appointment_id'])
            ->where('practitioner_id', Auth::id())
            ->firstOrFail();

        $validated['updated_by'] = Auth::id();
        $treatment->update($validated);

        return redirect()->route('admin.treatments.index')
            ->with('success', 'Treatment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Treatment $treatment)
    {
        // Check if the treatment belongs to the current practitioner
        if ($treatment->practitioner_id !== Auth::id()) {
            abort(403, 'Unauthorized access to treatment.');
        }

        $treatment->delete();

        return redirect()->route('admin.treatments.index')
            ->with('success', 'Treatment deleted successfully.');
    }
}
