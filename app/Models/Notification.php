<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'user_id',
        'appointment_id',
        'from_user_id',
        'title',
        'message',
        'data',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    // Notification types
    const TYPE_APPOINTMENT_APPROVED = 'appointment_approved';
    const TYPE_APPOINTMENT_REJECTED = 'appointment_rejected';
    const TYPE_APPOINTMENT_CANCELLED = 'appointment_cancelled';
    const TYPE_APPOINTMENT_COMPLETED = 'appointment_completed';
    const TYPE_APPOINTMENT_REMINDER = 'appointment_reminder';

    /**
     * Get the user who will receive this notification
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user who triggered this notification
     */
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    /**
     * Get the appointment related to this notification
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Scope to get unread notifications
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope to get read notifications
     */
    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    /**
     * Scope to get notifications by type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    /**
     * Mark notification as unread
     */
    public function markAsUnread()
    {
        $this->update(['read_at' => null]);
    }

    /**
     * Check if notification is read
     */
    public function isRead()
    {
        return !is_null($this->read_at);
    }

    /**
     * Check if notification is unread
     */
    public function isUnread()
    {
        return is_null($this->read_at);
    }

    /**
     * Get formatted time ago
     */
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get notification icon based on type
     */
    public function getIconAttribute()
    {
        switch ($this->type) {
            case self::TYPE_APPOINTMENT_APPROVED:
                return 'fas fa-check-circle text-green-500';
            case self::TYPE_APPOINTMENT_REJECTED:
                return 'fas fa-times-circle text-red-500';
            case self::TYPE_APPOINTMENT_CANCELLED:
                return 'fas fa-ban text-gray-500';
            case self::TYPE_APPOINTMENT_COMPLETED:
                return 'fas fa-check-double text-blue-500';
            case self::TYPE_APPOINTMENT_REMINDER:
                return 'fas fa-bell text-yellow-500';
            default:
                return 'fas fa-info-circle text-gray-500';
        }
    }

    /**
     * Get notification color class based on type
     */
    public function getColorClassAttribute()
    {
        switch ($this->type) {
            case self::TYPE_APPOINTMENT_APPROVED:
                return 'bg-green-50 border-green-200';
            case self::TYPE_APPOINTMENT_REJECTED:
                return 'bg-red-50 border-red-200';
            case self::TYPE_APPOINTMENT_CANCELLED:
                return 'bg-gray-50 border-gray-200';
            case self::TYPE_APPOINTMENT_COMPLETED:
                return 'bg-blue-50 border-blue-200';
            case self::TYPE_APPOINTMENT_REMINDER:
                return 'bg-yellow-50 border-yellow-200';
            default:
                return 'bg-gray-50 border-gray-200';
        }
    }
}
