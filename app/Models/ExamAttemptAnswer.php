<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAttemptAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'attempt_question_id',
        'selected_option_id',
        'text_answer',
        'score_obtained',
        'grader_feedback',
        'graded_by',
        'graded_at',
    ];

    protected $casts = [
        'graded_at' => 'datetime',
    ];

    public function attemptQuestion()
    {
        return $this->belongsTo(ExamAttemptQuestion::class, 'attempt_question_id');
    }

    public function selectedOption()
    {
        return $this->belongsTo(ExamAnswerOption::class, 'selected_option_id')->withTrashed();
    }

    public function option()
    {
        return $this->belongsTo(ExamAnswerOption::class, 'selected_option_id')->withTrashed();
    }

    public function grader()
    {
        return $this->belongsTo(User::class, 'graded_by');
    }
}
