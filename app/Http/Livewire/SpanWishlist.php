<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\WishList;

class SpanWishlist extends Component
{
    public $wishlist;
    protected $listeners=['render'];
    public function render()
    {
        if (auth()->user()){
            $this->wishlist = WishList::where('user_id',auth()->user()->id)->get();
        }
        return view('livewire.span-wishlist');
    }

    public function mount()
    {
        if (auth()->user()){
            $this->wishlist = WishList::where('user_id',auth()->user()->id)->get();
        }
    }
}
