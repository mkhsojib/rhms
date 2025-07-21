<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'appointment_id',
        'patient_id',
        'practitioner_id',
        'amount',
        'status',
        'created_by',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function practitioner()
    {
        return $this->belongsTo(User::class, 'practitioner_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
} 