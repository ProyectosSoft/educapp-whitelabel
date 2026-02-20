<?php

namespace App\Http\Livewire\Author;

use Livewire\Component;
use App\Models\Curso;
use App\Models\Seccion_curso;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class CursosCurriculum extends Component
{
    use AuthorizesRequests;

    public $course,$seccion, $nombre;
    protected $rules = [
        'seccion.nombre' => 'required'
    ];

    public function mount(Curso $course){
        $this->course = $course;
        $this->seccion = new Seccion_curso();

        $this->authorize('dicatated',$course);
    }
    public function render()
    {
        return view('livewire.author.cursos-curriculum')->layout('layouts.author',['course'=>$this->course]);
    }

    public function store(){

        $this->validate([
            'nombre' => 'required'
        ]);
        Seccion_curso::create([
            'nombre' => $this->nombre,
            'curso_id' => $this->course->id,
            'estado'=>1
        ]);
        $this->reset('nombre');
        $this->course= Curso::find($this->course->id);
    }
    public function edit(Seccion_curso $seccion){
        $this->seccion = $seccion;
    }

    public function update(){

        $this->validate();
        $this->seccion->save();
        $this->seccion = new Seccion_curso();

        $this->course= Curso::find($this->course->id);
    }
}
