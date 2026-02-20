<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Curso;
use App\Models\Leccioncurso;
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

    public function showEvaluation(\App\Models\Evaluation $evaluation){
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
            $finalExam = $this->course->evaluations()->first();
            
            if ($finalExam) {
                if ($finalExam->start_mode === 'automatic') {
                    $this->showEvaluation($finalExam);
                } elseif ($finalExam->start_mode === 'manual') {
                    // Trigger SweetAlert confirmation
                    $this->dispatchBrowserEvent('swal:confirm-exam', [
                        'title' => '¡Felicidades! Has completado el curso',
                        'text' => '¿Deseas realizar la evaluación final ahora?',
                        'icon' => 'success',
                        'confirmButtonText' => 'Sí, comenzar examen',
                        'evaluation_id' => $finalExam->id
                    ]);
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
        foreach($this->course->lecciones as $leccion){
            if($leccion->completed){
                $i++;
            }
        }

        $advance=($i*100)/($this->course->lecciones->count());

        return round($advance,2) ;
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
