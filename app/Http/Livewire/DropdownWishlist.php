<?php

namespace App\Http\Livewire;

use App\Models\WishList;
use Livewire\Component;

class DropdownWishlist extends Component
{
    public $wishlist;
    protected $listeners=['render'];
    public function mount()
    {
        if (auth()->user()){
            $this->wishlist = WishList::where('user_id',auth()->user()->id)->get();
        }
    }
    public function render()
    {
        if (auth()->user()){
            $this->wishlist = WishList::where('user_id',auth()->user()->id)->get();
        }
        return view('livewire.dropdown-wishlist')->with('wishlist', $this->wishlist);
    }


}
