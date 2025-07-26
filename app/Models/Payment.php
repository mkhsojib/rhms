<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'appointment_id',
        'amount',
        'discount',
        'paid_amount',
        'payment_method',
        'paid_by',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'amount' => 'decimal:2',
        'discount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function payer()
    {
        return $this->belongsTo(User::class, 'paid_by');
    }
} 