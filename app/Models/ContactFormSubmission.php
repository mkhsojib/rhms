<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactFormSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'message',
        'status',
        'admin_notes',
        'read_at',
        'replied_at'
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'replied_at' => 'datetime',
    ];

    /**
     * Get the status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'new' => 'badge badge-primary',
            'read' => 'badge badge-info',
            'replied' => 'badge badge-success',
            'archived' => 'badge badge-secondary',
            default => 'badge badge-secondary'
        };
    }

    /**
     * Get the status text
     */
    public function getStatusTextAttribute()
    {
        return ucfirst($this->status);
    }

    /**
     * Scope for new submissions
     */
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    /**
     * Scope for unread submissions
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Mark as read
     */
    public function markAsRead()
    {
        $this->update([
            'status' => 'read',
            'read_at' => now()
        ]);
    }

    /**
     * Mark as replied
     */
    public function markAsReplied()
    {
        $this->update([
            'status' => 'replied',
            'replied_at' => now()
        ]);
    }
}
