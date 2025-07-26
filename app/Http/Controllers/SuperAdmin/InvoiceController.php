<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\BankAccount;
use App\Models\Transaction;
use Illuminate\Validation\Rule;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::with(['appointment', 'patient', 'practitioner'])
            ->orderByDesc('created_at')
            ->paginate(20);
        return view('superadmin.invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['appointment', 'patient', 'practitioner']);
        return view('superadmin.invoices.show', compact('invoice'));
    }

    public function print(Invoice $invoice)
    {
        $invoice->load(['appointment', 'patient', 'practitioner']);
        return view('superadmin.invoices.print_view', compact('invoice'));
    }

    public function download(Invoice $invoice)
    {
        $invoice->load(['appointment', 'patient', 'practitioner']);
        $pdf = Pdf::loadView('superadmin.invoices.print', compact('invoice'));
        $filename = 'Invoice_' . $invoice->invoice_no . '.pdf';
        return $pdf->download($filename);
    }

    public function pay(Invoice $invoice)
    {
        $invoice->load(['appointment', 'patient', 'practitioner']);
        return view('superadmin.invoices._pay_modal', compact('invoice'))->render();
    }

    public function payPage(Invoice $invoice)
    {
        $invoice->load(['appointment', 'patient', 'practitioner']);
        $bankAccounts = BankAccount::all();
        return view('superadmin.invoices.pay_page', compact('invoice', 'bankAccounts'));
    }

    public function storePayment(Request $request, Invoice $invoice)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cash,credit_card,debit_card,bank_transfer,online_payment,mobile_banking,cash_in',
            'bank_account_id' => [
                'nullable',
                'exists:bank_accounts,id',
                Rule::requiredIf(function () use ($request) {
                    return $request->input('payment_method') !== 'cash';
                }),
            ],
        ]);
        DB::transaction(function () use ($request, $invoice) {
            $paymentMethod = $request->payment_method;
            $transactionType = 'payment';
            $paymentMethodForTransaction = $paymentMethod;
            $bankAccount = null;

            if ($paymentMethod === 'cash_in') {
                $transactionType = 'cash_in';
                $paymentMethodForTransaction = 'cash';
            }

            // Get bank account if payment method is not cash
            if ($request->bank_account_id && $paymentMethod !== 'cash') {
                $bankAccount = BankAccount::find($request->bank_account_id);
            }

            $payment = Payment::create([
                'invoice_id' => $invoice->id,
                'appointment_id' => $invoice->appointment_id,
                'amount' => $request->amount,
                'discount' => $request->discount ?? 0,
                'paid_amount' => $request->paid_amount,
                'payment_method' => $paymentMethod,
                'bank_account_id' => $request->bank_account_id,
                'paid_by' => Auth::id(),
                'paid_at' => now(),
                'notes' => $request->notes,
                'head_cup_price' => $request->head_cup_price,
                'head_cup_qty' => $request->head_cup_qty,
                'body_cup_price' => $request->body_cup_price,
                'body_cup_qty' => $request->body_cup_qty,
            ]);
            $invoice->update([
                'amount' => $request->paid_amount,
                'status' => 'paid',
            ]);
            
            // Create transaction
            $transaction = Transaction::create([
                'transaction_date' => now()->toDateString(),
                'amount' => $request->paid_amount,
                'transaction_type' => $transactionType,
                'payment_method' => $paymentMethodForTransaction,
                'bank_account_id' => $request->bank_account_id,
                'description' => 'Payment for Invoice #' . $invoice->invoice_no,
                'transaction_no' => 'TXN-' . date('Ymd') . '-' . rand(1000, 9999),
                'customer_name' => $invoice->patient->name ?? null,
                'service_type' => $invoice->appointment->session_type_name ?? null,
                'category' => $invoice->appointment->type ?? null,
                'paid_to' => $invoice->practitioner->name ?? null,
                'handled_by' => Auth::user()->name,
                'notes' => $request->notes,
                'related_to' => 'payment',
                'related_id' => $payment->id,
                'created_by' => Auth::id(),
            ]);
            
            // Update bank account balance if bank account is selected
            if ($bankAccount) {
                // For payments, increase balance; for cash_in, increase balance
                if ($transactionType === 'cash_in') {
                    $bankAccount->increment('current_balance', $request->paid_amount);
                } else {
                    $bankAccount->increment('current_balance', $request->paid_amount);
                }
            }
        });
        return redirect()->route('superadmin.invoices.show', $invoice)->with('success', 'Payment recorded and invoice marked as paid.');
    }
} 