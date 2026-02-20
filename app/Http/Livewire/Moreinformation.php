<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Moreinformation extends Component
{
    public $course;
    public function render()
    {
        return view('livewire.moreinformation')->with('course', $this->course);
    }
}
