<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

use App\Models\Price;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input):User
    {
        $invitation = null;
        if (session()->has('invitation_token')) {
            $invitation = \App\Models\EmpresaInvitation::where('uuid', session('invitation_token'))->first();
        }

        if ($invitation) {
            // Override input with invitation data
            $input['role_id'] = $invitation->role_name === 'Instructor' ? 2 : 3;
            if ($invitation->departamento_id) {
                $input['departamento_id'] = $invitation->departamento_id;
            }
            
            // Validate email if restricted
            if ($invitation->email && $input['email'] !== $invitation->email) {
                \Illuminate\Validation\ValidationException::withMessages([
                    'email' => ['Este correo no coincide con la invitación.'],
                ]);
            }
        }

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'role_id' => $invitation ? ['required'] : ['required', 'integer', 'in:2,3'], 
            'departamento_id' => ['nullable', 'exists:departamentos,id'],
            'documento_identidad' => ['nullable', 'string', 'max:20'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'departamento_id' => $input['departamento_id'] ?? null,
            'empresa_id' => $invitation ? $invitation->empresa_id : null,
        ]);

        // Consume invitation
        if ($invitation) {
            $invitation->increment('current_uses');
            
            \App\Models\EmpresaInvitationLog::create([
                'invitation_id' => $invitation->id,
                'user_id' => $user->id,
                'ip_address' => request()->ip(),
            ]);

            session()->forget('invitation_token');
        }

        // Asignar rol seleccionado por nombre
        $roleName = $input['role_id'] == 2 ? 'Instructor' : 'Alumno';
        $user->assignRole($roleName);

        // Si viene documento de identidad (usuario empresa), crear o actualizar perfil
        if (!empty($input['documento_identidad'])) {
            \App\Models\Perfil_usuario::create([
                'user_id' => $user->id,
                'numerodeidentifacion' => $input['documento_identidad'],
                'pais_id' => 1, // Default por ahora
                'ciudad' => 'N/A',
                'estado' => 1,
            ]);
        }

        // Si es instructor (seleccionó ID 2 / rol Instructor), crear registro de precio por defecto
        if ($input['role_id'] == 2) {
            Price::create([
                'nombre' => 'defualt', // Mantenemos el nombre original usado en SelectProfile
                'valor' => 0,
                'dctoMin' => 0,
                'dctoMax' => 0,
                'estado' => 1,
                'curso_id' => 1,
                'moneda_id' => 1,
                'user_id' => $user->id,
            ]);
        }

        return $user;
    }
}
