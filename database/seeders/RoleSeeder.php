<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Ensure permissions exist
        $permissions = [
            'Crear cursos', 'Leer cursos', 'Actualizar cursos', 'Eliminar cursos',
            'Ver dashboard', 'Crear role', 'Listar role', 'Editar role', 'Eliminar role',
            'Leer usuarios', 'Editar usuarios', 'Ver Dashboard Alumno',
            'Ver Dashboard Instructor', 'Ver Dashboard Admin', 'Ver Dashboard Afiliado'
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $role = Role::firstOrCreate(['name' => 'Administrador', 'guard_name' => 'web']);
        // Assign all permissions to Admin instead of hardcoded IDs
        $role->syncPermissions(\Spatie\Permission\Models\Permission::all());

        $role = Role::firstOrCreate(['name' => 'Instructor', 'guard_name' => 'web']);
        $role->syncPermissions([
            'Crear cursos',
            'Leer cursos',
            'Actualizar cursos',
            'Eliminar cursos',
            'Ver Dashboard Instructor',
            'Ver financiero instructor'
        ]);

        $role = Role::firstOrCreate(['name' => 'Alumno','guard_name' => 'web']);
        $role->syncPermissions(['Ver Dashboard Alumno']);

        $role = Role::firstOrCreate(['name' => 'Aliado','guard_name' => 'web']);
        $role->syncPermissions(['Ver Dashboard Afiliado']);
    }
}
