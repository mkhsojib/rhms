@extends('layouts.app')

@section('title', 'Payments')

@section('content_header')
    <h1>Payments</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Payments</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('superadmin.payments.index') }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="payment_method">Payment Method</label>
                                            <select name="payment_method" id="payment_method" class="form-control">
                                                <option value="">All Methods</option>
                                                @foreach($paymentMethods as $method)
                                                    <option value="{{ $method }}" {{ request('payment_method') == $method ? 'selected' : '' }}>
                                                        {{ ucfirst(str_replace('_', ' ', $method)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="date_from">From Date</label>
                                            <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="date_to">To Date</label>
                                            <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>&nbsp;</label><br>
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="{{ route('superadmin.payments.index') }}" class="btn btn-secondary">Clear</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Payment ID</th>
                                <th>Invoice No</th>
                                <th>Patient</th>
                                <th>Amount</th>
                                <th>Discount</th>
                                <th>Paid Amount</th>
                                <th>Payment Method</th>
                                <th>Paid By</th>
                                <th>Paid At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $payment)
                                <tr>
                                    <td>{{ $payment->id }}</td>
                                    <td>
                                        <a href="{{ route('superadmin.invoices.show', $payment->invoice) }}">
                                            {{ $payment->invoice->invoice_no }}
                                        </a>
                                    </td>
                                    <td>{{ $payment->invoice->patient->name }}</td>
                                    <td>{{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ number_format($payment->discount, 2) }}</td>
                                    <td>{{ number_format($payment->paid_amount, 2) }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                    <td>{{ $payment->payer->name ?? 'N/A' }}</td>
                                    <td>{{ $payment->paid_at ? $payment->paid_at->format('Y-m-d H:i') : 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('superadmin.payments.show', $payment) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">No payments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    <div class="d-flex justify-content-center">
                        {{ $payments->links() }}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
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
