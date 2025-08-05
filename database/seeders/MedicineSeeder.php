<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Medicine;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicines = [
            // Hijama category medicines
            [
                'name' => 'Paracetamol',
                'description' => 'Pain reliever and fever reducer',
                'type' => 'tablet',
                'dosage' => '500mg',
                'instructions' => 'Take with or without food',
                'category' => 'hijama',
                'is_active' => true,
            ],
            [
                'name' => 'Ibuprofen',
                'description' => 'Anti-inflammatory pain reliever',
                'type' => 'tablet',
                'dosage' => '400mg',
                'instructions' => 'Take with food to avoid stomach upset',
                'category' => 'hijama',
                'is_active' => true,
            ],
            [
                'name' => 'Amoxicillin',
                'description' => 'Antibiotic for bacterial infections',
                'type' => 'capsule',
                'dosage' => '250mg',
                'instructions' => 'Complete the full course even if feeling better',
                'category' => 'hijama',
                'is_active' => true,
            ],
            [
                'name' => 'Cough Syrup',
                'description' => 'Relief for dry and productive cough',
                'type' => 'syrup',
                'dosage' => '10ml',
                'instructions' => 'Shake well before use',
                'category' => 'hijama',
                'is_active' => true,
            ],
            [
                'name' => 'Vitamin D3',
                'description' => 'Vitamin D supplement',
                'type' => 'tablet',
                'dosage' => '1000 IU',
                'instructions' => 'Take with fatty meal for better absorption',
                'category' => 'hijama',
                'is_active' => true,
            ],
            
            // Ruqiyah category medicines
            [
                'name' => 'Omeprazole',
                'description' => 'Proton pump inhibitor for acid reflux',
                'type' => 'capsule',
                'dosage' => '20mg',
                'instructions' => 'Take before breakfast on empty stomach',
                'category' => 'ruqiyah',
                'is_active' => true,
            ],
            [
                'name' => 'Cetirizine',
                'description' => 'Antihistamine for allergies',
                'type' => 'tablet',
                'dosage' => '10mg',
                'instructions' => 'May cause drowsiness',
                'category' => 'ruqiyah',
                'is_active' => true,
            ],
            [
                'name' => 'Metformin',
                'description' => 'Diabetes medication',
                'type' => 'tablet',
                'dosage' => '500mg',
                'instructions' => 'Take with meals to reduce stomach upset',
                'category' => 'ruqiyah',
                'is_active' => true,
            ],
        ];

        foreach ($medicines as $medicine) {
            Medicine::create($medicine);
        }
    }
}