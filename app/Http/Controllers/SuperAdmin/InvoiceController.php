<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::with(['appointment', 'patient', 'practitioner'])
            ->orderByDesc('created_at')
            ->paginate(20);
        return view('superadmin.invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['appointment', 'patient', 'practitioner']);
        return view('superadmin.invoices.show', compact('invoice'));
    }

    public function print(Invoice $invoice)
    {
        $invoice->load(['appointment', 'patient', 'practitioner']);
        return view('superadmin.invoices.print_view', compact('invoice'));
    }

    public function download(Invoice $invoice)
    {
        $invoice->load(['appointment', 'patient', 'practitioner']);
        $pdf = Pdf::loadView('superadmin.invoices.print', compact('invoice'));
        $filename = 'Invoice_' . $invoice->invoice_no . '.pdf';
        return $pdf->download($filename);
    }
} 