<?php

namespace App\Http\Livewire\Student;

use App\Models\Curso;
use App\Models\Evaluation;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EvaluationPage extends Component
{
    use AuthorizesRequests;

    public $course;
    public $evaluation;

    public function mount(Curso $course, Evaluation $evaluation)
    {
        $this->course = $course;
        $this->evaluation = $evaluation;
        
        $this->authorize('matriculado', $course);

        // Verify the evaluation belongs to the course
        if ($evaluation->course_id !== $course->id) {
            abort(404);
        }
    }

    public function render()
    {
        return view('livewire.student.evaluation-page')->layout('layouts.app');
    }
}
