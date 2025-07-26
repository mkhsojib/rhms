<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AppointmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Super admins can view all appointments
        if ($user->role === 'super_admin') {
            return true;
        }
        
        // Admins can view appointments where they are the practitioner
        if ($user->role === 'admin') {
            return true;
        }
        
        // Patients can view their own appointments
        if ($user->role === 'patient') {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Appointment $appointment): bool
    {
        // Super admins can view all appointments
        if ($user->role === 'super_admin') {
            return true;
        }
        
        // Admins can view appointments where they are the practitioner
        if ($user->role === 'admin' && $appointment->practitioner_id === $user->id) {
            return true;
        }
        
        // Patients can view their own appointments
        if ($user->role === 'patient' && $appointment->user_id === $user->id) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Super admins can create appointments
        if ($user->role === 'super_admin') {
            return true;
        }
        
        // Admins can create appointments
        if ($user->role === 'admin') {
            return true;
        }
        
        // Patients can create appointments
        if ($user->role === 'patient') {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Appointment $appointment): bool
    {
        // Super admins can update all appointments
        if ($user->role === 'super_admin') {
            return true;
        }
        
        // Admins can update appointments where they are the practitioner
        if ($user->role === 'admin' && $appointment->practitioner_id === $user->id) {
            return true;
        }
        
        // Patients can update their own pending or approved appointments
        if ($user->role === 'patient' && $appointment->user_id === $user->id && 
            in_array($appointment->status, ['pending', 'approved'])) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Appointment $appointment): bool
    {
        // Super admins can delete all appointments
        if ($user->role === 'super_admin') {
            return true;
        }
        
        // Admins can delete appointments where they are the practitioner
        if ($user->role === 'admin' && $appointment->practitioner_id === $user->id) {
            return true;
        }
        
        // Patients can only delete their own pending appointments
        if ($user->role === 'patient' && $appointment->user_id === $user->id && $appointment->status === 'pending') {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Appointment $appointment): bool
    {
        // Only super admins can restore appointments
        return $user->role === 'super_admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Appointment $appointment): bool
    {
        // Only super admins can permanently delete appointments
        return $user->role === 'super_admin';
    }
}
