@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6"><h1>Cash In/Out Transactions</h1></div>
        <div class="col-sm-6 text-right">
            <a href="{{ route('superadmin.cash-flows.createCashIn') }}" class="btn btn-success">Add Cash In</a>
            <a href="{{ route('superadmin.cash-flows.createCashOut') }}" class="btn btn-danger">Add Cash Out</a>
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="GET" class="mb-3">
        <div class="form-row">
            <div class="col-md-3">
                <select name="bank_account_id" class="form-control">
                    <option value="">All Banks</option>
                    @foreach($bankAccounts as $bank)
                        <option value="{{ $bank->id }}" @if(request('bank_account_id')==$bank->id) selected @endif>{{ $bank->account_name }} ({{ $bank->bank_name }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>
    <div class="card mb-4">
        <div class="card-header bg-success text-white">Cash In</div>
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Transaction No</th>
                        <th>Customer Name</th>
                        <th>Service Type</th>
                        <th>Amount (৳)</th>
                        <th>Payment Mode</th>
                        <th>Handled By</th>
                        <th>Notes</th>
                        <th>Bank</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($cashIns as $i => $txn)
                    <tr>
                        <td>{{ $cashIns->firstItem() + $i }}</td>
                        <td>{{ $txn->transaction_date ? $txn->transaction_date->format('Y-m-d') : '' }}</td>
                        <td>{{ $txn->transaction_no }}</td>
                        <td>{{ $txn->customer_name }}</td>
                        <td>{{ $txn->service_type }}</td>
                        <td>{{ number_format($txn->amount, 2) }}</td>
                        <td>{{ ucfirst($txn->payment_method) }}</td>
                        <td>{{ $txn->handled_by }}</td>
                        <td>{{ $txn->notes }}</td>
                        <td>{{ $txn->bankAccount ? $txn->bankAccount->account_name . ' (' . $txn->bankAccount->bank_name . ')' : '' }}</td>
                        <td>
                            <a href="{{ route('superadmin.cash-flows.edit', $txn) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('superadmin.cash-flows.destroy', $txn) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $cashIns->links('pagination::bootstrap-4') }}
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-danger text-white">Cash Out</div>
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Transaction No</th>
                        <th>Category</th>
                        <th>Amount (৳)</th>
                        <th>Payment Mode</th>
                        <th>Paid To</th>
                        <th>Handled By</th>
                        <th>Notes</th>
                        <th>Bank</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($cashOuts as $i => $txn)
                    <tr>
                        <td>{{ $cashOuts->firstItem() + $i }}</td>
                        <td>{{ $txn->transaction_date ? $txn->transaction_date->format('Y-m-d') : '' }}</td>
                        <td>{{ $txn->transaction_no }}</td>
                        <td>{{ $txn->category }}</td>
                        <td>{{ number_format($txn->amount, 2) }}</td>
                        <td>{{ ucfirst($txn->payment_method) }}</td>
                        <td>{{ $txn->paid_to }}</td>
                        <td>{{ $txn->handled_by }}</td>
                        <td>{{ $txn->notes }}</td>
                        <td>{{ $txn->bankAccount ? $txn->bankAccount->account_name . ' (' . $txn->bankAccount->bank_name . ')' : '' }}</td>
                        <td>
                            <a href="{{ route('superadmin.cash-flows.edit', $txn) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('superadmin.cash-flows.destroy', $txn) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $cashOuts->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection 