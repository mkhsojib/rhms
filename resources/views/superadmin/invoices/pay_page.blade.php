@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Pay Invoice #{{ $invoice->invoice_no }}</h3>
                </div>
                <div class="card-body">
                    <form id="payForm" method="POST" action="{{ route('superadmin.invoices.storePayment', $invoice) }}">
                        @csrf
                        @if($invoice->appointment->type === 'ruqyah')
                            <div class="form-group">
                                <label>Session Type</label>
                                <input type="text" class="form-control" value="{{ ucfirst($invoice->appointment->session_type_name) }}" readonly>
                            </div>
                            <div class="form-group">
                                <label>Session Price</label>
                                <input type="number" step="0.01" min="0" name="amount" id="ruqyah_amount" class="form-control" value="{{ $invoice->amount }}" required>
                            </div>
                            <div class="form-group">
                                <label>Discount</label>
                                <input type="number" step="0.01" min="0" name="discount" id="ruqyah_discount" class="form-control" value="0">
                            </div>
                            <div class="form-group">
                                <label>Total</label>
                                <input type="number" step="0.01" min="0" name="paid_amount" id="ruqyah_total" class="form-control" value="{{ $invoice->amount }}" readonly>
                            </div>
                        @elseif($invoice->appointment->type === 'hijama')
                            <div class="form-group">
                                <label>Head Cup Price</label>
                                <input type="number" step="0.01" min="0" id="head_cup_price" name="head_cup_price" class="form-control" value="{{ $invoice->amount }}">
                            </div>
                            <div class="form-group">
                                <label>Head Cup Qty</label>
                                <input type="number" min="0" id="head_cup_qty" name="head_cup_qty" class="form-control" value="0">
                            </div>
                            <div class="form-group">
                                <label>Body Cup Price</label>
                                <input type="number" step="0.01" min="0" id="body_cup_price" name="body_cup_price" class="form-control" value="{{ $invoice->amount }}">
                            </div>
                            <div class="form-group">
                                <label>Body Cup Qty</label>
                                <input type="number" min="0" id="body_cup_qty" name="body_cup_qty" class="form-control" value="0">
                            </div>
                            <div class="form-group">
                                <label>Discount</label>
                                <input type="number" step="0.01" min="0" id="hijama_discount" class="form-control" value="0">
                            </div>
                            <div class="form-group">
                                <label>Total</label>
                                <input type="number" step="0.01" min="0" name="paid_amount" id="hijama_total" class="form-control" value="0" readonly>
                            </div>
                            <input type="hidden" name="amount" id="hijama_amount" value="0">
                            <input type="hidden" name="discount" id="hijama_discount_hidden" value="0">
                        @endif
                        <div class="form-group">
                            <label>Payment Method</label>
                            <select name="payment_method" id="payment_method" class="form-control" required>
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                                <option value="bank">Bank Transfer</option>
                                <option value="cash_in">Cash In</option>
                            </select>
                        </div>
                        <div class="form-group" id="bank_account_group">
                            <label>Bank Account</label>
                            <select name="bank_account_id" class="form-control">
                                <option value="">Select Bank</option>
                                @foreach($bankAccounts as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->account_name }} ({{ $bank->bank_name }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Notes</label>
                            <textarea name="notes" class="form-control" rows="2"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Submit Payment</button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function updateRuqyahTotal() {
  var amount = parseFloat(document.getElementById('ruqyah_amount').value) || 0;
  var discount = parseFloat(document.getElementById('ruqyah_discount').value) || 0;
  document.getElementById('ruqyah_total').value = (amount - discount).toFixed(2);
}
document.getElementById('ruqyah_amount')?.addEventListener('input', updateRuqyahTotal);
document.getElementById('ruqyah_discount')?.addEventListener('input', updateRuqyahTotal);

function updateHijamaTotal() {
  var headPrice = parseFloat(document.getElementById('head_cup_price').value) || 0;
  var headQty = parseInt(document.getElementById('head_cup_qty').value) || 0;
  var bodyPrice = parseFloat(document.getElementById('body_cup_price').value) || 0;
  var bodyQty = parseInt(document.getElementById('body_cup_qty').value) || 0;
  var discount = parseFloat(document.getElementById('hijama_discount').value) || 0;
  var total = (headPrice * headQty) + (bodyPrice * bodyQty) - discount;
  document.getElementById('hijama_total').value = total.toFixed(2);
  document.getElementById('hijama_amount').value = (headPrice * headQty + bodyPrice * bodyQty).toFixed(2);
  document.getElementById('hijama_discount_hidden').value = discount.toFixed(2);
}
['head_cup_price','head_cup_qty','body_cup_price','body_cup_qty','hijama_discount'].forEach(function(id){
  document.getElementById(id)?.addEventListener('input', updateHijamaTotal);
});

</script>
@endsection 