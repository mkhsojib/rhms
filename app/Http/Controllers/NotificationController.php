<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications for the authenticated user
     */
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications()
            ->with(['appointment', 'fromUser'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Get unread notifications count (for AJAX)
     */
    public function getUnreadCount()
    {
        $user = Auth::user();
        $count = NotificationService::getUnreadCount($user);
        
        return response()->json(['count' => $count]);
    }

    /**
     * Get recent notifications (for AJAX)
     */
    public function getRecent()
    {
        $user = Auth::user();
        $notifications = $user->notifications()
            ->with(['appointment', 'fromUser'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json($notifications);
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead(Notification $notification)
    {
        // Ensure the notification belongs to the authenticated user
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        NotificationService::markAllAsRead($user);

        return response()->json(['success' => true]);
    }

    /**
     * Mark a notification as unread
     */
    public function markAsUnread(Notification $notification)
    {
        // Ensure the notification belongs to the authenticated user
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->markAsUnread();

        return response()->json(['success' => true]);
    }

    /**
     * Delete a notification
     */
    public function destroy(Notification $notification)
    {
        // Ensure the notification belongs to the authenticated user
        if ($notification->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized access.');
        }

        $notification->delete();

        return back()->with('success', 'Notification deleted successfully.');
    }

    /**
     * Delete all read notifications
     */
    public function deleteRead()
    {
        $user = Auth::user();
        
        // Debug logging
        Log::info('Delete read notifications requested', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'read_count_before' => $user->readNotifications()->count(),
            'total_notifications' => $user->notifications()->count(),
            'request_method' => request()->method(),
            'is_ajax' => request()->ajax(),
            'url' => request()->url()
        ]);
        
        $deleted = $user->readNotifications()->delete();

        Log::info('Delete read notifications completed', [
            'deleted_count' => $deleted,
            'read_count_after' => $user->readNotifications()->count()
        ]);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "{$deleted} read notifications deleted successfully.",
                'deleted_count' => $deleted
            ]);
        }

        return back()->with('success', "{$deleted} read notifications deleted successfully.");
    }
}
