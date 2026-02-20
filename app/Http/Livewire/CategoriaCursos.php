<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CategoriaCursos extends Component
{
    public $course;
    public $courses=[];

    public function loadPosts(){
        $this->courses = $this->course;
        $this->emit('glider');
    }
    public function render()
    {
        return view('livewire.categoria-cursos');
    }
}
