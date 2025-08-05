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
            // Physical symptoms - Hijama type
            ['name' => 'Headache', 'category' => 'physical', 'type' => 'hijama', 'description' => 'Pain in the head or upper neck', 'is_active' => true],
            ['name' => 'Fever', 'category' => 'physical', 'type' => 'hijama', 'description' => 'Elevated body temperature', 'is_active' => true],
            ['name' => 'Cough', 'category' => 'physical', 'type' => 'hijama', 'description' => 'Sudden expulsion of air from the lungs', 'is_active' => true],
            ['name' => 'Sore Throat', 'category' => 'physical', 'type' => 'hijama', 'description' => 'Pain or irritation in the throat', 'is_active' => true],
            ['name' => 'Nausea', 'category' => 'physical', 'type' => 'hijama', 'description' => 'Feeling of sickness with inclination to vomit', 'is_active' => true],
            ['name' => 'Fatigue', 'category' => 'physical', 'type' => 'hijama', 'description' => 'Extreme tiredness or exhaustion', 'is_active' => true],
            ['name' => 'Joint Pain', 'category' => 'physical', 'type' => 'hijama', 'description' => 'Pain in joints or muscles', 'is_active' => true],
            ['name' => 'Stomach Pain', 'category' => 'physical', 'type' => 'hijama', 'description' => 'Pain or discomfort in the abdominal area', 'is_active' => true],
            ['name' => 'Dizziness', 'category' => 'physical', 'type' => 'hijama', 'description' => 'Feeling of unsteadiness or lightheadedness', 'is_active' => true],
            ['name' => 'Chest Pain', 'category' => 'physical', 'type' => 'hijama', 'description' => 'Pain or discomfort in the chest area', 'is_active' => true],
            
            // Emotional/Spiritual symptoms - Ruqiyah type
            ['name' => 'Anxiety', 'category' => 'emotional_spiritual', 'type' => 'ruqyah', 'description' => 'Feeling of worry, nervousness, or unease', 'is_active' => true],
            ['name' => 'Depression', 'category' => 'emotional_spiritual', 'type' => 'ruqyah', 'description' => 'Persistent feeling of sadness or loss of interest', 'is_active' => true],
            ['name' => 'Stress', 'category' => 'emotional_spiritual', 'type' => 'ruqyah', 'description' => 'Mental or emotional strain or tension', 'is_active' => true],
            ['name' => 'Insomnia', 'category' => 'emotional_spiritual', 'type' => 'ruqyah', 'description' => 'Difficulty falling or staying asleep', 'is_active' => true],
            ['name' => 'Memory Problems', 'category' => 'emotional_spiritual', 'type' => 'ruqyah', 'description' => 'Difficulty remembering or concentrating', 'is_active' => true],
            ['name' => 'Spiritual Distress', 'category' => 'emotional_spiritual', 'type' => 'ruqyah', 'description' => 'Feeling disconnected from spiritual beliefs', 'is_active' => true],
            ['name' => 'Loss of Faith', 'category' => 'emotional_spiritual', 'type' => 'ruqyah', 'description' => 'Questioning or losing religious faith', 'is_active' => true],
            ['name' => 'Spiritual Emptiness', 'category' => 'emotional_spiritual', 'type' => 'ruqyah', 'description' => 'Feeling of spiritual void or emptiness', 'is_active' => true],
            ['name' => 'Evil Eye Symptoms', 'category' => 'emotional_spiritual', 'type' => 'ruqyah', 'description' => 'Symptoms believed to be caused by evil eye', 'is_active' => true],
            
            // Ruqiyah symptoms
            ['name' => 'Jinn Possession', 'category' => 'emotional_spiritual', 'type' => 'ruqyah', 'description' => 'Symptoms believed to be caused by jinn', 'is_active' => true],
            ['name' => 'Spiritual Blockages', 'category' => 'emotional_spiritual', 'type' => 'ruqyah', 'description' => 'Feeling of spiritual obstacles or blockages', 'is_active' => true],
            ['name' => 'Negative Energy', 'category' => 'emotional_spiritual', 'type' => 'ruqyah', 'description' => 'Presence of negative spiritual energy', 'is_active' => true],
            ['name' => 'Spiritual Weakness', 'category' => 'emotional_spiritual', 'type' => 'ruqyah', 'description' => 'Feeling spiritually weak or vulnerable', 'is_active' => true],
            ['name' => 'Recitation Discomfort', 'category' => 'emotional_spiritual', 'type' => 'ruqyah', 'description' => 'Discomfort during Quran recitation', 'is_active' => true],
            
            // Hijama symptoms
            ['name' => 'Blood Stagnation', 'category' => 'physical', 'type' => 'hijama', 'description' => 'Poor blood circulation or stagnation', 'is_active' => true],
            ['name' => 'Muscle Tension', 'category' => 'physical', 'type' => 'hijama', 'description' => 'Chronic muscle tension and stiffness', 'is_active' => true],
            ['name' => 'Toxin Buildup', 'category' => 'physical', 'type' => 'hijama', 'description' => 'Accumulation of toxins in the body', 'is_active' => true],
            ['name' => 'Energy Imbalance', 'category' => 'physical', 'type' => 'hijama', 'description' => 'Imbalance in body energy flow', 'is_active' => true],
            
            // Other symptoms
            ['name' => 'Nightmares', 'category' => 'other', 'type' => 'ruqyah', 'description' => 'Disturbing dreams that may have spiritual causes', 'is_active' => true],
            ['name' => 'Unexplained Fear', 'category' => 'other', 'type' => 'ruqyah', 'description' => 'Fear without apparent cause', 'is_active' => true],
        ];

        foreach ($symptoms as $symptom) {
            Symptom::create($symptom);
        }
    }
}