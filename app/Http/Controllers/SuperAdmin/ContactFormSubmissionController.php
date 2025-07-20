<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ContactFormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactFormSubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $submissions = ContactFormSubmission::latest()->paginate(15);
        $stats = [
            'total' => ContactFormSubmission::count(),
            'new' => ContactFormSubmission::new()->count(),
            'read' => ContactFormSubmission::where('status', 'read')->count(),
            'replied' => ContactFormSubmission::where('status', 'replied')->count(),
        ];
        
        return view('superadmin.contact-form-submissions.index', compact('submissions', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.contact-form-submissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        ContactFormSubmission::create($request->all());

        return redirect()->route('superadmin.contact-form-submissions.index')
            ->with('success', 'Contact form submission created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactFormSubmission $contactFormSubmission)
    {
        // Mark as read when viewed
        if ($contactFormSubmission->status === 'new') {
            $contactFormSubmission->markAsRead();
        }
        
        return view('superadmin.contact-form-submissions.show', compact('contactFormSubmission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactFormSubmission $contactFormSubmission)
    {
        return view('superadmin.contact-form-submissions.edit', compact('contactFormSubmission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactFormSubmission $contactFormSubmission)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:new,read,replied,archived',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $contactFormSubmission->update($request->only(['status', 'admin_notes']));

        return redirect()->route('superadmin.contact-form-submissions.index')
            ->with('success', 'Contact form submission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactFormSubmission $contactFormSubmission)
    {
        $contactFormSubmission->delete();

        return redirect()->route('superadmin.contact-form-submissions.index')
            ->with('success', 'Contact form submission deleted successfully.');
    }

    /**
     * Mark submission as read
     */
    public function markAsRead(ContactFormSubmission $contactFormSubmission)
    {
        $contactFormSubmission->markAsRead();
        
        return redirect()->back()->with('success', 'Submission marked as read.');
    }

    /**
     * Mark submission as replied
     */
    public function markAsReplied(ContactFormSubmission $contactFormSubmission)
    {
        $contactFormSubmission->markAsReplied();
        
        return redirect()->back()->with('success', 'Submission marked as replied.');
    }

    /**
     * Filter submissions by status
     */
    public function filter(Request $request)
    {
        $status = $request->get('status', 'all');
        $query = ContactFormSubmission::query();
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $submissions = $query->latest()->paginate(15);
        $stats = [
            'total' => ContactFormSubmission::count(),
            'new' => ContactFormSubmission::new()->count(),
            'read' => ContactFormSubmission::where('status', 'read')->count(),
            'replied' => ContactFormSubmission::where('status', 'replied')->count(),
        ];
        
        return view('superadmin.contact-form-submissions.index', compact('submissions', 'stats', 'status'));
    }
}
