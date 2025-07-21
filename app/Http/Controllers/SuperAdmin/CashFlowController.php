<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\CashFlow;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CashFlowController extends Controller
{
    public function index(Request $request)
    {
        // Cash In
        $cashInQuery = CashFlow::with(['bankAccount', 'creator'])
            ->where('type', 'cash_in');
        // Cash Out
        $cashOutQuery = CashFlow::with(['bankAccount', 'creator'])
            ->where('type', 'cash_out');

        // Filters
        if ($request->has('bank_account_id')) {
            $cashInQuery->where('bank_account_id', $request->bank_account_id);
            $cashOutQuery->where('bank_account_id', $request->bank_account_id);
        }
        // Paginate separately, order by id descending (latest first)
        $cashIns = $cashInQuery->orderByDesc('id')->paginate(15, ['*'], 'cashin_page');
        $cashOuts = $cashOutQuery->orderByDesc('id')->paginate(15, ['*'], 'cashout_page');
        $bankAccounts = BankAccount::all();
        return view('superadmin.cash_flows.index', compact('cashIns', 'cashOuts', 'bankAccounts'));
    }
    public function createCashIn()
    {
        $bankAccounts = BankAccount::all();
        return view('superadmin.cash_flows.create_cash_in', compact('bankAccounts'));
    }
    public function storeCashIn(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required',
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'service_type' => 'nullable|string',
            'customer_name' => 'nullable|string',
            'handled_by' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        DB::transaction(function() use ($request) {
            $data = $request->all();
            $data['transaction_type'] = 'cash_in';
            $data['created_by'] = Auth::id();
            // Generate transaction_no if not provided
            if (empty($data['transaction_no'])) {
                $prefix = strtoupper(substr(preg_replace('/\s+/', '', $data['service_type'] ?? 'CIN'), 0, 3));
                $date = date('Ymd', strtotime($data['transaction_date']));
                $count = \App\Models\Transaction::where('transaction_type', 'cash_in')
                    ->whereDate('transaction_date', $data['transaction_date'])
                    ->where('service_type', $data['service_type'] ?? null)
                    ->count() + 1;
                $data['transaction_no'] = $prefix . $date . str_pad($count, 4, '0', STR_PAD_LEFT);
            }
            // Save to transactions table
            $transaction = \App\Models\Transaction::create([
                'transaction_date' => $data['transaction_date'],
                'transaction_type' => 'cash_in',
                'amount' => $data['amount'],
                'payment_method' => $data['payment_method'],
                'bank_account_id' => $data['bank_account_id'],
                'service_type' => $data['service_type'] ?? null,
                'customer_name' => $data['customer_name'] ?? null,
                'handled_by' => $data['handled_by'] ?? null,
                'notes' => $data['notes'] ?? null,
                'transaction_no' => $data['transaction_no'],
                'created_by' => $data['created_by'],
                'description' => $data['description'] ?? null,
            ]);
            // Save to cash_flows table
            \DB::table('cash_flows')->insert([
                'transaction_date' => $data['transaction_date'],
                'transaction_no' => $data['transaction_no'],
                'type' => 'cash_in',
                'customer_name' => $data['customer_name'] ?? null,
                'service_type' => $data['service_type'] ?? null,
                'amount' => $data['amount'],
                'payment_method' => $data['payment_method'],
                'bank_account_id' => $data['bank_account_id'],
                'handled_by' => $data['handled_by'] ?? null,
                'notes' => $data['notes'] ?? null,
                'transaction_id' => $transaction->id,
                'created_by' => $data['created_by'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            // Update bank balance
            $bank = $transaction->bankAccount;
            $bank->current_balance += $transaction->amount;
            $bank->save();
        });
        return redirect()->route('superadmin.cash-flows.index')->with('success', 'Cash in transaction added successfully.');
    }
    public function createCashOut()
    {
        $bankAccounts = BankAccount::all();
        return view('superadmin.cash_flows.create_cash_out', compact('bankAccounts'));
    }
    public function storeCashOut(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required',
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'category' => 'nullable|string',
            'paid_to' => 'nullable|string',
            'handled_by' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        DB::transaction(function() use ($request) {
            $data = $request->all();
            $data['transaction_type'] = 'cash_out';
            $data['created_by'] = Auth::id();
            // Generate transaction_no if not provided
            if (empty($data['transaction_no'])) {
                $prefix = strtoupper(substr(preg_replace('/\s+/', '', $data['category'] ?? 'COT'), 0, 3));
                $date = date('Ymd', strtotime($data['transaction_date']));
                $count = \App\Models\Transaction::where('transaction_type', 'cash_out')
                    ->whereDate('transaction_date', $data['transaction_date'])
                    ->where('category', $data['category'] ?? null)
                    ->count() + 1;
                $data['transaction_no'] = $prefix . $date . str_pad($count, 4, '0', STR_PAD_LEFT);
            }
            // Save to transactions table
            $transaction = \App\Models\Transaction::create([
                'transaction_date' => $data['transaction_date'],
                'transaction_type' => 'cash_out',
                'amount' => $data['amount'],
                'payment_method' => $data['payment_method'],
                'bank_account_id' => $data['bank_account_id'],
                'category' => $data['category'] ?? null,
                'paid_to' => $data['paid_to'] ?? null,
                'handled_by' => $data['handled_by'] ?? null,
                'notes' => $data['notes'] ?? null,
                'transaction_no' => $data['transaction_no'],
                'created_by' => $data['created_by'],
                'description' => $data['description'] ?? null,
            ]);
            // Save to cash_flows table
            \DB::table('cash_flows')->insert([
                'transaction_date' => $data['transaction_date'],
                'transaction_no' => $data['transaction_no'],
                'type' => 'cash_out',
                'category' => $data['category'] ?? null,
                'amount' => $data['amount'],
                'payment_method' => $data['payment_method'],
                'bank_account_id' => $data['bank_account_id'],
                'paid_to' => $data['paid_to'] ?? null,
                'handled_by' => $data['handled_by'] ?? null,
                'notes' => $data['notes'] ?? null,
                'transaction_id' => $transaction->id,
                'created_by' => $data['created_by'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            // Update bank balance
            $bank = $transaction->bankAccount;
            $bank->current_balance -= $transaction->amount;
            $bank->save();
        });
        return redirect()->route('superadmin.cash-flows.index')->with('success', 'Cash out transaction added successfully.');
    }
    public function edit(CashFlow $cashFlow)
    {
        $bankAccounts = BankAccount::all();
        return view('superadmin.cash_flows.edit', compact('cashFlow', 'bankAccounts'));
    }
    public function update(Request $request, CashFlow $cashFlow)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required',
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'description' => 'nullable|string',
        ]);
        DB::transaction(function() use ($request, $cashFlow) {
            $oldAmount = $cashFlow->amount;
            $oldType = $cashFlow->transaction_type;
            $bank = $cashFlow->bankAccount;
            $cashFlow->update($request->all());
            // Adjust bank balance
            if ($oldType === 'cash_in') {
                $bank->current_balance -= $oldAmount;
            } elseif ($oldType === 'cash_out') {
                $bank->current_balance += $oldAmount;
            }
            if ($cashFlow->transaction_type === 'cash_in') {
                $bank->current_balance += $cashFlow->amount;
            } elseif ($cashFlow->transaction_type === 'cash_out') {
                $bank->current_balance -= $cashFlow->amount;
            }
            $bank->save();
        });
        return redirect()->route('superadmin.cash-flows.index')->with('success', 'Transaction updated successfully.');
    }
    public function destroy(CashFlow $cashFlow)
    {
        DB::transaction(function() use ($cashFlow) {
            $bank = $cashFlow->bankAccount;
            if ($cashFlow->transaction_type === 'cash_in') {
                $bank->current_balance -= $cashFlow->amount;
            } elseif ($cashFlow->transaction_type === 'cash_out') {
                $bank->current_balance += $cashFlow->amount;
            }
            $bank->save();
            $cashFlow->delete();
        });
        return redirect()->route('superadmin.cash-flows.index')->with('success', 'Transaction deleted successfully.');
    }
} 