<?php

namespace App\Http\Livewire;

use App\Models\WishList;
use Livewire\Component;




class AddWishList extends Component
{
    public $course;
    public $successMessage;
    public $errorMessage;
    public function render()
    {

        return view('livewire.add-wish-list');
    }

    public function addWishList()
    {
        if (auth()->check()) {
            // Verificar si ya existe un registro en la lista de deseos para este curso y usuario
            $existingWishList = WishList::where('user_id', auth()->user()->id)
                ->where('curso_id', $this->course->id)
                ->first();

            if ($existingWishList) {
                // Si ya existe un registro, mostrar mensaje de error
                $this->errorMessage = 'Curso ya está en favoritos.';
            } else {
                // Si no existe, crear un nuevo registro en la lista de deseos
                $wishList = new WishList();
                $wishList->price = $this->course->precio->valor;
                $wishList->currency = 'COP';
                $wishList->nombre = $this->course->nombre;
                $wishList->url = $this->course->image->url;
                $wishList->user_id = auth()->user()->id;
                $wishList->curso_id = $this->course->id;
                $wishList->save();

                // Mostrar mensaje de éxito
                $this->successMessage = 'Curso añadido a favoritos.';
            }
        } else {
            // El usuario no está autenticado, mostrar mensaje para iniciar sesión o registrarse
            $this->errorMessage = 'Para añadir este curso a Mis Favoritos debes <a href="' . route('login') . '">iniciar sesión</a> o <a href="' . route('register') . '">registrarte</a>.';
            return;
        }
        $this->emitTo('dropdown-wishlist', 'render');
        $this->emitTo('span-wishlist', 'render');
    }
}
