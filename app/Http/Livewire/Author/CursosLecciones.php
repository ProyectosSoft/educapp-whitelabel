<?php

namespace App\Http\Livewire\Author;

use App\Models\Leccioncurso;
use App\Models\Seccion_curso;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class CursosLecciones extends Component
{

    use WithFileUploads;
    public $seccion,$leccion,$nombre,$url,$video,$slug;

    protected $rules = [
        'leccion.nombre' => 'required',
        'leccion.url' =>'required'
    ];
    public function mount(Seccion_curso $seccion){
        $this->seccion = $seccion;
        $this->leccion = new Leccioncurso();
    }
    public function render()
    {
        return view('livewire.author.cursos-lecciones');
    }

    public function edit(Leccioncurso $leccion){
        $this->leccion=$leccion;
    }

    public function update(){
        $this->validate();

        $this->leccion->save();
        $this->leccion = new Leccioncurso();
        $this->seccion = Seccion_curso::find($this->seccion->id);
    }

    public function store(){
        set_time_limit(0); // Permitir tiempo ilimitado para subir archivos grandes a DO
        $this->validate([
            'nombre' => 'required',
            'video' => 'file|mimes:mp4,avi,wmv|max:2500000', // Máximo 10 MB
        ]);
        $videoPath = $this->video->store('videos','do');
        // $videoPath=Storage::put('videos',$this->video);

        Leccioncurso::create([
            'nombre' => $this->nombre,
            'url' => $videoPath,
            'iframe'=> $videoPath,
            'seccion_curso_id' =>$this->seccion->id,
            'estado'=>1
        ]);
        $this->reset(['nombre','url','video']);
        $this->seccion = Seccion_curso::find($this->seccion->id);
    }

    public function destroy(Leccioncurso  $leccion){
        $leccion->delete();
        $this->seccion = Seccion_curso::find($this->seccion->id);;
    }
}
