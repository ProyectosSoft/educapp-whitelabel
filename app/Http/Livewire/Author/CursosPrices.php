<?php

namespace App\Http\Livewire\Author;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Curso;
use App\Models\Price;
use App\Models\Moneda;
use App\Http\Livewire\Auth;

class CursosPrices extends Component
{
    use WithPagination;
    public $course,$search,$nombre,$valor,$descuentomin,$descuentomax,$moneda,$userId;
    public $openForm2 = false;
    public $priceId = 0;
    public function mount(Curso $course){
        $this->course=$course;
    }

    public function updatingsSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        //Busca el usuario activo
        $idUsuario = auth()->user()->id;

        //Buscar las monedas
        $monedas=Moneda::all();

        //Busca los precios relacionados con el usuario activo
        $prices = Price::with('moneda')
                ->where('user_id', $idUsuario)
                ->get();
        return view('livewire.author.cursos-prices',compact('prices','monedas'))->layout('layouts.author',['course'=>$this->course]);
    }

    public function abrirFormulario()
    {
        $this->openForm2 = true;
        // Restablecer cuponId cuando se abra el formulario para evitar conflictos
        $this->priceId = null;
    }

    public function editarCupon($priceId)
    {
        $this->priceId = $priceId;
        $this->openForm2 = true;
    }

    public function edit($priceId)
    {
        $Price = Price::find($priceId);
        if ( $Price) {
            $this->priceId =  $Price->id;
            $this->nombre =  $Price->nombre;
            $this->valor =  $Price->valor;
            $this->valor =  $Price->valor;
            $this->descuentomax =  $Price->dctoMax;
            $this->descuentomin =  $Price->dctoMin;
            $this->moneda = $Price->mondeda;
            $this->openForm2 = true; // Abre el formulario de edición
        }
    }

    public function saveOrUpdate()
    {
         if ($this->priceId>0) {
            $price = Price::find($this->priceId);
            if ($price) {
                $price->update([
                    'nombre' => $this->nombre,
                    'valor' => $this->valor,
                    'dctoMin' => $this-> descuentomin,
                    'dctoMax' => $this->descuentomax,
                    'moneda_id' => $this->moneda,
                    'user_id' =>  auth()->user()->id,
                ]);
            }
        } else {

                    // Validar los datos
        $this->validate([
            'nombre' => 'required',
            'valor' => 'required|numeric',
            'descuentomax' => 'required|numeric',
            'descuentomin' => 'required|numeric',
            'moneda' =>'required',

        ]);
        Price::create([
            'nombre' => $this->nombre,
            'valor' => $this->valor,
            'dctoMin' => $this-> descuentomin,
            'dctoMax' => $this->descuentomax,
            'estado' => 1,
            'curso_id' => 1,
            'moneda_id' => 1,
            'user_id' => auth()->user()->id,
            ]);
        }

        // Limpiar los campos del formulario y cerrar el formulario
        $this->reset(['nombre','valor','descuentomin','descuentomax','moneda']);
        $this->openForm2 = false;
    }

}
