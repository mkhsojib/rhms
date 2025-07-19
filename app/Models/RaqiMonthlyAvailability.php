<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RaqiMonthlyAvailability extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'practitioner_id',
        'availability_date',
        'start_time',
        'end_time',
        'slot_duration',
        'is_available',
        'notes',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'availability_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_available' => 'boolean',
    ];
    
    /**
     * Get the practitioner (raqi) that owns this availability.
     */
    public function practitioner()
    {
        return $this->belongsTo(User::class, 'practitioner_id');
    }
    
    /**
     * Generate time slots based on start_time, end_time and slot_duration.
     *
     * @return array
     */
    public function generateTimeSlots()
    {
        $slots = [];
        
        // Create a base date to work with (using today's date as base)
        $baseDate = Carbon::today()->format('Y-m-d');

        // Defensive: If start_time or end_time already contains a date, use as-is; otherwise, prepend baseDate
        $rawStart = $this->start_time;
        $rawEnd = $this->end_time;
        
        Log::info('DEBUG generateTimeSlots: rawStart', ['value' => $rawStart]);
        Log::info('DEBUG generateTimeSlots: rawEnd', ['value' => $rawEnd]);

        $startString = preg_match('/\d{4}-\d{2}-\d{2}/', $rawStart) ? $rawStart : ($baseDate . ' ' . $rawStart);
        $endString = preg_match('/\d{4}-\d{2}-\d{2}/', $rawEnd) ? $rawEnd : ($baseDate . ' ' . $rawEnd);

        Log::info('DEBUG generateTimeSlots: final startString', ['value' => $startString]);
        Log::info('DEBUG generateTimeSlots: final endString', ['value' => $endString]);

        // Parse times
        $startTime = Carbon::parse($startString);
        $endTime = Carbon::parse($endString);
        
        // If end time is before start time (overnight shift), add a day to end time
        if ($endTime->lt($startTime)) {
            $endTime->addDay();
        }
        
        // Check if this is today's date
        $isToday = $this->availability_date->isToday();
        $currentTime = null;
        
        if ($isToday) {
            $currentTime = Carbon::now();
            // Add 30 minutes buffer to current time to avoid showing slots that are too close
            $currentTime->addMinutes(30);
            Log::info('DEBUG generateTimeSlots: Today detected, current time with buffer', ['time' => $currentTime->format('H:i')]);
        }
        
        $currentSlotStart = clone $startTime;
        
        while ($currentSlotStart < $endTime) {
            $slotEnd = (clone $currentSlotStart)->addMinutes($this->slot_duration);
            
            // Only add the slot if it fits completely within the availability window
            if ($slotEnd <= $endTime) {
                // For today's date, check if the slot is in the future
                if ($isToday && $currentTime) {
                    // Only show slots that start after the current time (with buffer)
                    if ($currentSlotStart->gt($currentTime)) {
                        $slots[] = [
                            'start' => $currentSlotStart->format('H:i'),
                            'end' => $slotEnd->format('H:i'),
                        ];
                    }
                } else {
                    // For future dates, show all slots
                    $slots[] = [
                        'start' => $currentSlotStart->format('H:i'),
                        'end' => $slotEnd->format('H:i'),
                    ];
                }
            }
            
            // Move to the next slot start time
            $currentSlotStart = clone $slotEnd;
        }
        
        return $slots;
    }
    
    /**
     * Check if a specific time slot is available.
     *
     * @param string $time Time in format 'H:i'
     * @return bool
     */
    public function isTimeSlotAvailable($time)
    {
        // First check if the date is generally available
        if (!$this->is_available) {
            return false;
        }
        
        // Check if the time is within the available range
        $requestedTime = Carbon::parse($time);
        $startTime = Carbon::parse($this->start_time);
        $endTime = Carbon::parse($this->end_time);
        
        if ($requestedTime < $startTime || $requestedTime >= $endTime) {
            return false;
        }
        
        // Check if there's already an appointment at this time
        $existingAppointment = Appointment::where('practitioner_id', $this->practitioner_id)
            ->where('appointment_date', $this->availability_date)
            ->where('appointment_time', $time)
            ->exists();
        
        return !$existingAppointment;
    }
}
