<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RaqiMonthlyAvailability;
use App\Models\User;
use Carbon\Carbon;

class RaqiAvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all admin users (practitioners)
        $practitioners = User::where('role', 'admin')->get();
        
        if ($practitioners->isEmpty()) {
            $this->command->info('No practitioners found. Please run SuperAdminSeeder first.');
            return;
        }
        
        // Create availability for the next 30 days for each practitioner
        foreach ($practitioners as $practitioner) {
            $startDate = Carbon::today();
            $daysCreated = 0;
            $i = 0;
            while ($daysCreated < 30) {
                $date = $startDate->copy()->addDays($i);
                $i++;
                // Always include today, skip weekends for the rest
                if ($i > 1 && ($date->dayOfWeek == 0 || $date->dayOfWeek == 6)) {
                    continue;
                }
                RaqiMonthlyAvailability::updateOrCreate(
                    [
                        'practitioner_id' => $practitioner->id,
                        'availability_date' => $date->format('Y-m-d'),
                    ],
                    [
                        'start_time' => '09:00',
                        'end_time' => '17:00',
                        'slot_duration' => 60, // 60 minutes per slot
                        'is_available' => true,
                        'notes' => 'Regular availability',
                    ]
                );
                $daysCreated++;
            }
        }

        // Create availability for the previous 7 days for each practitioner (excluding weekends)
        foreach ($practitioners as $practitioner) {
            $startDate = Carbon::today()->subDays(7);
            $daysCreated = 0;
            $i = 0;
            while ($daysCreated < 7) {
                $date = $startDate->copy()->addDays($i);
                $i++;
                // Skip weekends
                if ($date->dayOfWeek == 0 || $date->dayOfWeek == 6) {
                    continue;
                }
                RaqiMonthlyAvailability::updateOrCreate(
                    [
                        'practitioner_id' => $practitioner->id,
                        'availability_date' => $date->format('Y-m-d'),
                    ],
                    [
                        'start_time' => '09:00',
                        'end_time' => '17:00',
                        'slot_duration' => 60, // 60 minutes per slot
                        'is_available' => true,
                        'notes' => 'Backdated availability',
                    ]
                );
                $daysCreated++;
            }
        }

        // Add a late slot for today for each practitioner (for testing)
        foreach ($practitioners as $practitioner) {
            $today = \Carbon\Carbon::today();
            RaqiMonthlyAvailability::updateOrCreate(
                [
                    'practitioner_id' => $practitioner->id,
                    'availability_date' => $today->format('Y-m-d'),
                ],
                [
                    'start_time' => '20:00',
                    'end_time' => '21:00',
                    'slot_duration' => 60,
                    'is_available' => true,
                    'notes' => 'Late test slot for today',
                ]
            );
        }
        
        $this->command->info('Raqi availability records created successfully for the next 30 days.');
    }
} 