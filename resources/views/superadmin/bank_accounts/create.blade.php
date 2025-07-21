@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Add Bank Account</h1>
    <form action="{{ route('superadmin.bank-accounts.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Account Name</label>
            <input type="text" name="account_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Account Number</label>
            <input type="text" name="account_number" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Bank Name</label>
            <input type="text" name="bank_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Branch Name</label>
            <input type="text" name="branch_name" class="form-control">
        </div>
        <div class="form-group">
            <label>Initial Balance</label>
            <input type="number" step="0.01" name="initial_balance" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Account Type</label>
            <select name="account_type" class="form-control" required>
                <option value="savings">Savings</option>
                <option value="checking">Checking</option>
                <option value="current">Current</option>
                <option value="other">Other</option>
            </select>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('superadmin.bank-accounts.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection 