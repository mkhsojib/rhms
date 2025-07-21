<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_date',
        'amount',
        'transaction_type',
        'type',
        'payment_method',
        'reference_number',
        'reference',
        'description',
        'category',
        'service_type',
        'customer_name',
        'handled_by',
        'notes',
        'transaction_no',
        'paid_to',
        'bank_account_id',
        'related_to',
        'related_id',
        'created_by',
    ];
    protected $casts = [
        'transaction_date' => 'date',
        'amount' => 'decimal:2',
    ];
    public function bankAccount(): BelongsTo
    {
        return $this->belongsTo(BankAccount::class);
    }
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
} 