<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'question_id',
        'answer',
    ];

    protected $casts = [
        'answer' => 'array',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
} 