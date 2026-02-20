<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\Auth;

class Settings extends Component
{
    public $state = [
        'current_password' => '',
        'password' => '',
        'password_confirmation' => '',
    ];

    public function updatePassword(UpdateUserPassword $updater)
    {
        $this->resetErrorBag();

        $updater->update(Auth::user(), $this->state);

        $this->state = [
            'current_password' => '',
            'password' => '',
            'password_confirmation' => '',
        ];

        session()->flash('success', 'Contraseña actualizada exitosamente.');
    }

    public function render()
    {
        return view('livewire.admin.settings')
            ->layout('layouts.admin-tailwind');
    }
}
