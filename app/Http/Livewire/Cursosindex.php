<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Curso;
use App\Models\Categoria;
use App\Models\Nivel;

use Livewire\WithPagination;
class Cursosindex extends Component
{
    use WithPagination;
    public $categoria_id;
    public $nivel_id;

    public function render()
    {

        $categorias=Categoria::all();
        $niveles=Nivel::all();
        $courses=Curso::where('status',3)
        ->Categoria($this->categoria_id)
        ->Nivel($this->nivel_id)
        ->latest('id')
        ->latest('id')
        ->paginate(8);
        return view('livewire.cursosindex',compact('courses','categorias','niveles'));
    }

    public function resetFilters(){
        $this->reset(['categoria_id','nivel_id']);
    }
}
