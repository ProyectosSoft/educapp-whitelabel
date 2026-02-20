<?php

namespace App\Http\Livewire;

use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Price;

use Livewire\Component;

class SelectProfile extends Component
{
    public $user;

    public function render()
    {
        $roles = Role::where('name', '!=', 'Administrador')->get();

        return view('livewire.select-profile', compact('roles'));
    }

    public function selectProfile(User $userId, $roleId)
    {
        $userId->roles()->sync($roleId);
        if ($roleId == 2) {
            Price::create([
                'nombre' => 'defualt',
                'valor' => 0,
                'dctoMin' => 0,
                'dctoMax' => 0,
                'estado' => 1,
                'curso_id' => 1,
                'moneda_id' => 1,
                'user_id' => $userId->id,
            ]);
        }

        return redirect()->route('home');
    }
    // public function selectProfile(User $user,Int $role)
    // {
    //     $user->roles()->sync($role);
    //     return redirect()->route('home');
    // }
}
