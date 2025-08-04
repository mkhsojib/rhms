<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'dosage',
        'instructions',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the treatments that use this medicine.
     */
    public function treatments()
    {
        return $this->belongsToMany(Treatment::class, 'treatment_medicines')
                    ->withPivot('morning', 'noon', 'afternoon', 'night', 'dosage', 'instructions', 'duration_days')
                    ->withTimestamps();
    }

    /**
     * Scope to get only active medicines.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get formatted timing for display.
     */
    public function getTimingDisplay($pivot)
    {
        $times = [];
        if ($pivot->morning) $times[] = 'Morning';
        if ($pivot->noon) $times[] = 'Noon';
        if ($pivot->afternoon) $times[] = 'Afternoon';
        if ($pivot->night) $times[] = 'Night';
        
        return implode(', ', $times);
    }
}