<?php

namespace App\Http\Livewire\Author;

use Livewire\Component;
use App\Models\Curso;
use App\Models\Requerimiento_curso;

class CursosRequisitos extends Component
{
    public $course, $requisito, $nombre;
    protected $rules =[
        'requisito.nombre' => 'required'
    ];

    public function mount(curso $course){
        $this->course = $course;
        $this->requisito = new Requerimiento_curso();
    }


    public function render()
    {
        return view('livewire.author.cursos-requisitos');
    }

    public function store(){

        $this->validate([
            'nombre' => 'required'
        ]);

        $this->course->Requerimiento_curso()->create([
            'nombre' => $this->nombre,
            'estado' => 1
        ]);

        $this->reset('nombre');
        $this->course= Curso::find($this->course->id);
    }

    public function edit(Requerimiento_curso $requisito){
        $this->requisito = $requisito;

    }

    public function update(){
        $this->validate();
        $this->requisito->save();
        $this->requisito = new Requerimiento_curso();
        $this->course = Curso::find($this->course->id);
    }

    public function destroy(Requerimiento_curso $requisito){
        $requisito->delete();
        $this->course = Curso::find($this->course->id);
    }
}
