<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Treatment;
use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    /**
     * Display a listing of all treatments (super admin can see all)
     */
    public function index()
    {
        $treatments = Treatment::with(['appointment.patient', 'appointment.practitioner'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('superadmin.treatments.index', compact('treatments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $appointments = Appointment::where('status', 'approved')
            ->whereDoesntHave('treatment')
            ->with(['patient', 'practitioner'])
            ->get();

        return view('superadmin.treatments.create', compact('appointments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id|unique:treatments,appointment_id',
            'treatment_date' => 'required|date',
            'duration' => 'required|integer|min:15|max:480',
            'cost' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'outcome' => 'required|in:successful,partial,unsuccessful',
        ]);

        $validated['created_by'] = \Illuminate\Support\Facades\Auth::id();
        Treatment::create($validated);

        return redirect()->route('superadmin.treatments.index')
            ->with('success', 'Treatment record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Treatment $treatment)
    {
        $treatment->load(['appointment.patient', 'appointment.practitioner']);
        return view('superadmin.treatments.show', compact('treatment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Treatment $treatment)
    {
        $appointments = Appointment::where('status', 'approved')
            ->where(function ($query) use ($treatment) {
                $query->whereDoesntHave('treatment')
                      ->orWhere('id', $treatment->appointment_id);
            })
            ->with(['patient', 'practitioner'])
            ->get();

        return view('superadmin.treatments.edit', compact('treatment', 'appointments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Treatment $treatment)
    {
        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id|unique:treatments,appointment_id,' . $treatment->id,
            'treatment_date' => 'required|date',
            'duration' => 'required|integer|min:15|max:480',
            'cost' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'outcome' => 'required|in:successful,partial,unsuccessful',
        ]);

        $validated['updated_by'] = \Illuminate\Support\Facades\Auth::id();
        $treatment->update($validated);

        return redirect()->route('superadmin.treatments.index')
            ->with('success', 'Treatment record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Treatment $treatment)
    {
        $treatment->delete();

        return redirect()->route('superadmin.treatments.index')
            ->with('success', 'Treatment record deleted successfully.');
    }
} 