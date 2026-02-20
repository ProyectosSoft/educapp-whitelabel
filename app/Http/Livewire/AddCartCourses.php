<?php

namespace App\Http\Livewire;


use Livewire\Component;
use App\Models\CarList;
// use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;


class AddCartCourses extends Component
{
    public $qty = 1;
    public $course;
    public $option = [];
    public $successMessage;
    public $errorMessage;


    public function mount()
    {
        $this->option['image'] = Storage::url($this->course->image->url);
    }
    public function addItem()
    {
        $userId = null;
        $sessionId = null;

        // Verificar si el usuario está autenticado
        if (auth()->check()) {
            // El usuario está autenticado, obtener su ID de usuario
            $userId = auth()->user()->id;
            // Verificar si ya existe un registro en la lista de deseos para este curso y usuario
            $existingCarList = CarList::where('user_id', $userId)
                ->where('curso_id', $this->course->id)
                ->where('estado', 1)
                ->first();
        } else {
        // El usuario no está autenticado, mostrar mensaje para iniciar sesión o registrarse
        $this->errorMessage = 'Para añadir este curso a tu carrito de compras debes <a href="' . route('login') . '">iniciar sesión</a> o <a href="' . route('register') . '">registrarte</a>.';
        return;
        }

        // Si ya existe un registro, mostrar mensaje de error
        if ($existingCarList) {
            $this->errorMessage = 'Curso ya está en el carrito.';
        } else {
            // Si no existe, crear un nuevo registro en la lista de deseos
            $carList = new CarList();
            $carList->price = $this->course->precio->valor;
            $carList->currency = 'COP';
            $carList->nombre = $this->course->nombre;
            $carList->url = $this->course->image->url;
            $carList->descuento = 0;
            $carList->subtotal = $this->course->precio->valor;
            $carList->impuestos = $this->course->precio->valor;
            $carList->total = $this->course->precio->valor;
            $carList->session_id = $sessionId;
            $carList->user_id = $userId;
            $carList->instructor_id= $this->course->teacher->id;
            $carList->instructor_name= $this->course->teacher->name;
            $carList->curso_id = $this->course->id;
            $carList->curso_name = $this->course->nombre;
            $carList->cupon_id =1;
            $carList->estado = 1;
            $carList->save();

            // Mostrar mensaje de éxito
            $this->successMessage = 'Curso añadido al carrito.';
        }

        // Emitir eventos para renderizar el carrito
        $this->emitTo('dropdown-cart', 'render');
        $this->emitTo('span-cart', 'render');
    }
    public function render()
    {
        return view('livewire.add-cart-courses');
    }
}
