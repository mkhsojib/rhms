<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_no }}</title>
    <style>@page { size: A4; margin: 20mm; }</style>
</head>
<body>
@include('superadmin.invoices._invoice_body', ['invoice' => $invoice])
<a href="{{ route('admin.invoices.show', $invoice) }}" class="btn btn-secondary">Back</a>
</body>
</html> 