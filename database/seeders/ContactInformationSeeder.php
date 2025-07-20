<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContactInformation;

class ContactInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactInformation::create([
            'address' => '123 Islamic Center Street, Madinah Quarter, City 12345',
            'phone' => '+1 (555) 123-4567',
            'email' => 'info@ruqyahhijama.com',
            'business_hours' => "Saturday - Thursday: 9:00 AM - 8:00 PM\nFriday: 2:00 PM - 8:00 PM",
            'facebook_url' => 'https://facebook.com/ruqyahhijama',
            'twitter_url' => 'https://twitter.com/ruqyahhijama',
            'instagram_url' => 'https://instagram.com/ruqyahhijama',
            'whatsapp_url' => 'https://wa.me/15551234567',
            'youtube_url' => 'https://youtube.com/ruqyahhijama',
            'linkedin_url' => 'https://linkedin.com/company/ruqyahhijama',
            'contact_form_title' => 'Book a Consultation',
            'contact_form_description' => 'Get in touch with us to schedule your Islamic healing session. Our qualified practitioners are here to help you on your wellness journey.',
            'is_active' => true,
        ]);
    }
}
