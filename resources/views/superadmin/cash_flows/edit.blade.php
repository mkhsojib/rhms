@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Edit Cash In/Out Transaction</h1>
    <form action="{{ route('superadmin.cash-flows.update', $cashFlow) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Date</label>
            <input type="date" name="transaction_date" class="form-control" value="{{ $cashFlow->transaction_date->format('Y-m-d') }}" required>
        </div>
        <div class="form-group">
            <label>Amount</label>
            <input type="number" step="0.01" name="amount" class="form-control" value="{{ $cashFlow->amount }}" required>
        </div>
        <div class="form-group">
            <label>Bank Account</label>
            <select name="bank_account_id" class="form-control" required>
                @foreach($bankAccounts as $bank)
                    <option value="{{ $bank->id }}" @if($cashFlow->bank_account_id==$bank->id) selected @endif>{{ $bank->account_name }} ({{ $bank->bank_name }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Payment Method</label>
            <select name="payment_method" class="form-control" required>
                <option value="cash" @if($cashFlow->payment_method=='cash') selected @endif>Cash</option>
                <option value="check" @if($cashFlow->payment_method=='check') selected @endif>Check</option>
                <option value="bank_transfer" @if($cashFlow->payment_method=='bank_transfer') selected @endif>Bank Transfer</option>
                <option value="credit_card" @if($cashFlow->payment_method=='credit_card') selected @endif>Credit Card</option>
                <option value="debit_card" @if($cashFlow->payment_method=='debit_card') selected @endif>Debit Card</option>
                <option value="online_payment" @if($cashFlow->payment_method=='online_payment') selected @endif>Online Payment</option>
                <option value="mobile_banking" @if($cashFlow->payment_method=='mobile_banking') selected @endif>Mobile Banking</option>
                <option value="other" @if($cashFlow->payment_method=='other') selected @endif>Other</option>
            </select>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $cashFlow->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('superadmin.cash-flows.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection 