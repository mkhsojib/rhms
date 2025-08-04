<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Treatment;
use App\Models\Medicine;
use App\Models\Symptom;
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
        
        $medicines = Medicine::active()->orderBy('name')->get();
        $symptoms = Symptom::active()->orderBy('name')->get();

        return view('superadmin.treatments.create', compact('appointments', 'medicines', 'symptoms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id|unique:treatments,appointment_id',
            'treatment_date' => 'required|date',
            'notes' => 'nullable|string',
            'creation_notes' => 'nullable|string',
            'symptoms' => 'nullable|array',
            'symptoms.*' => 'exists:symptoms,id',
            'symptom_severity' => 'nullable|array',
            'symptom_notes' => 'nullable|array',
            'medicines' => 'nullable|array',
            'medicines.*' => 'exists:medicines,id',
            'medicine_timing' => 'nullable|array',
            'medicine_dosage' => 'nullable|array',
            'medicine_instructions' => 'nullable|array',
            'medicine_duration' => 'nullable|array',
        ]);

        // Get the practitioner_id from the selected appointment
        $appointment = Appointment::findOrFail($validated['appointment_id']);
        $validated['practitioner_id'] = $appointment->practitioner_id;
        $validated['created_by'] = \Illuminate\Support\Facades\Auth::id();
        
        $treatment = Treatment::create($validated);

        // Attach symptoms
        if ($request->has('symptoms')) {
            foreach ($request->symptoms as $index => $symptomId) {
                $treatment->symptoms()->attach($symptomId, [
                    'severity' => $request->symptom_severity[$index] ?? 'moderate',
                    'notes' => $request->symptom_notes[$index] ?? null,
                ]);
            }
        }

        // Attach medicines
        if ($request->has('medicines')) {
            foreach ($request->medicines as $index => $medicineId) {
                $timing = $request->medicine_timing[$index] ?? [];
                $treatment->medicines()->attach($medicineId, [
                    'morning' => in_array('morning', $timing),
                    'noon' => in_array('noon', $timing),
                    'afternoon' => in_array('afternoon', $timing),
                    'night' => in_array('night', $timing),
                    'dosage' => $request->medicine_dosage[$index] ?? null,
                    'instructions' => $request->medicine_instructions[$index] ?? null,
                    'duration_days' => $request->medicine_duration[$index] ?? 7,
                ]);
            }
        }

        return redirect()->route('superadmin.treatments.index')
            ->with('success', 'Treatment record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Treatment $treatment)
    {
        $treatment->load(['appointment.patient', 'appointment.practitioner', 'medicines', 'symptoms', 'createdBy', 'updatedBy']);
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
        
        $medicines = Medicine::active()->orderBy('name')->get();
        $symptoms = Symptom::active()->orderBy('name')->get();
        $treatment->load(['medicines', 'symptoms']);

        return view('superadmin.treatments.edit', compact('treatment', 'appointments', 'medicines', 'symptoms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Treatment $treatment)
    {
        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id|unique:treatments,appointment_id,' . $treatment->id,
            'treatment_date' => 'required|date',
            'notes' => 'nullable|string',
            'update_notes' => 'nullable|string',
            'symptoms' => 'nullable|array',
            'symptoms.*' => 'exists:symptoms,id',
            'symptom_severity' => 'nullable|array',
            'symptom_notes' => 'nullable|array',
            'medicines' => 'nullable|array',
            'medicines.*' => 'exists:medicines,id',
            'medicine_timing' => 'nullable|array',
            'medicine_dosage' => 'nullable|array',
            'medicine_instructions' => 'nullable|array',
            'medicine_duration' => 'nullable|array',
        ]);

        $validated['updated_by'] = \Illuminate\Support\Facades\Auth::id();
        $treatment->update($validated);

        // Sync symptoms
        $treatment->symptoms()->detach();
        if ($request->has('symptoms')) {
            foreach ($request->symptoms as $index => $symptomId) {
                $treatment->symptoms()->attach($symptomId, [
                    'severity' => $request->symptom_severity[$index] ?? 'moderate',
                    'notes' => $request->symptom_notes[$index] ?? null,
                ]);
            }
        }

        // Sync medicines
        $treatment->medicines()->detach();
        if ($request->has('medicines')) {
            foreach ($request->medicines as $index => $medicineId) {
                $timing = $request->medicine_timing[$index] ?? [];
                $treatment->medicines()->attach($medicineId, [
                    'morning' => in_array('morning', $timing),
                    'noon' => in_array('noon', $timing),
                    'afternoon' => in_array('afternoon', $timing),
                    'night' => in_array('night', $timing),
                    'dosage' => $request->medicine_dosage[$index] ?? null,
                    'instructions' => $request->medicine_instructions[$index] ?? null,
                    'duration_days' => $request->medicine_duration[$index] ?? 7,
                ]);
            }
        }

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