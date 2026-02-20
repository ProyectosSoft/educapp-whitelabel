<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAttemptQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'attempt_id',
        'question_id',
        'order_in_attempt',
        'max_score',
    ];

    public function attempt()
    {
        return $this->belongsTo(ExamUserAttempt::class, 'attempt_id');
    }

    public function question()
    {
        return $this->belongsTo(ExamQuestion::class, 'question_id')->withTrashed();
    }

    public function shownOptions()
    {
        return $this->hasMany(ExamAttemptQuestionOption::class, 'attempt_question_id')->orderBy('order_in_question');
    }

    public function answer()
    {
        return $this->hasOne(ExamAttemptAnswer::class, 'attempt_question_id');
    }

    public function answers()
    {
        return $this->hasMany(ExamAttemptAnswer::class, 'attempt_question_id');
    }
}
