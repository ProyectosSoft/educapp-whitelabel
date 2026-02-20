<?php

namespace App\Http\Livewire;

use App\Models\Curso;
use Livewire\Component;

class Search extends Component
{
    public $search;
    public $open = false;

    public function updatedSearch($value)
    {
        if ($value) {
            $this->open = true;
        } else {
            $this->open = false;
        }
    }
    public function render()
    {
        return view('livewire.search');
    }

    public function getResultsProperty()
    {
        // return Curso::where ('nombre','LIKE','%' . $this->search . '%')->where('status',3)->take(8)->get();
        return Curso::where('nombre', 'LIKE', '%' . $this->search . '%')
            ->where('status', 3)
            ->orderByDesc('id') // Ordenar por el campo 'id' de forma descendente
            ->take(8)
            ->get();
    }
}
