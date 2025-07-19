<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'specialization',
        'phone',
        'address',
        'bio',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole($role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check if user is super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }

    /**
     * Check if user is admin (Raqi/Hijama Practitioner)
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if user is patient
     */
    public function isPatient(): bool
    {
        return $this->hasRole('patient');
    }

    /**
     * Get appointments where user is the patient
     */
    public function patientAppointments()
    {
        return $this->hasMany(Appointment::class, 'user_id');
    }

    /**
     * Get appointments where user is the practitioner
     */
    public function practitionerAppointments()
    {
        return $this->hasMany(Appointment::class, 'practitioner_id');
    }

    /**
     * Get all session types/fees for this practitioner.
     */
    public function sessionTypes()
    {
        return $this->hasMany(\App\Models\RaqiSessionType::class, 'practitioner_id');
    }

    /**
     * Get the notifications for this user
     */
    public function notifications()
    {
        return $this->hasMany(\App\Models\Notification::class);
    }

    /**
     * Get unread notifications for this user
     */
    public function unreadNotifications()
    {
        return $this->notifications()->unread();
    }

    /**
     * Get read notifications for this user
     */
    public function readNotifications()
    {
        return $this->notifications()->read();
    }

    /**
     * Get available specialization options as slug => display name.
     *
     * @return array<string, string>
     */
    public static function specializationOptions(): array
    {
        return [
            'ruqyah_healing' => 'Ruqyah Healing',
            'hijama_cupping' => 'Hijama (Cupping)',
            'both' => 'Ruqyah & Hijama',
        ];
    }

    /**
     * Get the display label for the user's specialization.
     *
     * @return string
     */
    public function getSpecializationLabelAttribute(): string
    {
        return self::specializationOptions()[$this->specialization] ?? $this->specialization;
    }
}
