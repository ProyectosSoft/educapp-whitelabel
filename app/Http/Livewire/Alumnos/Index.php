<?php

namespace App\Http\Livewire\Alumnos;

use Livewire\Component;
use App\Models\Curso;
use App\Models\WishList;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $mostrarTabla = true;
    public $mostrarTablaFav = false;
    public $mostrarTablaCar = false;
    public function render()
    {
        // Obtén el usuario autenticado
        $user = Auth::user();
        $cursos = Curso::all();
        // Filtra los cursos por el usuario autenticado
        $NumCursos = $user->cursos_asignado->count();
        $MisCursos = $user->cursos_asignado;
        $NumCart = Cart::count();
        $NumFavoritos = WishList::where('user_id', auth()->user()->id)->count();

        // Obtén los cursos en la lista de deseos del usuario
        $wishlistCursosIds = WishList::where('user_id', $user->id)
            ->pluck('curso_id')
            ->toArray();
        $cursosEnWishlist = Curso::whereIn('id', $wishlistCursosIds)->get();



        return view('livewire.alumnos.index', compact('NumCursos', 'MisCursos', 'NumFavoritos', 'NumCart', 'cursosEnWishlist'));
    }

    public function toggleMostrarTabla()
    {
        $this->mostrarTabla = !$this->mostrarTabla;
        $this->mostrarTablaFav = false;
        $this->mostrarTablaCar = false;
    }

    public function toggleMostrarTablaFav()
    {
        $this->mostrarTablaFav = !$this->mostrarTablaFav;
        $this->mostrarTabla =  false;
        $this->mostrarTablaCar = false;
    }

    public function toggleMostrarTablaCar()
    {
        $this->mostrarTablaCar = !$this->mostrarTablaCar;
        $this->mostrarTablaFav = false;
        $this->mostrarTabla =  false;

    }

}
