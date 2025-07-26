<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        // Ruqyah Healing Questions
        Question::create([
            'question_text' => 'What is your main health concern for Ruqyah treatment?',
            'input_type' => 'text',
            'category' => 'ruqyah',
            'is_active' => true,
        ]);

        Question::create([
            'question_text' => 'Have you experienced any spiritual symptoms?',
            'input_type' => 'radio',
            'options' => ['Yes', 'No', 'Not sure'],
            'category' => 'ruqyah',
            'is_active' => true,
        ]);

        Question::create([
            'question_text' => 'What symptoms are you currently experiencing?',
            'input_type' => 'checkbox',
            'options' => ['Headache', 'Anxiety', 'Depression', 'Insomnia', 'Physical pain', 'Other'],
            'category' => 'ruqyah',
            'is_active' => true,
        ]);

        Question::create([
            'question_text' => 'How long have you been experiencing these symptoms?',
            'input_type' => 'radio',
            'options' => ['Less than 1 month', '1-6 months', '6-12 months', 'More than 1 year'],
            'category' => 'ruqyah',
            'is_active' => true,
        ]);

        // Hijama Cupping Questions
        Question::create([
            'question_text' => 'What is your main health concern for Hijama treatment?',
            'input_type' => 'text',
            'category' => 'hijama',
            'is_active' => true,
        ]);

        Question::create([
            'question_text' => 'Have you had Hijama treatment before?',
            'input_type' => 'radio',
            'options' => ['Yes', 'No'],
            'category' => 'hijama',
            'is_active' => true,
        ]);

        Question::create([
            'question_text' => 'What areas of your body would you like to treat?',
            'input_type' => 'checkbox',
            'options' => ['Head', 'Neck', 'Back', 'Shoulders', 'Arms', 'Legs', 'Other'],
            'category' => 'hijama',
            'is_active' => true,
        ]);

        Question::create([
            'question_text' => 'Do you have any medical conditions or allergies?',
            'input_type' => 'text',
            'category' => 'hijama',
            'is_active' => true,
        ]);

        Question::create([
            'question_text' => 'Are you currently taking any medications?',
            'input_type' => 'radio',
            'options' => ['Yes', 'No'],
            'category' => 'hijama',
            'is_active' => true,
        ]);
    }
} 