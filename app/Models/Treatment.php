<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'practitioner_id',
        'treatment_type',
        'treatment_date',
        'status',
        'notes',
        'prescription',
        'aftercare',
        'created_by',
        'updated_by',
        'creation_notes',
        'update_notes',
    ];

    protected $casts = [
        'treatment_date' => 'date',
    ];

    /**
     * Get the appointment for this treatment
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Get the practitioner (admin) for this treatment
     */
    public function practitioner()
    {
        return $this->belongsTo(User::class, 'practitioner_id');
    }

    /**
     * Get the user who created this treatment
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this treatment
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope for scheduled treatments
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    /**
     * Scope for in-progress treatments
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Scope for completed treatments
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Get the medicines prescribed for this treatment.
     */
    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'treatment_medicines')
                    ->withPivot('morning', 'noon', 'afternoon', 'night', 'dosage', 'instructions', 'duration_days')
                    ->withTimestamps();
    }

    /**
     * Get the symptoms addressed in this treatment.
     */
    public function symptoms()
    {
        return $this->belongsToMany(Symptom::class, 'treatment_symptoms')
                    ->withPivot('severity', 'notes')
                    ->withTimestamps();
    }
}
