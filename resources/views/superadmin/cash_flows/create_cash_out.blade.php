@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Add Cash Out</h1>
    <form action="{{ route('superadmin.cash-flows.storeCashOut') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Date</label>
            <input type="date" name="transaction_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Transaction No</label>
            <input type="text" name="transaction_no" class="form-control">
        </div>
        <div class="form-group">
            <label>Category</label>
            <input type="text" name="category" class="form-control">
        </div>
        <div class="form-group">
            <label>Amount</label>
            <input type="number" step="0.01" name="amount" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Bank Account</label>
            <select name="bank_account_id" class="form-control" id="bank_account_select" required>
                <option value="">Select Bank</option>
                @foreach($bankAccounts as $bank)
                    <option value="{{ $bank->id }}" data-balance="{{ $bank->current_balance }}">
                        {{ $bank->account_name }} ({{ $bank->bank_name }}) - ৳{{ number_format($bank->current_balance, 2) }}
                    </option>
                @endforeach
            </select>
            <small id="bank-balance-info" class="form-text text-muted"></small>
        </div>
        <div class="form-group">
            <label>Payment Method</label>
            <select name="payment_method" class="form-control" required>
                <option value="cash">Cash</option>
                <option value="check">Check</option>
                <option value="bank_transfer">Bank Transfer</option>
                <option value="credit_card">Credit Card</option>
                <option value="debit_card">Debit Card</option>
                <option value="online_payment">Online Payment</option>
                <option value="mobile_banking">Mobile Banking</option>
                <option value="other">Other</option>
            </select>
        </div>
        <div class="form-group">
            <label>Paid To</label>
            <input type="text" name="paid_to" class="form-control">
        </div>
        <div class="form-group">
            <label>Handled By</label>
            <input type="text" name="handled_by" class="form-control">
        </div>
        <div class="form-group">
            <label>Notes</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-danger">Save</button>
        <a href="{{ route('superadmin.cash-flows.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('bank_account_select');
    const info = document.getElementById('bank-balance-info');
    function updateBalance() {
        const opt = select.options[select.selectedIndex];
        const bal = opt.getAttribute('data-balance');
        if (bal !== null) {
            info.textContent = 'Current Balance: ৳' + parseFloat(bal).toLocaleString();
        } else {
            info.textContent = '';
        }
    }
    select.addEventListener('change', updateBalance);
    updateBalance();
});
</script>
@endpush 