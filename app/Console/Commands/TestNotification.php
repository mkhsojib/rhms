<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Appointment;
use App\Services\NotificationService;

class TestNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:notification {type=all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create test notifications for testing the notification system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->argument('type');
        
        // Get a patient user
        $patient = User::where('role', 'patient')->first();
        if (!$patient) {
            $this->error('No patient user found. Please create a patient user first.');
            return 1;
        }

        // Get a practitioner user
        $practitioner = User::where('role', 'admin')->first();
        if (!$practitioner) {
            $this->error('No practitioner user found. Please create a practitioner user first.');
            return 1;
        }

        // Get an appointment
        $appointment = Appointment::where('user_id', $patient->id)->first();
        if (!$appointment) {
            $this->error('No appointment found. Please create an appointment first.');
            return 1;
        }

        $this->info('Creating test notifications...');

        if ($type === 'all' || $type === 'approved') {
            $notification = NotificationService::appointmentApproved($appointment, $practitioner);
            if ($notification) {
                $this->info('✓ Created appointment approved notification');
            }
        }

        if ($type === 'all' || $type === 'rejected') {
            $notification = NotificationService::appointmentRejected($appointment, $practitioner, 'Test rejection reason');
            if ($notification) {
                $this->info('✓ Created appointment rejected notification');
            }
        }

        if ($type === 'all' || $type === 'cancelled') {
            $notification = NotificationService::appointmentCancelled($appointment, $practitioner, 'Test cancellation reason');
            if ($notification) {
                $this->info('✓ Created appointment cancelled notification');
            }
        }

        if ($type === 'all' || $type === 'completed') {
            $notification = NotificationService::appointmentCompleted($appointment, $practitioner);
            if ($notification) {
                $this->info('✓ Created appointment completed notification');
            }
        }

        if ($type === 'all' || $type === 'reminder') {
            $notification = NotificationService::appointmentReminder($appointment);
            if ($notification) {
                $this->info('✓ Created appointment reminder notification');
            }
        }

        $this->info('Test notifications created successfully!');
        $this->info("Patient: {$patient->name}");
        $this->info("Practitioner: {$practitioner->name}");
        $this->info("Appointment: {$appointment->appointment_no}");

        return 0;
    }
}
