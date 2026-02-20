<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Empresa;
use App\Models\Departamento;
use Spatie\Permission\Models\Role;
use Laravel\Jetstream\Jetstream;

class BusinessController extends Controller
{
    /**
     * Show the business registration form.
     */
    public function create()
    {
        return view('auth.register-business');
    }

    /**
     * Handle the business registration request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => ['required', 'string', 'max:255', 'unique:empresas,nombre'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ]);

        return DB::transaction(function () use ($request) {
            // 1. Create Business
            // Generate slug from name
            $slug = \Illuminate\Support\Str::slug($request->company_name);
            // Ensure unique slug (simple check)
            $count = Empresa::where('slug', 'LIKE', "{$slug}%")->count();
            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }

            $empresa = Empresa::create([
                'nombre' => $request->company_name,
                'slug' => $slug,
                // Add default placeholders for CEO fields if required by DB strict mode, or nullable
                'ceo_nombre' => 'Pending',
                'estado' => 1, // Active by default
            ]);

            // 2. Create Default Department
            $departamento = Departamento::create([
                'nombre' => 'General',
                'empresa_id' => $empresa->id,
                'jefe_nombre' => $request->name, // Assign admin as department head
            ]);

            // 3. Create User (Admin)
            // Note: We create user then assign role.
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'empresa_id' => $empresa->id,
                'departamento_id' => $departamento->id,
            ]);

            // 4. Assign Role
            $roleName = 'Administrador de Empresa';
            if (!Role::where('name', $roleName)->exists()) {
                 Role::create(['name' => $roleName, 'guard_name' => 'web']);
            }
            
            $user->assignRole($roleName);

            // 5. Login
            Auth::login($user);

            // 6. Redirect to Company Dashboard
            return redirect()->route('admin.empresas.edit', $empresa->id);
        });
    }
}
