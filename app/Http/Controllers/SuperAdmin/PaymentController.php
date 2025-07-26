<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['invoice', 'invoice.appointment', 'invoice.patient', 'payer']);
        
        // Filters
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('paid_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('paid_at', '<=', $request->date_to);
        }
        
        if ($request->filled('patient_id')) {
            $query->whereHas('invoice', function($q) use ($request) {
                $q->where('patient_id', $request->patient_id);
            });
        }
        
        $payments = $query->orderByDesc('paid_at')->paginate(20);
        
        // Get payment methods for filter dropdown
        $paymentMethods = Payment::select('payment_method')->distinct()->pluck('payment_method');
        
        return view('superadmin.payments.index', compact('payments', 'paymentMethods'));
    }
    
    public function show(Payment $payment)
    {
        $payment->load(['invoice', 'invoice.appointment', 'invoice.patient', 'invoice.practitioner', 'payer']);
        return view('superadmin.payments.show', compact('payment'));
    }
}
