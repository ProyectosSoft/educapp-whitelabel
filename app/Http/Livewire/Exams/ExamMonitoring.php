<?php

namespace App\Http\Livewire\Exams;

use Livewire\Component;
use App\Models\ExamEvaluation;
use App\Models\ExamUserAttempt;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ExamMonitoring extends Component
{
    use WithPagination;

    public ExamEvaluation $evaluation;
    public $search = '';
    
    // Attempt Detail State
    public $viewingAttemptId = null;
    public $viewingAttempt = null;

    protected $listeners = ['refreshMonitoring' => '$refresh'];

    public function mount(ExamEvaluation $evaluation)
    {
        if ($evaluation->user_id !== Auth::id()) {
            abort(403, 'Acceso no autorizado a esta evaluación.');
        }
        $this->evaluation = $evaluation;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // 1. Get List of Users who have attempted this evaluation
        // Group by user_id
        
        $attemptsQuery = ExamUserAttempt::query()
            ->where('evaluation_id', $this->evaluation->id)
            ->with('user');

        if(!empty($this->search)) {
            $attemptsQuery->whereHas('user', function($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('email', 'like', '%'.$this->search.'%');
            });
        }
        
        // We want to show a list of STUDENTS, not just all attempts flat.
        // But pagination with GroupBy in Laravel is tricky. 
        // Best approach for now: List filtered recent attempts or distinct users.
        // Let's filter distinct user_ids first, then paginate that?
        // Actually, listing by User is better:
        // "Estudiantes que se han asociado"
        
        // Let's get "Students matching search who have an attempt"
        $studentIds = ExamUserAttempt::where('evaluation_id', $this->evaluation->id)
            ->distinct()
            ->pluck('user_id');

        $students = \App\Models\User::whereIn('id', $studentIds)
            ->when($this->search, function($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('email', 'like', '%'.$this->search.'%');
            })
            ->with(['examAttempts' => function($q) {
                $q->where('evaluation_id', $this->evaluation->id)
                  ->orderBy('started_at', 'desc');
            }])
            ->paginate(10);

        return view('livewire.exams.exam-monitoring', [
            'students' => $students
        ])->layout('layouts.instructor-tailwind');
    }

    public function viewAttempt($attemptId)
    {
        $this->viewingAttemptId = $attemptId;
        $this->viewingAttempt = ExamUserAttempt::with([
            'attemptQuestions.question.category',
            'attemptQuestions.answers.option',
            'evaluation.categories'
        ])->find($attemptId);
    }
    
    public function closeAttemptView()
    {
        $this->viewingAttemptId = null;
        $this->viewingAttempt = null;
    }

    public function deleteAttempt($attemptId)
    {
        $attempt = ExamUserAttempt::find($attemptId);
        
        if ($attempt) {
            $attempt->delete();
            $this->closeAttemptView(); // Close modal if open
            // No need to manually refresh as Livewire usually handles this, 
            // but since we are modifying the data source of the render method:
            // $this->render() is called automatically.
        }
    }
}
