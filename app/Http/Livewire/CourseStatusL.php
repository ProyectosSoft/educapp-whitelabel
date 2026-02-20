<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Curso;
use App\Models\Leccioncurso;

class CourseStatusL extends Component
{
    public $course,$leccionid,$current,$index,$leccions,$ids;
    public function mount(Curso $course,$leccionid){
        $this->course = $course;

        $this->course = $course;
        foreach($course->lecciones as $leccion){
                $this->ids= $leccion->id;
            if($leccion->id == $leccionid){
                $this->current=$leccion;

                //indice
                $this->leccions=$leccion;
                $this->index = $course->lecciones->search($leccion);
                break;
            }
        }

    }

    public function render()
    {
        return view('livewire.course-status-l');
    }

        //Metodos

        public function changelesson(Leccioncurso $leccion){
            $this->current=$leccion;
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
        }

        //Propiedades computadas
        public function getIndexProperty() {
            return $this->course->lecciones->pluck('id')->search($this->current->id);
        }

        public function getPreviousProperty() {
            if($this->index==0){
                return null;
            }else{
               return $this->course->lecciones[$this->index-1];
            }
        }
        public function getNextProperty() {
            if($this->index == $this->course->lecciones->count()-1){
               return null;
            }
            else{
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
}
