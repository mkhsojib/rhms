<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Symptom;
use Illuminate\Http\Request;

class SymptomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $symptoms = Symptom::orderBy('created_at', 'desc')->paginate(15);
        return view('superadmin.symptoms.index', compact('symptoms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.symptoms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:symptoms,name',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        Symptom::create($validated);

        return redirect()->route('superadmin.symptoms.index')
            ->with('success', 'Symptom created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Symptom $symptom)
    {
        $symptom->load('treatments.appointment.patient');
        return view('superadmin.symptoms.show', compact('symptom'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Symptom $symptom)
    {
        return view('superadmin.symptoms.edit', compact('symptom'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Symptom $symptom)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:symptoms,name,' . $symptom->id,
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $symptom->update($validated);

        return redirect()->route('superadmin.symptoms.index')
            ->with('success', 'Symptom updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Symptom $symptom)
    {
        // Check if symptom is used in any treatments
        if ($symptom->treatments()->count() > 0) {
            return redirect()->route('superadmin.symptoms.index')
                ->with('error', 'Cannot delete symptom that is used in treatments.');
        }

        $symptom->delete();

        return redirect()->route('superadmin.symptoms.index')
            ->with('success', 'Symptom deleted successfully.');
    }

    /**
     * Get symptoms for AJAX requests
     */
    public function getSymptoms(Request $request)
    {
        $symptoms = Symptom::active()
            ->when($request->search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                           ->orWhere('description', 'like', "%{$search}%");
            })
            ->when($request->category, function ($query, $category) {
                return $query->byCategory($category);
            })
            ->orderBy('name')
            ->get();

        return response()->json($symptoms);
    }
}