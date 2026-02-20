<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $user = Auth::user();

        if ($user->hasRole('Administrador')) {
            return redirect()->route('admin.home');
        }

        if ($user->hasRole('Administrador de Empresa') && $user->empresa_id) {
            return redirect()->route('admin.empresas.edit', $user->empresa_id);
        }
        
        // Default handling for other users (students, etc.)
        // Usually redirect to home or dashboard
        if ($user->hasRole('Estudiante') || $user->hasRole('Instructor')) {
             return redirect()->intended('/');
        }

        return redirect()->intended(config('fortify.home'));
    }
}
