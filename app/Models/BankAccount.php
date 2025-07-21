<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BankAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'account_name',
        'account_number',
        'bank_name',
        'branch_name',
        'initial_balance',
        'current_balance',
        'account_type',
        'description',
        'status',
        'created_by',
    ];
    protected $casts = [
        'initial_balance' => 'decimal:2',
        'current_balance' => 'decimal:2',
    ];
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
} 