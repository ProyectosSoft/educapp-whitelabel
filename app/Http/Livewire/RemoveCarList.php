<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CarList;

class RemoveCarList extends Component
{
    public $course;
    public function render()
    {
        return view('livewire.remove-car-list');
    }

    public function removeItem(){
        $carlist = CarList::where('curso_id',$this->course->id);
        $carlist->delete();
        redirect()->route('carlist');
}
}
