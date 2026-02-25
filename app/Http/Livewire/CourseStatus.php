<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Curso;
use App\Models\Leccioncurso;
use App\Models\ExamEvaluation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CourseStatus extends Component
{
    use AuthorizesRequests;
    public $course, $current, $currentEvaluation, $sessionId;

    public function mount(Curso $course)
    {
        $this->course = $course;
        foreach($course->lecciones as $leccion){
            if(!$leccion->completed){
                $this->current=$leccion;
                break;
            }
        }

        if(!$this->current){
            $this->current = $course->lecciones->last();
        }

        $this->authorize('matriculado',$course);

        // Start Tracking Session
        $this->sessionId = \App\Models\CourseSession::create([
            'user_id' => auth()->id(),
            'curso_id' => $course->id,
            'started_at' => now(),
            'last_activity_at' => now(),
            'ip_address' => request()->ip(),
            'start_progress' => $this->getAdvanceProperty(),
            'end_progress' => $this->getAdvanceProperty(),
        ])->id;

    }

    public function render(Curso $course)
    {
        return view('livewire.course-status');
    }


    //Metodos

    public function changelesson(Leccioncurso $leccion){
        $this->current=$leccion;
        $this->currentEvaluation = null;
        $this->dispatchBrowserEvent('lesson-changed');
    }

    public function showEvaluation($evaluationId)
    {
        $evaluation = ExamEvaluation::where('id', $evaluationId)
            ->where('course_id', $this->course->id)
            ->where('is_active', true)
            ->first();

        if (!$evaluation) {
            return;
        }

        if (!$this->isExamEvaluationUnlocked($evaluation)) {
            return;
        }

        return redirect()->route('exams.summary', $evaluation);
    }

    public function showLegacyEvaluation($evaluationId)
    {
        $evaluation = \App\Models\Evaluation::where('id', $evaluationId)
            ->where(function ($query) {
                $query->where('course_id', $this->course->id)
                    ->orWhereIn('section_id', $this->course->Seccion_curso->pluck('id')->toArray());
            })
            ->first();

        if (!$evaluation) {
            return;
        }

        if (!$this->isLegacyEvaluationUnlocked($evaluation)) {
            return;
        }

        $this->currentEvaluation = $evaluation;
        $this->current = null;
    }


    public function completed(){
        if($this->current->completed){
            //eliminar registro
            $this->current->User()->detach(auth()->user()->id);
        }else{
            $this->current->User()->attach(auth()->user()->id);
        }

        $this->current=Leccioncurso::find($this->current->id);
        $this->course =Curso::find($this->course->id);

        // Check for Final Exam Trigger
        if ($this->getAdvanceProperty() >= 100) {
            $finalExam = $this->course->examFinalEvaluations()->where('is_active', true)->first();
            
            if ($finalExam) {
                if ($finalExam->start_mode === 'automatic') {
                    return $this->showEvaluation($finalExam->id);
                } elseif ($finalExam->start_mode === 'manual') {
                    // Trigger SweetAlert confirmation
                    $this->dispatchBrowserEvent('swal:confirm-exam', [
                        'title' => '¡Felicidades! Has completado el curso',
                        'text' => '¿Deseas realizar la evaluación final ahora?',
                        'icon' => 'success',
                        'confirmButtonText' => 'Sí, comenzar examen',
                        'evaluation_id' => $finalExam->id,
                    ]);
                }
            } else {
                // Legacy fallback while old evaluations exist.
                $legacyFinalExam = $this->course->evaluations()->first();
                if ($legacyFinalExam) {
                    if ($legacyFinalExam->start_mode === 'automatic') {
                        $this->currentEvaluation = $legacyFinalExam;
                        $this->current = null;
                    } elseif ($legacyFinalExam->start_mode === 'manual') {
                        $this->dispatchBrowserEvent('swal:confirm-exam', [
                            'title' => '¡Felicidades! Has completado el curso',
                            'text' => '¿Deseas realizar la evaluación final ahora?',
                            'icon' => 'success',
                            'confirmButtonText' => 'Sí, comenzar examen',
                            'legacy_evaluation_id' => $legacyFinalExam->id,
                        ]);
                    }
                }
            }
        }
    }

    //Propiedades computadas
    public function getIndexProperty() {
        if (!$this->current) return null;
        return $this->course->lecciones->pluck('id')->search($this->current->id);
    }

    public function getPreviousProperty() {
        if ($this->index === null || $this->index == 0) {
            return null;
        } else {
            return $this->course->lecciones[$this->index - 1];
        }
    }
    public function getNextProperty() {
        if ($this->index === null || $this->index == $this->course->lecciones->count() - 1) {
            return null;
        } else {
            return $this->course->lecciones[$this->index + 1];
        }
    }

    public function getAdvanceProperty() {
        $i=0;
        $totalLessons = $this->course->lecciones->count();

        if ($totalLessons === 0) {
            return 0;
        }

        foreach($this->course->lecciones as $leccion){
            if($leccion->completed){
                $i++;
            }
        }

        $advance=($i*100)/$totalLessons;

        return round($advance,2) ;
    }

    public function isExamEvaluationUnlocked(ExamEvaluation $evaluation): bool
    {
        $mode = $evaluation->start_mode ?? 'automatic';
        if ($mode === 'manual') {
            return true;
        }

        if (($evaluation->context_type ?? '') === 'course_section' && $evaluation->section_id) {
            return $this->getSectionAdvanceById((int) $evaluation->section_id) >= 100;
        }

        return $this->getAdvanceProperty() >= 100;
    }

    public function isLegacyEvaluationUnlocked($evaluation): bool
    {
        $mode = $evaluation->start_mode ?? 'automatic';
        if ($mode === 'manual') {
            return true;
        }

        if (!empty($evaluation->section_id)) {
            return $this->getSectionAdvanceById((int) $evaluation->section_id) >= 100;
        }

        return $this->getAdvanceProperty() >= 100;
    }

    private function getSectionAdvanceById(int $sectionId): float
    {
        $section = $this->course->Seccion_curso->firstWhere('id', $sectionId);
        if (!$section) {
            return 0;
        }

        $lessons = $section->Leccioncurso;
        $total = $lessons->count();
        if ($total === 0) {
            return 0;
        }

        $completed = $lessons->filter(fn ($lesson) => $lesson->completed)->count();
        return round(($completed * 100) / $total, 2);
    }

    public function download(){
        return response()->download(storage_path('app/' . $this->current->resource->url));
    }



    public function updateSession()
    {
        if ($this->sessionId) {
            $session = \App\Models\CourseSession::find($this->sessionId);
            if ($session) {
                $now = now();
                $diffInSeconds = $session->started_at->diffInSeconds($now);
                
                $session->update([
                    'last_activity_at' => $now,
                    'total_time' => $diffInSeconds,
                    'end_progress' => $this->getAdvanceProperty(),
                    'last_lesson_id' => $this->current->id ?? null
                ]);
            }
        }
    }
}
