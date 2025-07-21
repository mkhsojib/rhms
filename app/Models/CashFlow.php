<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashFlow extends Model
{
    use HasFactory;
    protected $table = 'cash_flows';
    protected $fillable = [
        'transaction_date',
        'transaction_no',
        'type',
        'customer_name',
        'service_type',
        'category',
        'amount',
        'payment_method',
        'bank_account_id',
        'paid_to',
        'handled_by',
        'notes',
        'transaction_id',
        'created_by',
    ];
    protected $casts = [
        'transaction_date' => 'date',
        'amount' => 'decimal:2',
    ];
    public function bankAccount(): BelongsTo
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id');
    }
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
} 