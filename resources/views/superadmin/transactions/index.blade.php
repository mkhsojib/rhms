@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Transaction Report</h1>
    <form method="GET" class="mb-3">
        <div class="form-row">
            <div class="col-md-2">
                <select name="transaction_type" class="form-control">
                    <option value="">All Types</option>
                    <option value="cash_in" @if(request('transaction_type')=='cash_in') selected @endif>Cash In</option>
                    <option value="cash_out" @if(request('transaction_type')=='cash_out') selected @endif>Cash Out</option>
                    <option value="payment" @if(request('transaction_type')=='payment') selected @endif>Payment</option>
                    <option value="deposit" @if(request('transaction_type')=='deposit') selected @endif>Deposit</option>
                    <option value="withdrawal" @if(request('transaction_type')=='withdrawal') selected @endif>Withdrawal</option>
                    <option value="transfer" @if(request('transaction_type')=='transfer') selected @endif>Transfer</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="bank_account_id" class="form-control">
                    <option value="">All Banks</option>
                    @foreach($bankAccounts as $bank)
                        <option value="{{ $bank->id }}" @if(request('bank_account_id')==$bank->id) selected @endif>{{ $bank->account_name }} ({{ $bank->bank_name }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="From">
            </div>
            <div class="col-md-2">
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" placeholder="To">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Transaction No</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Bank</th>
                        <th>Payment Method</th>
                        <th>Category/Service</th>
                        <th>Description</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($transactions as $i => $txn)
                    <tr @if($txn->voided_at) style="background-color:#eee;text-decoration:line-through;" @elseif($txn->transaction_type == 'cash_in') style="background-color:#e6ffe6;" @elseif($txn->transaction_type == 'cash_out') style="background-color:#ffe6e6;" @endif>
                        <td>{{ $transactions->firstItem() + $i }}</td>
                        <td>{{ $txn->transaction_no }}</td>
                        <td>{{ $txn->transaction_date ? $txn->transaction_date->format('Y-m-d') : '' }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $txn->transaction_type)) }}</td>
                        <td>{{ number_format($txn->amount, 2) }}</td>
                        <td>{{ $txn->bankAccount ? $txn->bankAccount->account_name . ' (' . $txn->bankAccount->bank_name . ')' : '' }}</td>
                        <td>{{ ucfirst($txn->payment_method) }}</td>
                        <td>
                            @if($txn->transaction_type == 'cash_in')
                                {{ $txn->service_type }}
                            @elseif($txn->transaction_type == 'cash_out')
                                {{ $txn->category }}
                            @else
                                {{ $txn->category }}
                            @endif
                        </td>
                        <td>{{ $txn->description }}</td>
                        <td>{{ $txn->creator ? $txn->creator->name : '' }}</td>
                        <td>
                            @if($txn->voided_at)
                                <span class="text-danger">Voided</span>
                            @else
                                <form action="{{ route('superadmin.transactions.void', $txn->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-secondary" onclick="return confirm('Are you sure you want to void this transaction?')">Void</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $transactions->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection 