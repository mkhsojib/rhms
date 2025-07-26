@extends('layouts.app')')

@section('title', 'Payment Details')

@section('content_header')
    <h1>Payment Details</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Payment #{{ $payment->id }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('superadmin.payments.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Payments
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Payment ID:</th>
                                    <td>{{ $payment->id }}</td>
                                </tr>
                                <tr>
                                    <th>Invoice No:</th>
                                    <td>
                                        <a href="{{ route('superadmin.invoices.show', $payment->invoice) }}">
                                            {{ $payment->invoice->invoice_no }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Amount:</th>
                                    <td>{{ number_format($payment->amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Discount:</th>
                                    <td>{{ number_format($payment->discount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Paid Amount:</th>
                                    <td>{{ number_format($payment->paid_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Method:</th>
                                    <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                </tr>
                                <tr>
                                    <th>Paid By:</th>
                                    <td>{{ $payment->payer->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Paid At:</th>
                                    <td>{{ $payment->paid_at ? $payment->paid_at->format('Y-m-d H:i:s') : 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Patient Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th>Name:</th>
                                    <td>{{ $payment->invoice->patient->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $payment->invoice->patient->email ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td>{{ $payment->invoice->patient->phone ?? 'N/A' }}</td>
                                </tr>
                            </table>
                            
                            <h5>Appointment Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th>Date:</th>
                                    <td>{{ $payment->invoice->appointment->date ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Time:</th>
                                    <td>{{ $payment->invoice->appointment->time ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Treatment Type:</th>
                                    <td>{{ $payment->invoice->appointment->treatment_type ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    @if($payment->notes)
                    <div class="row">
                        <div class="col-12">
                            <h5>Notes</h5>
                            <p>{{ $payment->notes }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    {{-- Add any extra CSS here --}}
@stop

@section('js')
    {{-- Add any extra JS here --}}
@stop
