<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'phone',
        'email',
        'business_hours',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'whatsapp_url',
        'youtube_url',
        'linkedin_url',
        'contact_form_title',
        'contact_form_description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the active contact information
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first();
    }

    /**
     * Get business hours as array
     */
    public function getBusinessHoursArrayAttribute()
    {
        if (!$this->business_hours) {
            return [];
        }
        
        return explode("\n", $this->business_hours);
    }
}
