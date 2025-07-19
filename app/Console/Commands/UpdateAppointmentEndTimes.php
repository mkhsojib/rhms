<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Models\RaqiMonthlyAvailability;
use Carbon\Carbon;

class UpdateAppointmentEndTimes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:update-end-times';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update existing appointments with end times for backward compatibility';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to update appointment end times...');
        
        // Get all appointments without end times
        $appointments = Appointment::whereNull('appointment_end_time')->get();
        
        $this->info("Found {$appointments->count()} appointments without end times.");
        
        $updated = 0;
        $skipped = 0;
        
        foreach ($appointments as $appointment) {
            // Get the availability record for this appointment
            $availability = RaqiMonthlyAvailability::where('practitioner_id', $appointment->practitioner_id)
                ->where('availability_date', $appointment->appointment_date)
                ->where('is_available', true)
                ->first();
                
            if ($availability) {
                // Calculate end time using the slot duration from availability
                $startTime = Carbon::parse($appointment->appointment_time);
                $endTime = $startTime->copy()->addMinutes($availability->slot_duration);
                $appointmentEndTime = $endTime->format('H:i');
                
                // Update the appointment
                $appointment->update(['appointment_end_time' => $appointmentEndTime]);
                $updated++;
                
                $this->line("Updated appointment {$appointment->appointment_no}: {$appointment->appointment_time} -> {$appointmentEndTime}");
            } else {
                // Fallback to session duration
                $startTime = Carbon::parse($appointment->appointment_time);
                $duration = $appointment->session_type_min_duration ?: 60; // Default to 60 minutes
                $endTime = $startTime->copy()->addMinutes($duration);
                $appointmentEndTime = $endTime->format('H:i');
                
                // Update the appointment
                $appointment->update(['appointment_end_time' => $appointmentEndTime]);
                $updated++;
                
                $this->line("Updated appointment {$appointment->appointment_no} (fallback): {$appointment->appointment_time} -> {$appointmentEndTime}");
            }
        }
        
        $this->info("Successfully updated {$updated} appointments.");
        $this->info("Skipped {$skipped} appointments.");
        
        return 0;
    }
}
