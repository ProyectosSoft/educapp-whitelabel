<?php
namespace App\Http\Livewire;
use App\Models\CarList;
use Livewire\Component;
class DropdownCart extends Component
{
    public $carlist;
    protected $listeners = ['render'];
    public function mount()
    {

        // Obtener los registros del carrito de compras
        if (auth()->user()){
            $this->carlist = CarList::where('user_id', auth()->user()->id)
            ->where('estado', 1)
            ->get();
        }
        // Pasar los datos del carrito de compras a la vista
        return view('livewire.dropdown-cart')->with('carlist', $this->carlist);
    }

    public function render()
    {
        // Obtener los registros del carrito de compras
        if (auth()->user()){
            $this->carlist = CarList::where('user_id', auth()->user()->id)
            ->where('estado', 1)
            ->get();
        }
        // Pasar los datos del carrito de compras a la vista
        return view('livewire.dropdown-cart')->with('carlist', $this->carlist);
    }
}
