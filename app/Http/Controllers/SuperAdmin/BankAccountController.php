<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BankAccountController extends Controller
{
    public function index(Request $request)
    {
        $query = BankAccount::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('account_name', 'like', "%$search%")
                  ->orWhere('account_number', 'like', "%$search%")
                  ->orWhere('bank_name', 'like', "%$search%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $accounts = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('superadmin.bank_accounts.index', compact('accounts'));
    }
    public function create()
    {
        return view('superadmin.bank_accounts.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'branch_name' => 'nullable|string|max:255',
            'initial_balance' => 'required|numeric|min:0',
            'account_type' => 'required|in:savings,checking,current,other',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);
        DB::transaction(function() use ($request) {
            $data = $request->all();
            $data['created_by'] = Auth::id();
            $data['current_balance'] = $request->initial_balance;
            $account = BankAccount::create($data);
        });
        return redirect()->route('superadmin.bank-accounts.index')->with('success', 'Bank account created successfully.');
    }
    public function edit(BankAccount $bankAccount)
    {
        return view('superadmin.bank_accounts.edit', compact('bankAccount'));
    }
    public function update(Request $request, BankAccount $bankAccount)
    {
        $request->validate([
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'branch_name' => 'nullable|string|max:255',
            'account_type' => 'required|in:savings,checking,current,other',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);
        $bankAccount->update($request->all());
        return redirect()->route('superadmin.bank-accounts.index')->with('success', 'Bank account updated successfully.');
    }
    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->delete();
        return redirect()->route('superadmin.bank-accounts.index')->with('success', 'Bank account deleted successfully.');
    }
} 