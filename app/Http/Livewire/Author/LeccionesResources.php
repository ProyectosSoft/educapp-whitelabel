<?php

namespace App\Http\Livewire\Author;

use App\Models\Leccioncurso;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class LeccionesResources extends Component
{
    use WithFileUploads;
    public $leccion,$file;

    public function mount(Leccioncurso $leccion){
        $this->leccion = $leccion;
    }


    public function render()
    {
        return view('livewire.author.lecciones-resources');
    }

    public function save(){
        $this->validate([
            'file'=>'required'
        ]);

        $url=$this->file->store('resources');

        $this->leccion->resource()->create([
            'url'=>$url
        ]);

        $this->leccion=Leccioncurso::find($this->leccion->id);
    }


    public function destroy(){
        Storage::delete($this->leccion->resource->url);
        $this->leccion->resource->delete();
        $this->leccion=Leccioncurso::find($this->leccion->id);
    }

    public function download(){
        return response()->download(storage_path('app/' . $this->leccion->resource->url));
    }


}
