<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\WishList;


class RemoveWishList extends Component
{
    private $errorMessage = 'Este curso ya está en tu lista de favoritos.';
    public $course;
    public function render()
    {

        return view('livewire.remove-wish-list');
    }

    public function removeItem(){
             $wishlist = WishList::where('curso_id',$this->course->id);
             $wishlist->delete();
             redirect()->route('wishlist');
    }
}
