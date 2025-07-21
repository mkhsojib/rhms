@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6"><h1>Bank Accounts</h1></div>
        <div class="col-sm-6 text-right">
            <a href="{{ route('superadmin.bank-accounts.create') }}" class="btn btn-primary">Add Bank Account</a>
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Account Name</th>
                        <th>Account Number</th>
                        <th>Bank Name</th>
                        <th>Current Balance</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($accounts as $account)
                    <tr>
                        <td>{{ $account->id }}</td>
                        <td>{{ $account->account_name }}</td>
                        <td>{{ $account->account_number }}</td>
                        <td>{{ $account->bank_name }}</td>
                        <td>{{ number_format($account->current_balance, 2) }}</td>
                        <td>{{ ucfirst($account->status) }}</td>
                        <td>
                            <a href="{{ route('superadmin.bank-accounts.edit', $account) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('superadmin.bank-accounts.destroy', $account) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                            <a href="{{ route('superadmin.transactions.index', ['bank_account_id' => $account->id]) }}" class="btn btn-sm btn-info">View Transactions</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $accounts->links() }}
        </div>
    </div>
</div>
@endsection 