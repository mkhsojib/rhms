<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function create()
    {
        $bankAccounts = BankAccount::all();
        return view('superadmin.transactions.create', compact('bankAccounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'transaction_type' => 'required|string',
            'payment_method' => 'required|string',
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'category' => 'nullable|string',
            'related_to' => 'nullable|string',
            'related_id' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);
        DB::transaction(function() use ($request) {
            $data = $request->all();
            $data['created_by'] = Auth::id();
            $transaction = Transaction::create($data);
            // Update bank balance
            $bank = $transaction->bankAccount;
            if ($data['transaction_type'] === 'cash_in' || $data['transaction_type'] === 'deposit' || $data['transaction_type'] === 'payment') {
                $bank->current_balance += $transaction->amount;
            } elseif ($data['transaction_type'] === 'cash_out' || $data['transaction_type'] === 'withdrawal') {
                $bank->current_balance -= $transaction->amount;
            }
            $bank->save();
        });
        return redirect()->route('superadmin.transactions.create')->with('success', 'Transaction added successfully.');
    }

    public function index(Request $request)
    {
        $query = Transaction::with('bankAccount', 'creator');
        if ($request->filled('transaction_type')) {
            $query->where('transaction_type', $request->transaction_type);
        }
        if ($request->filled('bank_account_id')) {
            $query->where('bank_account_id', $request->bank_account_id);
        }
        if ($request->filled('date_from')) {
            $query->where('transaction_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('transaction_date', '<=', $request->date_to);
        }
        $transactions = $query->orderByDesc('id')->paginate(20);
        $bankAccounts = \App\Models\BankAccount::all();
        return view('superadmin.transactions.index', compact('transactions', 'bankAccounts'));
    }
} 