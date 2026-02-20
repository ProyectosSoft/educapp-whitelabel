<?php

namespace App\Http\Livewire\Author;

use App\Models\Curso;
use App\Models\Objetivo_curso;
use Livewire\Component;

class CursosObjetivos extends Component
{
    public $course, $objetivo, $nombre;
    protected $rules =[
        'objetivo.nombre' => 'required'
    ];

    public function mount(Curso $course){
        $this->course = $course;
        $this->objetivo = new Objetivo_curso();
    }

    public function render()
    {
        return view('livewire.author.cursos-objetivos');
    }

    public function store(){

        $this->validate([
            'nombre' => 'required'
        ]);

        $this->course->Objetivo_curso()->create([
            'nombre' => $this->nombre,
            'estado' => 1
        ]);

        $this->reset('nombre');
        $this->course= Curso::find($this->course->id);
    }

    public function edit(Objetivo_curso $objetivo){
        $this->objetivo = $objetivo;

    }

    public function update(){
        $this->validate();
        $this->objetivo->save();
        $this->objetivo = new Objetivo_curso();
        $this->course = Curso::find($this->course->id);
    }

    public function destroy(Objetivo_curso $objetivo){
        $objetivo->delete();
        $this->course = Curso::find($this->course->id);
    }


}
