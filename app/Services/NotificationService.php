<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Create a notification for appointment approval
     */
    public static function appointmentApproved(Appointment $appointment, User $approvedBy)
    {
        try {
            $notification = Notification::create([
                'type' => Notification::TYPE_APPOINTMENT_APPROVED,
                'user_id' => $appointment->user_id,
                'appointment_id' => $appointment->id,
                'from_user_id' => $approvedBy->id,
                'title' => 'Appointment Approved',
                'message' => "Your appointment with {$appointment->practitioner->name} on " . 
                            date('M d, Y', strtotime($appointment->appointment_date)) . 
                            " at " . $appointment->formatTime() . " has been approved.",
                'data' => [
                    'appointment_no' => $appointment->appointment_no,
                    'practitioner_name' => $appointment->practitioner->name,
                    'appointment_date' => $appointment->appointment_date,
                    'appointment_time' => $appointment->appointment_time,
                    'approved_by' => $approvedBy->name,
                ]
            ]);

            Log::info('Appointment approval notification created', [
                'notification_id' => $notification->id,
                'appointment_id' => $appointment->id,
                'user_id' => $appointment->user_id
            ]);

            return $notification;
        } catch (\Exception $e) {
            Log::error('Failed to create appointment approval notification', [
                'appointment_id' => $appointment->id,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Create a notification for appointment rejection
     */
    public static function appointmentRejected(Appointment $appointment, User $rejectedBy, $reason = null)
    {
        try {
            $message = "Your appointment with {$appointment->practitioner->name} on " . 
                      date('M d, Y', strtotime($appointment->appointment_date)) . 
                      " at " . $appointment->formatTime() . " has been rejected.";
            
            if ($reason) {
                $message .= " Reason: {$reason}";
            }

            $notification = Notification::create([
                'type' => Notification::TYPE_APPOINTMENT_REJECTED,
                'user_id' => $appointment->user_id,
                'appointment_id' => $appointment->id,
                'from_user_id' => $rejectedBy->id,
                'title' => 'Appointment Rejected',
                'message' => $message,
                'data' => [
                    'appointment_no' => $appointment->appointment_no,
                    'practitioner_name' => $appointment->practitioner->name,
                    'appointment_date' => $appointment->appointment_date,
                    'appointment_time' => $appointment->appointment_time,
                    'rejected_by' => $rejectedBy->name,
                    'rejection_reason' => $reason,
                ]
            ]);

            Log::info('Appointment rejection notification created', [
                'notification_id' => $notification->id,
                'appointment_id' => $appointment->id,
                'user_id' => $appointment->user_id
            ]);

            return $notification;
        } catch (\Exception $e) {
            Log::error('Failed to create appointment rejection notification', [
                'appointment_id' => $appointment->id,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Create a notification for appointment cancellation
     */
    public static function appointmentCancelled(Appointment $appointment, User $cancelledBy, $reason = null)
    {
        try {
            $message = "Your appointment with {$appointment->practitioner->name} on " . 
                      date('M d, Y', strtotime($appointment->appointment_date)) . 
                      " at " . $appointment->formatTime() . " has been cancelled.";
            
            if ($reason) {
                $message .= " Reason: {$reason}";
            }

            $notification = Notification::create([
                'type' => Notification::TYPE_APPOINTMENT_CANCELLED,
                'user_id' => $appointment->user_id,
                'appointment_id' => $appointment->id,
                'from_user_id' => $cancelledBy->id,
                'title' => 'Appointment Cancelled',
                'message' => $message,
                'data' => [
                    'appointment_no' => $appointment->appointment_no,
                    'practitioner_name' => $appointment->practitioner->name,
                    'appointment_date' => $appointment->appointment_date,
                    'appointment_time' => $appointment->appointment_time,
                    'cancelled_by' => $cancelledBy->name,
                    'cancellation_reason' => $reason,
                ]
            ]);

            Log::info('Appointment cancellation notification created', [
                'notification_id' => $notification->id,
                'appointment_id' => $appointment->id,
                'user_id' => $appointment->user_id
            ]);

            return $notification;
        } catch (\Exception $e) {
            Log::error('Failed to create appointment cancellation notification', [
                'appointment_id' => $appointment->id,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Create a notification for appointment completion
     */
    public static function appointmentCompleted(Appointment $appointment, User $completedBy)
    {
        try {
            $notification = Notification::create([
                'type' => Notification::TYPE_APPOINTMENT_COMPLETED,
                'user_id' => $appointment->user_id,
                'appointment_id' => $appointment->id,
                'from_user_id' => $completedBy->id,
                'title' => 'Appointment Completed',
                'message' => "Your appointment with {$appointment->practitioner->name} on " . 
                            date('M d, Y', strtotime($appointment->appointment_date)) . 
                            " at " . $appointment->formatTime() . " has been marked as completed.",
                'data' => [
                    'appointment_no' => $appointment->appointment_no,
                    'practitioner_name' => $appointment->practitioner->name,
                    'appointment_date' => $appointment->appointment_date,
                    'appointment_time' => $appointment->appointment_time,
                    'completed_by' => $completedBy->name,
                ]
            ]);

            Log::info('Appointment completion notification created', [
                'notification_id' => $notification->id,
                'appointment_id' => $appointment->id,
                'user_id' => $appointment->user_id
            ]);

            return $notification;
        } catch (\Exception $e) {
            Log::error('Failed to create appointment completion notification', [
                'appointment_id' => $appointment->id,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Create a notification for appointment reminder
     */
    public static function appointmentReminder(Appointment $appointment)
    {
        try {
            $notification = Notification::create([
                'type' => Notification::TYPE_APPOINTMENT_REMINDER,
                'user_id' => $appointment->user_id,
                'appointment_id' => $appointment->id,
                'title' => 'Appointment Reminder',
                'message' => "Reminder: You have an appointment with {$appointment->practitioner->name} tomorrow on " . 
                            date('M d, Y', strtotime($appointment->appointment_date)) . 
                            " at " . $appointment->formatTime() . ".",
                'data' => [
                    'appointment_no' => $appointment->appointment_no,
                    'practitioner_name' => $appointment->practitioner->name,
                    'appointment_date' => $appointment->appointment_date,
                    'appointment_time' => $appointment->appointment_time,
                ]
            ]);

            Log::info('Appointment reminder notification created', [
                'notification_id' => $notification->id,
                'appointment_id' => $appointment->id,
                'user_id' => $appointment->user_id
            ]);

            return $notification;
        } catch (\Exception $e) {
            Log::error('Failed to create appointment reminder notification', [
                'appointment_id' => $appointment->id,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Mark all notifications as read for a user
     */
    public static function markAllAsRead(User $user)
    {
        return $user->notifications()->unread()->update(['read_at' => now()]);
    }

    /**
     * Get unread notification count for a user
     */
    public static function getUnreadCount(User $user)
    {
        return $user->notifications()->unread()->count();
    }
} 