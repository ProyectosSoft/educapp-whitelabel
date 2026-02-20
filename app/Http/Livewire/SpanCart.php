<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CarList;
use Illuminate\Support\Facades\Session;

class SpanCart extends Component
{
    public $carlist;
    protected $listeners = ['render'];
    public function render()
    {
        // Obtener los registros del carrito de compras
        if (auth()->user()){
            $this->carlist = CarList::where('user_id', auth()->user()->id)
            ->where('estado',1 )
            ->get();
        }
        // Pasar los datos del carrito de compras a la vista
        return view('livewire.span-cart');
    }

    public function mount()
    {
        // Obtener los registros del carrito de compras
        if (auth()->user()){
            $this->carlist = CarList::where('user_id', auth()->user()->id)->get();
        }
    }
}
