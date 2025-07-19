<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class TestDeleteRead extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:delete-read {user_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the delete read notifications functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');

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

        $this->info("Testing delete read for user: {$user->name} (ID: {$user->id})");
        
        $totalNotifications = $user->notifications()->count();
        $readNotifications = $user->readNotifications()->count();
        $unreadNotifications = $user->unreadNotifications()->count();
        
        $this->line("Total notifications: {$totalNotifications}");
        $this->line("Read notifications: {$readNotifications}");
        $this->line("Unread notifications: {$unreadNotifications}");
        
        if ($readNotifications === 0) {
            $this->warn('No read notifications to delete!');
            return 0;
        }
        
        $this->line('Deleting read notifications...');
        $deleted = $user->readNotifications()->delete();
        
        $this->info("Successfully deleted {$deleted} read notifications!");
        
        $remainingNotifications = $user->notifications()->count();
        $this->line("Remaining notifications: {$remainingNotifications}");
        
        return 0;
    }
} 