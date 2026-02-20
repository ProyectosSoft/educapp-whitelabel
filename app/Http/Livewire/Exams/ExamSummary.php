<?php

namespace App\Http\Livewire\Exams;

use Livewire\Component;
use App\Models\ExamEvaluation;
use App\Models\ExamUserAttempt;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExamSummary extends Component
{
    public $evaluation;
    public $userAttempts;
    public $stats;

    public function mount(ExamEvaluation $evaluation)
    {
        // 1. Authorization Check: Active specific logic
        // If inactive, only allow owner or admin
        if (!$evaluation->is_active && $evaluation->user_id !== Auth::id()) {
             // Optional: Check admin role if available
             // if (!Auth::user()->isAdmin()) ...
             abort(403, 'Esta evaluación no está disponible actualmente.');
        }

        $this->evaluation = $evaluation;
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->userAttempts = ExamUserAttempt::where('user_id', Auth::id())
            ->where('evaluation_id', $this->evaluation->id)
            ->orderBy('attempt_number', 'desc')
            ->get();

        $attemptsCount = $this->userAttempts->count();
        $bestScore = $this->userAttempts->max('final_score') ?? 0;
        
        $totalTimeSeconds = 0;
        foreach ($this->userAttempts as $attempt) {
            if ($attempt->started_at && $attempt->completed_at) {
                $totalTimeSeconds += $attempt->started_at->diffInSeconds($attempt->completed_at);
            }
        }
        
        // Format time
        $dt = Carbon::now()->diff(Carbon::now()->addSeconds($totalTimeSeconds));
        $timeUsedFormatted = "";
        if ($dt->h > 0) $timeUsedFormatted .= $dt->h . "h ";
        if ($dt->i > 0) $timeUsedFormatted .= $dt->i . "m ";
        $timeUsedFormatted .= $dt->s . "s";
        if ($totalTimeSeconds == 0) $timeUsedFormatted = "0s";

        // Calculate total questions configured
        // We need to sum 'questions_per_attempt' from the pivot
        $questionsCount = $this->evaluation->categories()
            ->sum('exam_evaluation_category.questions_per_attempt'); 

        $this->stats = [
            'attempts_count' => $attemptsCount,
            'best_score' => $bestScore,
            'total_time_used' => $timeUsedFormatted,
            'questions_count' => $questionsCount,
            'last_score' => $this->userAttempts->first()->final_score ?? '-',
            'status' => $this->userAttempts->first()->status ?? 'Not Started',
            'approved_attempt' => $this->userAttempts->first(function($attempt) {
                return $attempt->is_approved || ($attempt->final_score >= $this->evaluation->passing_score);
            }),
        ];
    }

    public function render()
    {
        return view('livewire.exams.exam-summary')->layout('layouts.app');
    }
}
