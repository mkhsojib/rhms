@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Edit Bank Account</h1>
    <form action="{{ route('superadmin.bank-accounts.update', $bankAccount) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Account Name</label>
            <input type="text" name="account_name" class="form-control" value="{{ $bankAccount->account_name }}" required>
        </div>
        <div class="form-group">
            <label>Account Number</label>
            <input type="text" name="account_number" class="form-control" value="{{ $bankAccount->account_number }}" required>
        </div>
        <div class="form-group">
            <label>Bank Name</label>
            <input type="text" name="bank_name" class="form-control" value="{{ $bankAccount->bank_name }}" required>
        </div>
        <div class="form-group">
            <label>Branch Name</label>
            <input type="text" name="branch_name" class="form-control" value="{{ $bankAccount->branch_name }}">
        </div>
        <div class="form-group">
            <label>Account Type</label>
            <select name="account_type" class="form-control" required>
                <option value="savings" @if($bankAccount->account_type=='savings') selected @endif>Savings</option>
                <option value="checking" @if($bankAccount->account_type=='checking') selected @endif>Checking</option>
                <option value="current" @if($bankAccount->account_type=='current') selected @endif>Current</option>
                <option value="other" @if($bankAccount->account_type=='other') selected @endif>Other</option>
            </select>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="active" @if($bankAccount->status=='active') selected @endif>Active</option>
                <option value="inactive" @if($bankAccount->status=='inactive') selected @endif>Inactive</option>
            </select>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $bankAccount->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('superadmin.bank-accounts.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection 