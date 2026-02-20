<?php

namespace App\Http\Livewire\Author;

use App\Models\Leccioncurso;
use Livewire\Component;

class LeccionesDescripcion extends Component
{
    public $leccion,$descripcion,$nombre;

    protected $rules=[
        'descripcion.nombre' => 'required'
    ];
    public function mount(Leccioncurso $leccion){
        $this->leccion=$leccion;

        if($leccion->descripcion){
            $this->descripcion = $leccion->descripcion;
        }

    }
    public function render()
    {
        return view('livewire.author.lecciones-descripcion');
    }

    public function update(){
        $this->validate();
        $this->descripcion->save();
    }

    public function store(){
        $this->descripcion=$this->leccion->descripcion()->create(['nombre' =>$this->nombre]);
        $this->reset('nombre');

        $this->leccion=Leccioncurso::find($this->leccion->id);
    }
}
