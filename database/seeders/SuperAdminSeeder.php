<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\RaqiSessionType;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin if not exists
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'), // password is 'password'
                'role' => 'super_admin',
                'email_verified_at' => now(),
            ]);
            $this->command->info('Super Admin created successfully.');
        } else {
            $this->command->info('Super Admin already exists.');
        }

        // Create a sample admin (Raqi/Hijama Practitioner) with Ruqyah Healing specialization
        if (!User::where('email', 'raqi1@example.com')->exists()) {
            $raqi1 = User::create([
                'name' => 'Dr. Ahmad Raqi',
                'email' => 'raqi1@example.com',
                'password' => Hash::make('password'), // password is 'password'
                'role' => 'admin',
                'specialization' => 'ruqyah_healing',
                'phone' => '+1234567891',
                'address' => '123 Islamic Center, City',
                'email_verified_at' => now(),
            ]);
            $this->command->info('Admin (Raqi - Ruqyah Healing) created successfully.');
        } else {
            $raqi1 = User::where('email', 'raqi1@example.com')->first();
            $this->command->info('Admin (Raqi - Ruqyah Healing) already exists.');
        }
        // Seed session types for Ruqyah Healing
        if ($raqi1) {
            RaqiSessionType::updateOrCreate([
                'practitioner_id' => $raqi1->id,
                'type' => 'diagnosis',
            ], [
                'fee' => 1500,
                'min_duration' => 30,
                'max_duration' => 60,
            ]);
            RaqiSessionType::updateOrCreate([
                'practitioner_id' => $raqi1->id,
                'type' => 'short',
            ], [
                'fee' => 1000,
                'min_duration' => 60,
                'max_duration' => 90,
            ]);
            RaqiSessionType::updateOrCreate([
                'practitioner_id' => $raqi1->id,
                'type' => 'long',
            ], [
                'fee' => 3000,
                'min_duration' => 180,
                'max_duration' => 300,
            ]);
        }

        // Create a sample admin (Raqi/Hijama Practitioner) with Hijama (Cupping) specialization
        if (!User::where('email', 'raqi2@example.com')->exists()) {
            $raqi2 = User::create([
                'name' => 'Dr. Bilal Hijama',
                'email' => 'raqi2@example.com',
                'password' => Hash::make('password'), // password is 'password'
                'role' => 'admin',
                'specialization' => 'hijama_cupping',
                'phone' => '+1234567892',
                'address' => '456 Wellness Center, City',
                'email_verified_at' => now(),
            ]);
            $this->command->info('Admin (Raqi - Hijama (Cupping)) created successfully.');
        } else {
            $raqi2 = User::where('email', 'raqi2@example.com')->first();
            $this->command->info('Admin (Raqi - Hijama (Cupping)) already exists.');
        }
        // Seed session types for Hijama Cupping
        if ($raqi2) {
            RaqiSessionType::updateOrCreate([
                'practitioner_id' => $raqi2->id,
                'type' => 'head_cupping',
            ], [
                'fee' => 500, // per point
                'min_duration' => 15,
                'max_duration' => 30,
            ]);
            RaqiSessionType::updateOrCreate([
                'practitioner_id' => $raqi2->id,
                'type' => 'body_cupping',
            ], [
                'fee' => 400, // per point
                'min_duration' => 15,
                'max_duration' => 30,
            ]);
        }

        // Create a sample admin (Raqi/Hijama Practitioner) with Both specialization
        if (!User::where('email', 'raqi3@example.com')->exists()) {
            $raqi3 = User::create([
                'name' => 'Dr. Samir Both',
                'email' => 'raqi3@example.com',
                'password' => Hash::make('password'), // password is 'password'
                'role' => 'admin',
                'specialization' => 'both',
                'phone' => '+1234567893',
                'address' => '789 Holistic Center, City',
                'email_verified_at' => now(),
            ]);
            $this->command->info('Admin (Raqi - Both) created successfully.');
        } else {
            $raqi3 = User::where('email', 'raqi3@example.com')->first();
            $this->command->info('Admin (Raqi - Both) already exists.');
        }
        // Seed session types for Both
        if ($raqi3) {
            // Ruqyah session types
            RaqiSessionType::updateOrCreate([
                'practitioner_id' => $raqi3->id,
                'type' => 'diagnosis',
            ], [
                'fee' => 1500,
                'min_duration' => 30,
                'max_duration' => 60,
            ]);
            RaqiSessionType::updateOrCreate([
                'practitioner_id' => $raqi3->id,
                'type' => 'short',
            ], [
                'fee' => 1000,
                'min_duration' => 60,
                'max_duration' => 90,
            ]);
            RaqiSessionType::updateOrCreate([
                'practitioner_id' => $raqi3->id,
                'type' => 'long',
            ], [
                'fee' => 3000,
                'min_duration' => 180,
                'max_duration' => 300,
            ]);
            // Hijama session types
            RaqiSessionType::updateOrCreate([
                'practitioner_id' => $raqi3->id,
                'type' => 'head_cupping',
            ], [
                'fee' => 500, // per point
                'min_duration' => 15,
                'max_duration' => 30,
            ]);
            RaqiSessionType::updateOrCreate([
                'practitioner_id' => $raqi3->id,
                'type' => 'body_cupping',
            ], [
                'fee' => 400, // per point
                'min_duration' => 15,
                'max_duration' => 30,
            ]);
        }

        // Create a sample admin (Raqi/Hijama Practitioner) with email raqi@example.com for testing
        if (!User::where('email', 'raqi@example.com')->exists()) {
            $raqi4 = User::create([
                'name' => 'Dr. Classic Raqi',
                'email' => 'raqi@example.com',
                'password' => Hash::make('password'), // password is 'password'
                'role' => 'admin',
                'specialization' => 'ruqyah_healing',
                'phone' => '+1234567890',
                'address' => '101 Classic Center, City',
                'email_verified_at' => now(),
            ]);
            $this->command->info('Admin (Raqi - raqi@example.com) created successfully.');
        } else {
            $raqi4 = User::where('email', 'raqi@example.com')->first();
            $this->command->info('Admin (Raqi - raqi@example.com) already exists.');
        }
        // Seed session types for Classic Raqi
        if ($raqi4) {
            RaqiSessionType::updateOrCreate([
                'practitioner_id' => $raqi4->id,
                'type' => 'diagnosis',
            ], [
                'fee' => 1500,
                'min_duration' => 30,
                'max_duration' => 60,
            ]);
            RaqiSessionType::updateOrCreate([
                'practitioner_id' => $raqi4->id,
                'type' => 'short',
            ], [
                'fee' => 1000,
                'min_duration' => 60,
                'max_duration' => 90,
            ]);
            RaqiSessionType::updateOrCreate([
                'practitioner_id' => $raqi4->id,
                'type' => 'long',
            ], [
                'fee' => 3000,
                'min_duration' => 180,
                'max_duration' => 300,
            ]);
        }

        // Create a sample patient if not exists
        if (!User::where('email', 'patient@example.com')->exists()) {
            User::create([
                'name' => 'Patient Test',
                'email' => 'patient@example.com',
                'password' => Hash::make('password'), // password is 'password'
                'role' => 'patient',
                'phone' => '+0987654321',
                'address' => '456 Patient Street, City',
                'email_verified_at' => now(),
            ]);
            $this->command->info('Patient created successfully.');
        } else {
            $this->command->info('Patient already exists.');
        }
    }
}
