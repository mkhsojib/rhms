<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Symptom;

class SymptomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $symptoms = [
            // Physical symptoms
            [
                'name' => 'Headache',
                'description' => 'Pain in the head or upper neck',
                'category' => 'physical',
                'is_active' => true,
            ],
            [
                'name' => 'Fever',
                'description' => 'Elevated body temperature',
                'category' => 'physical',
                'is_active' => true,
            ],
            [
                'name' => 'Cough',
                'description' => 'Sudden expulsion of air from the lungs',
                'category' => 'physical',
                'is_active' => true,
            ],
            [
                'name' => 'Sore Throat',
                'description' => 'Pain or irritation in the throat',
                'category' => 'physical',
                'is_active' => true,
            ],
            [
                'name' => 'Nausea',
                'description' => 'Feeling of sickness with inclination to vomit',
                'category' => 'physical',
                'is_active' => true,
            ],
            [
                'name' => 'Fatigue',
                'description' => 'Extreme tiredness or exhaustion',
                'category' => 'physical',
                'is_active' => true,
            ],
            [
                'name' => 'Joint Pain',
                'description' => 'Pain in joints or muscles',
                'category' => 'physical',
                'is_active' => true,
            ],
            [
                'name' => 'Stomach Pain',
                'description' => 'Pain or discomfort in the abdominal area',
                'category' => 'physical',
                'is_active' => true,
            ],
            [
                'name' => 'Dizziness',
                'description' => 'Feeling of unsteadiness or lightheadedness',
                'category' => 'physical',
                'is_active' => true,
            ],
            [
                'name' => 'Chest Pain',
                'description' => 'Pain or discomfort in the chest area',
                'category' => 'physical',
                'is_active' => true,
            ],
            
            // Mental symptoms
            [
                'name' => 'Anxiety',
                'description' => 'Feeling of worry, nervousness, or unease',
                'category' => 'mental',
                'is_active' => true,
            ],
            [
                'name' => 'Depression',
                'description' => 'Persistent feeling of sadness or loss of interest',
                'category' => 'mental',
                'is_active' => true,
            ],
            [
                'name' => 'Stress',
                'description' => 'Mental or emotional strain or tension',
                'category' => 'mental',
                'is_active' => true,
            ],
            [
                'name' => 'Insomnia',
                'description' => 'Difficulty falling or staying asleep',
                'category' => 'mental',
                'is_active' => true,
            ],
            [
                'name' => 'Memory Problems',
                'description' => 'Difficulty remembering or concentrating',
                'category' => 'mental',
                'is_active' => true,
            ],
            
            // Spiritual symptoms
            [
                'name' => 'Spiritual Distress',
                'description' => 'Feeling disconnected from spiritual beliefs',
                'category' => 'spiritual',
                'is_active' => true,
            ],
            [
                'name' => 'Loss of Faith',
                'description' => 'Questioning or losing religious faith',
                'category' => 'spiritual',
                'is_active' => true,
            ],
            [
                'name' => 'Spiritual Emptiness',
                'description' => 'Feeling of spiritual void or emptiness',
                'category' => 'spiritual',
                'is_active' => true,
            ],
            [
                'name' => 'Evil Eye Symptoms',
                'description' => 'Symptoms believed to be caused by evil eye',
                'category' => 'spiritual',
                'is_active' => true,
            ],
            [
                'name' => 'Jinn Possession',
                'description' => 'Symptoms believed to be caused by jinn',
                'category' => 'spiritual',
                'is_active' => true,
            ],
        ];

        foreach ($symptoms as $symptom) {
            Symptom::create($symptom);
        }
    }
}