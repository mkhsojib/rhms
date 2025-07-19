<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'site_name',
                'value' => 'Ruqyah & Hijama Center',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Site Name',
                'description' => 'The name of your center',
                'is_public' => true,
            ],
            [
                'key' => 'site_description',
                'value' => 'Professional Islamic healing services including Ruqyah and Hijama treatments',
                'type' => 'textarea',
                'group' => 'general',
                'label' => 'Site Description',
                'description' => 'Brief description of your center',
                'is_public' => true,
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@ruqyahcenter.com',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Contact Email',
                'description' => 'Primary contact email address',
                'is_public' => true,
            ],
            [
                'key' => 'contact_phone',
                'value' => '+1234567890',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Contact Phone',
                'description' => 'Primary contact phone number',
                'is_public' => true,
            ],
            [
                'key' => 'contact_address',
                'value' => '123 Islamic Center Street, City, Country',
                'type' => 'textarea',
                'group' => 'general',
                'label' => 'Contact Address',
                'description' => 'Physical address of the center',
                'is_public' => true,
            ],

            // Appearance Settings
            [
                'key' => 'site_logo',
                'value' => null,
                'type' => 'image',
                'group' => 'appearance',
                'label' => 'Site Logo',
                'description' => 'Upload your center logo (recommended: 200x60px)',
                'is_public' => true,
            ],
            [
                'key' => 'favicon',
                'value' => null,
                'type' => 'image',
                'group' => 'appearance',
                'label' => 'Favicon',
                'description' => 'Upload favicon (recommended: 32x32px)',
                'is_public' => true,
            ],
            [
                'key' => 'primary_color',
                'value' => '#3B82F6',
                'type' => 'text',
                'group' => 'appearance',
                'label' => 'Primary Color',
                'description' => 'Primary color for the website (hex code)',
                'is_public' => true,
            ],
            [
                'key' => 'secondary_color',
                'value' => '#1E40AF',
                'type' => 'text',
                'group' => 'appearance',
                'label' => 'Secondary Color',
                'description' => 'Secondary color for the website (hex code)',
                'is_public' => true,
            ],

            // System Settings
            [
                'key' => 'timezone',
                'value' => 'Asia/Dhaka',
                'type' => 'select',
                'group' => 'system',
                'label' => 'Timezone',
                'description' => 'Default timezone for the system',
                'options' => [
                    'UTC' => 'UTC',
                    'America/New_York' => 'Eastern Time',
                    'America/Chicago' => 'Central Time',
                    'America/Denver' => 'Mountain Time',
                    'America/Los_Angeles' => 'Pacific Time',
                    'Europe/London' => 'London',
                    'Europe/Paris' => 'Paris',
                    'Asia/Dubai' => 'Dubai',
                    'Asia/Karachi' => 'Karachi',
                    'Asia/Dhaka' => 'Dhaka',
                    'Asia/Kolkata' => 'Kolkata',
                    'Asia/Bangkok' => 'Bangkok',
                    'Asia/Singapore' => 'Singapore',
                    'Asia/Tokyo' => 'Tokyo',
                    'Australia/Sydney' => 'Sydney',
                ],
                'is_public' => false,
            ],
            [
                'key' => 'date_format',
                'value' => 'Y-m-d',
                'type' => 'select',
                'group' => 'system',
                'label' => 'Date Format',
                'description' => 'Default date format for the system',
                'options' => [
                    'Y-m-d' => 'YYYY-MM-DD',
                    'd/m/Y' => 'DD/MM/YYYY',
                    'm/d/Y' => 'MM/DD/YYYY',
                    'd-m-Y' => 'DD-MM-YYYY',
                    'm-d-Y' => 'MM-DD-YYYY',
                ],
                'is_public' => false,
            ],
            [
                'key' => 'time_format',
                'value' => 'H:i',
                'type' => 'select',
                'group' => 'system',
                'label' => 'Time Format',
                'description' => 'Default time format for the system',
                'options' => [
                    'H:i' => '24-hour (HH:MM)',
                    'h:i A' => '12-hour (HH:MM AM/PM)',
                ],
                'is_public' => false,
            ],
            [
                'key' => 'language',
                'value' => 'en',
                'type' => 'select',
                'group' => 'system',
                'label' => 'Default Language',
                'description' => 'Default language for the system',
                'options' => [
                    'en' => 'English',
                    'ar' => 'العربية',
                    'ur' => 'اردو',
                    'bn' => 'বাংলা',
                    'tr' => 'Türkçe',
                    'ms' => 'Bahasa Melayu',
                ],
                'is_public' => false,
            ],

            // Business Settings
            [
                'key' => 'currency',
                'value' => 'USD',
                'type' => 'select',
                'group' => 'business',
                'label' => 'Currency',
                'description' => 'Default currency for the system',
                'options' => [
                    'USD' => 'US Dollar ($)',
                    'EUR' => 'Euro (€)',
                    'GBP' => 'British Pound (£)',
                    'SAR' => 'Saudi Riyal (ر.س)',
                    'AED' => 'UAE Dirham (د.إ)',
                    'QAR' => 'Qatari Riyal (ر.ق)',
                    'KWD' => 'Kuwaiti Dinar (د.ك)',
                    'BHD' => 'Bahraini Dinar (د.ب)',
                    'OMR' => 'Omani Rial (ر.ع)',
                    'JOD' => 'Jordanian Dinar (د.ا)',
                    'EGP' => 'Egyptian Pound (ج.م)',
                    'PKR' => 'Pakistani Rupee (₨)',
                    'INR' => 'Indian Rupee (₹)',
                    'BDT' => 'Bangladeshi Taka (৳)',
                    'MYR' => 'Malaysian Ringgit (RM)',
                    'TRY' => 'Turkish Lira (₺)',
                ],
                'is_public' => false,
            ],
            [
                'key' => 'currency_symbol',
                'value' => '$',
                'type' => 'text',
                'group' => 'business',
                'label' => 'Currency Symbol',
                'description' => 'Currency symbol to display',
                'is_public' => false,
            ],
            [
                'key' => 'business_hours',
                'value' => 'Monday - Friday: 9:00 AM - 6:00 PM\nSaturday: 9:00 AM - 4:00 PM\nSunday: Closed',
                'type' => 'textarea',
                'group' => 'business',
                'label' => 'Business Hours',
                'description' => 'Center operating hours',
                'is_public' => true,
            ],
            [
                'key' => 'appointment_duration',
                'value' => '60',
                'type' => 'select',
                'group' => 'business',
                'label' => 'Default Appointment Duration (minutes)',
                'description' => 'Default duration for appointments',
                'options' => [
                    '30' => '30 minutes',
                    '45' => '45 minutes',
                    '60' => '1 hour',
                    '90' => '1.5 hours',
                    '120' => '2 hours',
                ],
                'is_public' => false,
            ],
            [
                'key' => 'advance_booking_days',
                'value' => '30',
                'type' => 'text',
                'group' => 'business',
                'label' => 'Advance Booking Days',
                'description' => 'How many days in advance patients can book appointments',
                'is_public' => false,
            ],
            [
                'key' => 'cancellation_hours',
                'value' => '24',
                'type' => 'text',
                'group' => 'business',
                'label' => 'Cancellation Notice (hours)',
                'description' => 'Minimum hours notice required for appointment cancellation',
                'is_public' => false,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
