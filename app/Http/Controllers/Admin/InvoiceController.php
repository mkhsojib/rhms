<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::with(['appointment', 'patient'])
            ->where('practitioner_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(20);
        return view('admin.invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        // Only allow access if the current user is the practitioner
        abort_unless($invoice->practitioner_id === Auth::id(), 403);
        $invoice->load(['appointment', 'patient']);
        return view('admin.invoices.show', compact('invoice'));
    }

    public function print(Invoice $invoice)
    {
        abort_unless($invoice->practitioner_id === Auth::id(), 403);
        $invoice->load(['appointment', 'patient']);
        return view('superadmin.invoices.print_view', compact('invoice'));
    }

    public function download(Invoice $invoice)
    {
        abort_unless($invoice->practitioner_id === Auth::id(), 403);
        $invoice->load(['appointment', 'patient']);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('superadmin.invoices.print', compact('invoice'));
        $filename = 'Invoice_' . $invoice->invoice_no . '.pdf';
        return $pdf->download($filename);
    }
} 