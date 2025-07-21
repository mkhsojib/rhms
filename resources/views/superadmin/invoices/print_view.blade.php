@extends('layouts.app')

@section('content')
<style>
@media print {
    .no-print { display: none !important; }
}
</style>
<div class="no-print mb-3">
    <a href="{{ route('superadmin.invoices.show', $invoice) }}" class="btn btn-secondary">Back</a>
    <button onclick="window.print()" class="btn btn-primary">Print Invoice</button>
</div>
@include('superadmin.invoices._invoice_body', ['invoice' => $invoice])
@endsection 