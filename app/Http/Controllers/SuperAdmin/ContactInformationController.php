<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ContactInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ContactInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contactInfo = ContactInformation::first();
        return view('superadmin.contact-information.index', compact('contactInfo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.contact-information.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'business_hours' => 'nullable|string',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'whatsapp_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'contact_form_title' => 'nullable|string|max:255',
            'contact_form_description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle checkbox state - unchecked checkboxes don't send any value
        $data = $request->all();
        $data['is_active'] = $request->has('is_active') ? true : false;

        // Debug: Log the checkbox state
        Log::info('Contact Information Create', [
            'has_is_active' => $request->has('is_active'),
            'is_active_value' => $data['is_active']
        ]);

        // Deactivate all existing records
        ContactInformation::query()->update(['is_active' => false]);

        // Create new record
        ContactInformation::create($data);

        return redirect()->route('superadmin.contact-information.index')
            ->with('success', 'Contact information created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactInformation $contactInformation)
    {
        return view('superadmin.contact-information.show', compact('contactInformation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactInformation $contactInformation)
    {
        return view('superadmin.contact-information.edit', compact('contactInformation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactInformation $contactInformation)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'business_hours' => 'nullable|string',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'whatsapp_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'contact_form_title' => 'nullable|string|max:255',
            'contact_form_description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle checkbox state - unchecked checkboxes don't send any value
        $data = $request->all();
        $data['is_active'] = $request->has('is_active') ? true : false;

        // Debug: Log the checkbox state
        Log::info('Contact Information Update', [
            'has_is_active' => $request->has('is_active'),
            'is_active_value' => $data['is_active'],
            'contact_info_id' => $contactInformation->id
        ]);

        // If this record is being activated, deactivate all others
        if ($data['is_active']) {
            ContactInformation::where('id', '!=', $contactInformation->id)
                ->update(['is_active' => false]);
        }

        $contactInformation->update($data);

        return redirect()->route('superadmin.contact-information.index')
            ->with('success', 'Contact information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactInformation $contactInformation)
    {
        $contactInformation->delete();

        return redirect()->route('superadmin.contact-information.index')
            ->with('success', 'Contact information deleted successfully.');
    }
}
