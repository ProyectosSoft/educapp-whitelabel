<?php

namespace App\Http\Livewire\Author;

use Livewire\Component;
use App\Models\Curso;
use Livewire\WithPagination;

class CursosIndex extends Component
{
    use WithPagination;

    public $search;
    public function render()
    {
        $courses= Curso::where('nombre','LIKE','%' . $this->search .'%')
                        ->where('user_id',auth()->user()->id)
                        ->latest('id')
                        ->paginate(8);
        return view('livewire.author.cursos-index',compact('courses'));
    }

    public function limpiar_page(){
        $this->reset('page');
    }
}
