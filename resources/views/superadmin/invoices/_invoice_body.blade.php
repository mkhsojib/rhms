<style>
.page-a4 {
    width: 210mm;
    min-height: 297mm;
    padding: 20mm;
    margin: auto;
    background: #fff;
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
    font-family: Arial, sans-serif;
    color: #222;
}
.invoice-header { border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 10px; display: flex; justify-content: space-between; align-items: center; }
.invoice-logo { height: 60px; }
.invoice-title { font-size: 2.2em; font-weight: bold; letter-spacing: 2px; }
.business-info { font-size: 1em; margin-bottom: 10px; }
.invoice-info, .invoice-to { margin-bottom: 20px; }
.invoice-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
.invoice-table th, .invoice-table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
.invoice-table th { background: #f5f5f5; }
.invoice-footer { border-top: 1px solid #ccc; padding-top: 10px; font-size: 0.95em; color: #888; text-align: center; margin-top: 40px; }
.text-right { text-align: right; }
</style>
<div class="page-a4">
    <div class="invoice-header">
        <div>
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="invoice-logo" onerror="this.style.display='none'">
            <div class="business-info">
                <strong>Business Name</strong><br>
                123 Clinic Street, City, Country<br>
                Phone: (123) 456-7890<br>
                Email: info@clinic.com
            </div>
        </div>
        <div class="invoice-title">INVOICE</div>
    </div>
    <div style="display: flex; justify-content: space-between;">
        <div class="invoice-info">
            <strong>Invoice No:</strong> {{ $invoice->invoice_no }}<br>
            <strong>Date:</strong> {{ $invoice->created_at->format('Y-m-d') }}<br>
            <strong>Status:</strong> {{ ucfirst($invoice->status) }}<br>
        </div>
        <div class="invoice-to">
            <strong>Billed To:</strong><br>
            {{ $invoice->patient->name ?? '-' }}<br>
            @if($invoice->patient && $invoice->patient->phone)
                Phone: {{ $invoice->patient->phone }}<br>
            @endif
            @if($invoice->patient && $invoice->patient->address)
                Address: {{ $invoice->patient->address }}<br>
            @endif
        </div>
    </div>
    <table class="invoice-table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Practitioner</th>
                <th>Appointment No</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $invoice->appointment->type ?? '-' }} Session</td>
                <td>{{ $invoice->practitioner->name ?? '-' }}</td>
                <td>{{ $invoice->appointment->appointment_no ?? '-' }}</td>
                <td>{{ number_format($invoice->amount, 2) }}</td>
            </tr>
        </tbody>
    </table>
    <div class="text-right" style="font-size: 1.2em; margin-bottom: 30px;">
        <strong>Total: {{ number_format($invoice->amount, 2) }}</strong>
    </div>
    <div class="invoice-footer">
        Thank you for your business.<br>
        <span style="font-size:0.9em;">This is a computer-generated invoice and does not require a signature.</span>
    </div>
</div> 