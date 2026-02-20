<?php

namespace App\Http\Livewire\Author;

use Livewire\Component;
use App\Models\Curso;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CursosEstudiantes extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    public $course,$search;
    public function mount(Curso $course){
        $this->authorize('dicatated',$course);
        $this->course=$course;
    }

    public function updatingsSearch(){
        $this->resetPage();
    }

    public function render()
    {
        $students=$this->course->students()->where('name','LIKE', '%' . $this->search . '%')->paginate(4);
        return view('livewire.author.cursos-estudiantes',compact('students'))->layout('layouts.author',['course'=>$this->course]);
    }
}
