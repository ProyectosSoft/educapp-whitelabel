<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
class UsersIndex extends Component
{

    use WithPagination;
    // protected $paginationTheme='bootstrap';
    protected $paginationTheme='tailwind';
    public $search;
    public function render()
    {
        // $users=User::where('name', 'LIKE', '%' . $this->search)
        //         -> orwhere('email', 'LIKE', '%' . $this->search . '%')
        //         ->paginate(8);

        $users = User::where('name', 'LIKE', '%' . $this->search . '%')
            ->orWhere('email', 'LIKE', '%' . $this->search . '%')
            ->orWhereHas('roles', function ($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%');
            })
            ->with('roles') // Cargar la relación del rol del usuario
            ->paginate(8);


        return view('livewire.admin.users-index',compact('users'));

    }

    public function limpiar_page(){
        $this->reset('page');
    }
}
