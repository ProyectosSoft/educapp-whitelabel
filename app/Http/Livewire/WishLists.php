<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\WishList;
use App\Models\Curso;

class WishLists extends Component
{
    public $cursosEnWishlist;
    public function render()
    {
        if (auth()->user()) {
            $cursos = Curso::all();

            $wishlistCursosIds = Wishlist::where('user_id', auth()->user()->id)
                ->pluck('curso_id')
                ->toArray();

            $this->cursosEnWishlist = $cursos->filter(function ($curso) use ($wishlistCursosIds) {
                return in_array($curso->id, $wishlistCursosIds);
            });
        }
        return view('livewire.wish-lists');
    }

    public function cursowish()
    {
        return $this->belongsTo('App\Models\Curso');
    }
}
