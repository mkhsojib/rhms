<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Call seeders in order
        $this->call([
            SettingsSeeder::class,    // Seed default settings first
            SuperAdminSeeder::class,  // Then seed users
            RaqiAvailabilitySeeder::class, // Then seed availability records
            ContactInformationSeeder::class, // Then seed contact information
            BankAccountSeeder::class, // Then seed bank accounts
            QuestionSeeder::class, // Then seed questions
        ]);
    }
}
