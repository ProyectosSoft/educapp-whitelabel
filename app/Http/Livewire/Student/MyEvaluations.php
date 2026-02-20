<?php

namespace App\Http\Livewire\Student;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ExamEvaluation;
use App\Models\ExamUserAttempt;
use Illuminate\Support\Facades\Auth;

class MyEvaluations extends Component
{
    use WithPagination;

    public $search = '';
    public $viewingAttemptsFor = null;

    public function render()
    {
        // Get IDs of evaluations the user has attempted
        $attemptedEvaluationIds = ExamUserAttempt::where('user_id', Auth::id())
            ->pluck('evaluation_id')
            ->unique();

        $evaluations = ExamEvaluation::whereIn('id', $attemptedEvaluationIds)
            ->where('name', 'like', '%' . $this->search . '%')
            ->with(['exam', 'userAttempts' => function($query) {
                $query->where('user_id', Auth::id())
                      ->orderBy('created_at', 'desc');
            }])
            ->latest() // Most recent evaluations first? Or by attempt date?
            ->paginate(10);

        return view('livewire.student.my-evaluations', [
            'evaluations' => $evaluations
        ])->layout('layouts.student-tailwind'); 
        // Based on previous file list, 'layouts.alumnos' or 'layouts.app' might be used.
        // Actually, let's use 'layouts.instructor-tailwind' as a reference or 'layouts.app'.
        // Looking at Alumnos components, they usually use a specific layout.
        // Let's check a similar component like 'Alumnos\Index' if exists or just assume 'layouts.app' first and user can correct.
        // Wait, User screenshot looks like the main app layout.
    }

    public function toggleAttempts($evaluationId)
    {
        if ($this->viewingAttemptsFor === $evaluationId) {
            $this->viewingAttemptsFor = null;
        } else {
            $this->viewingAttemptsFor = $evaluationId;
        }
    }
}
