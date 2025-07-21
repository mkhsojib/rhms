<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_no',
        'user_id',
        'practitioner_id',
        'type',
        'session_type_id',
        'session_type_name',
        'session_type_fee',
        'session_type_min_duration',
        'session_type_max_duration',
        'appointment_date',
        'appointment_time',
        'appointment_end_time',
        'symptoms',
        'status',
        'notes',
        'created_by',
        'updated_by',
        'approved_by',
        'rejected_by',
        'approved_at',
        'rejected_at',
        'approval_notes',
        'rejection_reason',
        'cancelled_at',
        'cancelled_by',
        'cancellation_reason'
    ];
    
    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_COMPLETED = 'completed';
    const STATUS_REJECTED = 'rejected';
    const STATUS_CANCELLED = 'cancelled';
    
    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_REJECTED => 'Rejected',
            self::STATUS_CANCELLED => 'Cancelled',
        ];
    }

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'appointment_time' => 'string', // changed from 'time' to 'string'
        'appointment_end_time' => 'string', // store as string like appointment_time
        // CRITICAL: Explicitly set appointment_date as string to prevent Carbon casting
        'appointment_date' => 'string',
    ];
    
    // Disable date mutator completely
    public $timestamps = false; // Disable created_at/updated_at automatic timestamps
    
    /**
     * Get the appointment date attribute
     * 
     * @param  string  $value
     * @return string
     */
    public function getAppointmentDateAttribute($value)
    {
        // Always return as string to avoid Carbon parsing errors in JavaScript
        // This is safer and more consistent with our direct DB approach
        return $value;
    }
    
    /**
     * Format the appointment date for display
     * Safe method that works even when appointment_date is a string
     *
     * @param string $format
     * @return string
     */
    public function formatDate($format = 'Y-m-d')
    {
        // Clean the date string to ensure it's properly formatted
        $cleanDate = $this->appointment_date;
        if (strpos($cleanDate, ' ') !== false) {
            $parts = explode(' ', $cleanDate);
            $cleanDate = $parts[0];
        }
        
        return date($format, strtotime($cleanDate));
    }
    
    /**
     * Format the appointment time for display
     * Safe method that works even when appointment_time is a string
     *
     * @param string $format
     * @return string
     */
    public function formatTime($format = 'h:i A')
    {
        // If appointment_time is empty, return N/A
        if (empty($this->appointment_time)) {
            return 'N/A';
        }
        
        // If it's already in HH:MM format, just return it
        if (strlen($this->appointment_time) <= 5) {
            return $this->appointment_time;
        }
        
        // Try to parse and format the time
        try {
            return date($format, strtotime($this->appointment_time));
        } catch (\Exception $e) {
            // If parsing fails, return the original string
            return $this->appointment_time;
        }
    }

    /**
     * Format the appointment end time for display
     * Safe method that works even when appointment_end_time is a string
     *
     * @param string $format
     * @return string
     */
    public function formatEndTime($format = 'h:i A')
    {
        // If appointment_end_time is empty, return N/A
        if (empty($this->appointment_end_time)) {
            return 'N/A';
        }
        
        // If it's already in HH:MM format, just return it
        if (strlen($this->appointment_end_time) <= 5) {
            return $this->appointment_end_time;
        }
        
        // Try to parse and format the time
        try {
            return date($format, strtotime($this->appointment_end_time));
        } catch (\Exception $e) {
            // If parsing fails, return the original string
            return $this->appointment_end_time;
        }
    }

    /**
     * Get the full appointment time slot (start - end)
     *
     * @param string $format
     * @return string
     */
    public function getFullTimeSlot($format = 'g:i A')
    {
        $startTime = $this->formatTime($format);
        $endTime = $this->formatEndTime($format);
        
        if ($startTime === 'N/A' || $endTime === 'N/A') {
            return 'N/A';
        }
        
        return $startTime . ' - ' . $endTime;
    }
    
    /**
     * Set the appointment date attribute
     * 
     * @param  string  $value
     * @return void
     */
    public function setAppointmentDateAttribute($value)
    {
        // Clean up the date value before storing it
        if (strpos($value, ' ') !== false) {
            // Split by space and take only the first part
            $parts = explode(' ', $value);
            $value = $parts[0];
        }
        
        // Save the clean date string directly
        $this->attributes['appointment_date'] = $value;
    }

    /**
     * Generate a consistent appointment number
     * Format: APT-YYYYMMDD-XXXX (where XXXX is a random 4-digit number)
     * 
     * @return string
     */
    public static function generateAppointmentNumber()
    {
        do {
            $appointmentNo = 'APT-' . date('Ymd') . '-' . rand(1000, 9999);
            // Ensure the generated number is unique
            $exists = static::where('appointment_no', $appointmentNo)->exists();
        } while ($exists);
        
        return $appointmentNo;
    }

    /**
     * Get the patient for this appointment
     */
    public function patient()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the practitioner for this appointment
     */
    public function practitioner()
    {
        return $this->belongsTo(User::class, 'practitioner_id');
    }

    /**
     * Get the treatment for this appointment
     */
    public function treatment()
    {
        return $this->hasOne(Treatment::class);
    }

    /**
     * Get the user who created this appointment
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this appointment
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the user who approved this appointment
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the user who rejected this appointment
     */
    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    /**
     * Get the session type for this appointment.
     */
    public function sessionType()
    {
        return $this->belongsTo(RaqiSessionType::class, 'session_type_id');
    }

    /**
     * Scope for pending appointments
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for approved appointments
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for completed appointments
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Generate a unique appointment number
     */
    public static function generateAppointmentNo($type = null)
    {
        // Set prefix based on appointment type
        $prefix = $type === 'hijama' ? 'H' : 'R'; // Default to 'R' for ruqyah
        
        $year = date('Y');
        $month = date('m');
        
        // Get the last appointment number for this type, year/month
        $lastAppointment = static::where('appointment_no', 'like', $prefix . $year . $month . '%')
            ->orderBy('appointment_no', 'desc')
            ->first();
        
        if ($lastAppointment) {
            // Extract the sequence number and increment it
            $lastSequence = (int) substr($lastAppointment->appointment_no, -4);
            $newSequence = $lastSequence + 1;
        } else {
            $newSequence = 1;
        }
        
        // Format: R2024070001 or H2024070001 (Prefix + Year + Month + 4-digit sequence)
        return $prefix . $year . $month . str_pad($newSequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Boot method to automatically generate appointment number
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($appointment) {
            if (empty($appointment->appointment_no)) {
                $appointment->appointment_no = static::generateAppointmentNo($appointment->type);
            }
        });
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
