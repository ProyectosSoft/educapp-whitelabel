<?php

namespace App\Http\Livewire\Author;

use App\Models\User;
use App\Models\Curso;
use App\Models\StudentAttempt;
use Livewire\Component;
use Livewire\WithPagination;

class StudentProgress extends Component
{
    use WithPagination;

    public $course;
    public $student;
    public $isOpen = false;
    public $activeTab = 'sessions'; // sessions, evaluations, details
    public $selectedAttempt = null;

    protected $listeners = ['showProgress'];

    public function showProgress($userId, $courseId)
    {
        $this->student = User::find($userId);
        $this->course = Curso::find($courseId);
        $this->isOpen = true;
        // Reset to default tab
        $this->activeTab = 'sessions';
        $this->resetPage();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function close()
    {
        $this->isOpen = false;
        $this->selectedAttempt = null;
    }

    public function showAttemptDetails($attemptId)
    {
        $this->loadAttempt($attemptId);
        // Force tab to evaluations if viewing details
        $this->activeTab = 'evaluations'; 
    }

    public function loadAttempt($attemptId)
    {
        $this->selectedAttempt = StudentAttempt::with(['answers.question.answers', 'evaluation'])->find($attemptId);
    }

    public function closeAttemptDetails()
    {
        $this->selectedAttempt = null;
    }

    public function grantExtraAttempt($evaluationId)
    {
        if (!$this->student) return;

        \App\Models\EvaluationException::updateOrCreate(
            [
                'user_id' => $this->student->id,
                'evaluation_id' => $evaluationId
            ],
            [
                'extra_attempts' => \Illuminate\Support\Facades\DB::raw('extra_attempts + 1')
            ]
        );

        $this->dispatchBrowserEvent('swal', [
            'icon' => 'success',
            'title' => '¡Intento concedido!',
            'text' => 'El estudiante ahora tiene un intento adicional para esta evaluación.'
        ]);
        
        // Refresh component
        $this->emit('render');
    }

    public function render()
    {
        $attempts = [];
        $sessions = [];
        
        if ($this->student && $this->course) {
            
            $attempts = []; // Deprecated, using evaluations collection
            
            $sectionIds = $this->course->Seccion_curso->pluck('id');
            
            // Fetch evaluations with this student's attempts
            $evaluationsList = \App\Models\Evaluation::where('course_id', $this->course->id)
                            ->orWhereIn('section_id', $sectionIds)
                            ->with(['attempts' => function($q) {
                                $q->where('user_id', $this->student->id)->orderBy('created_at', 'desc');
                            }])
                            // Also fetch existing exceptions
                            ->with(['exceptions' => function($q) {
                                $q->where('user_id', $this->student->id);
                            }])
                            ->paginate(5, ['*'], 'evaluationsPage');

            // 2. Sessions Logic (Fetch recent sessions)
            $sessions = \App\Models\CourseSession::where('user_id', $this->student->id)
                        ->where('curso_id', $this->course->id)
                        ->orderBy('started_at', 'desc')
                        ->paginate(5, ['*'], 'sessionsPage');

            // 3. Details Logic
            $courseDetails = [];
            // Optimization: Load details only if tab is active or we want to preload
            // Get completed lessons for this student
            $completedLessonIds = \Illuminate\Support\Facades\DB::table('leccioncurso_user')
                                ->where('user_id', $this->student->id)
                                ->pluck('leccioncurso_id')
                                ->toArray();

            foreach ($this->course->Seccion_curso as $section) {
                    $lessons = $section->Leccioncurso;
                    $total = $lessons->count();
                    $completedCount = $lessons->whereIn('id', $completedLessonIds)->count();
                    
                    $courseDetails[] = [
                        'name' => $section->nombre,
                        'total' => $total,
                        'completed' => $completedCount,
                        'percentage' => $total > 0 ? round(($completedCount / $total) * 100) : 0
                    ];
            }
        }

        return view('livewire.author.student-progress', [
            'evaluations' => $evaluationsList ?? [],
            'sessions' => $sessions,
            'courseDetails' => $courseDetails ?? []
        ]);
    }
}
