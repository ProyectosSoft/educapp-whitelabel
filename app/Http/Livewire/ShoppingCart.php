<?php

namespace App\Http\Livewire;

// use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;
use App\Models\CarList;
use Illuminate\Support\Facades\Session;

class ShoppingCart extends Component
{
    public $carlist;
    protected $listeners = ['render'];


    public function destroy()
    {
        // Vaciar completamente el carrito de compras
        // $this->carlist->each->delete();
        // Vaciar completamente el carrito de compras por usuario
        if (auth()->user()) {
            // Obtener el ID del usuario autenticado
            $userId = auth()->user()->id;

            // Borrar los items del carro de compras del usuario
            Carlist::where('user_id', $userId)->delete();
        }
        // Emitir evento para actualizar la vista del carrito
        $this->emitTo('dropdown-cart', 'render');
        $this->emitTo('span-cart', 'render');
    }

    public function delete($carlistId)
    {
        // Buscar el registro en el carrito por su ID y eliminarlo
        $carlistItem = CarList::find($carlistId);
        if ($carlistItem) {
            $carlistItem->delete();
            // Emitir evento para actualizar la vista del carrito
            $this->emitTo('dropdown-cart', 'render');
            $this->emitTo('span-cart', 'render');
        }
    }
    public function render()
    {

        if (auth()->user()) {
            $this->carlist = CarList::where('user_id', auth()->user()->id)
            ->where('estado',1 )
            ->get();
        }
        return view('livewire.shopping-cart');
    }
}
