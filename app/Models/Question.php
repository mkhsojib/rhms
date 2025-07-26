<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_text',
        'input_type',
        'options',
        'category',
        'is_active',
        'is_required',
    ];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean',
    ];

    public function answers()
    {
        return $this->hasMany(QuestionAnswer::class);
    }
} 