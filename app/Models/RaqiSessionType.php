<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaqiSessionType extends Model
{
    use HasFactory;

    protected $fillable = [
        'practitioner_id',
        'type',
        'fee',
        'min_duration',
        'max_duration',
    ];
} 