<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Console\Command;

class MarkNotificationsAsRead extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:mark-read {user_id?} {--count=5}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark notifications as read for testing purposes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        $count = $this->option('count');

        if (!$userId) {
            $user = User::where('role', 'patient')->first();
            if (!$user) {
                $this->error('No patient user found!');
                return 1;
            }
            $userId = $user->id;
        }

        $user = User::find($userId);
        if (!$user) {
            $this->error("User with ID {$userId} not found!");
            return 1;
        }

        $notifications = $user->notifications()->unread()->limit($count)->get();
        
        if ($notifications->isEmpty()) {
            $this->info('No unread notifications found for this user.');
            return 0;
        }

        $markedCount = 0;
        foreach ($notifications as $notification) {
            $notification->markAsRead();
            $markedCount++;
            $this->line("✓ Marked notification #{$notification->id} as read");
        }

        $this->info("Successfully marked {$markedCount} notifications as read for user: {$user->name}");
        return 0;
    }
} 