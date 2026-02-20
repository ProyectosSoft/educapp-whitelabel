<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamUserAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'evaluation_id',
        'status', // in_progress, finished, pending_review, graded, void, expired
        'final_score',
        'is_approved',
        'started_at',
        'completed_at',
        'attempt_number',
        'ip_address',
        'invalidation_reason',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'is_approved' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function evaluation()
    {
        return $this->belongsTo(ExamEvaluation::class, 'evaluation_id');
    }

    public function attemptQuestions()
    {
        return $this->hasMany(ExamAttemptQuestion::class, 'attempt_id')->orderBy('order_in_attempt');
    }
}
