@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4 d-flex justify-content-center">
        <a href="{{ route('admin.invoices.print', $invoice) }}" class="btn btn-primary mx-2" target="_blank">
            <i class="fas fa-print"></i> Print Invoice
        </a>
        <a href="{{ route('admin.invoices.download', $invoice) }}" class="btn btn-success mx-2" target="_blank">
            <i class="fas fa-file-pdf"></i> Download PDF
        </a>
        @if($invoice->status !== 'paid')
        <a href="{{ route('admin.invoices.payPage', $invoice) }}" class="btn btn-warning mx-2">
            <i class="fas fa-credit-card"></i> Pay Now
        </a>
        @endif
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Invoice Details</h3>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Invoice No</dt>
                <dd class="col-sm-9">{{ $invoice->invoice_no }}</dd>

                <dt class="col-sm-3">Appointment No</dt>
                <dd class="col-sm-9">{{ $invoice->appointment->appointment_no ?? '-' }}</dd>

                <dt class="col-sm-3">Patient</dt>
                <dd class="col-sm-9">{{ $invoice->patient->name ?? '-' }}</dd>

                <dt class="col-sm-3">Amount</dt>
                <dd class="col-sm-9">{{ number_format($invoice->amount, 2) }}</dd>

                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9">{{ ucfirst($invoice->status) }}</dd>

                <dt class="col-sm-3">Created At</dt>
                <dd class="col-sm-9">{{ $invoice->created_at->format('Y-m-d H:i') }}</dd>
            </dl>
            <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection 