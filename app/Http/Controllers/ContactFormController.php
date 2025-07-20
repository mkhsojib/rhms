<?php

namespace App\Http\Controllers;

use App\Models\ContactFormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactFormController extends Controller
{
    /**
     * Handle contact form submission
     */
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please check your input and try again.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            ContactFormSubmission::create($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Thank you for your message! We will contact you soon, In Sha Allah.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again later.'
            ], 500);
        }
    }
}
