<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicines = Medicine::orderBy('created_at', 'desc')->paginate(15);
        return view('superadmin.medicines.index', compact('medicines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.medicines.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:medicines,name',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'dosage' => 'nullable|string|max:255',
            'instructions' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        Medicine::create($validated);

        return redirect()->route('superadmin.medicines.index')
            ->with('success', 'Medicine created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Medicine $medicine)
    {
        $medicine->load('treatments.appointment.patient');
        return view('superadmin.medicines.show', compact('medicine'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medicine $medicine)
    {
        return view('superadmin.medicines.edit', compact('medicine'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:medicines,name,' . $medicine->id,
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'dosage' => 'nullable|string|max:255',
            'instructions' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $medicine->update($validated);

        return redirect()->route('superadmin.medicines.index')
            ->with('success', 'Medicine updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medicine $medicine)
    {
        // Check if medicine is used in any treatments
        if ($medicine->treatments()->count() > 0) {
            return redirect()->route('superadmin.medicines.index')
                ->with('error', 'Cannot delete medicine that is used in treatments.');
        }

        $medicine->delete();

        return redirect()->route('superadmin.medicines.index')
            ->with('success', 'Medicine deleted successfully.');
    }

    /**
     * Get medicines for AJAX requests
     */
    public function getMedicines(Request $request)
    {
        $medicines = Medicine::active()
            ->when($request->search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                           ->orWhere('description', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->get();

        return response()->json($medicines);
    }
}