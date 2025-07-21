@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">My Invoices</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Invoice No</th>
                        <th>Appointment No</th>
                        <th>Patient</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->invoice_no }}</td>
                            <td>{{ $invoice->appointment->appointment_no ?? '-' }}</td>
                            <td>{{ $invoice->patient->name ?? '-' }}</td>
                            <td>{{ number_format($invoice->amount, 2) }}</td>
                            <td>{{ ucfirst($invoice->status) }}</td>
                            <td>{{ $invoice->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.invoices.show', $invoice) }}" class="btn btn-sm btn-primary">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7">No invoices found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $invoices->links() }}
        </div>
    </div>
</div>
@endsection 