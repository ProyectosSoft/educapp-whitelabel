<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAttemptQuestionOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'attempt_question_id',
        'option_id',
        'order_in_question',
    ];

    public function attemptQuestion()
    {
        return $this->belongsTo(ExamAttemptQuestion::class, 'attempt_question_id');
    }

    public function option()
    {
        return $this->belongsTo(ExamAnswerOption::class, 'option_id');
    }
}
