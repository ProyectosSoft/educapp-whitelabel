<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Cursos
            'Crear cursos',
            'Leer cursos',
            'Actualizar cursos',
            'Eliminar cursos',
            
            // Dashboard Access
            'Ver dashboard',            // Admin
            'Ver Dashboard Alumno',
            'Ver Dashboard Instructor',
            'Ver Dashboard Admin',      // Redundant with 'Ver dashboard'? Keeping for safety
            'Ver Dashboard Afiliado',

            // Roles & Permissions (Admin)
            'Crear role',
            'Listar role',
            'Editar role',
            'Eliminar role',

            // Users (Admin)
            'Leer usuarios',
            'Editar usuarios',     // Includes banning/managing

            // Categorias (Admin)
            'Crear categorias',
            'Leer categorias',
            'Actualizar categorias',
            'Eliminar categorias',

            // Subcategorias (Admin)
            'Crear subcategorias',
            'Leer subcategorias',
            'Actualizar subcategorias',
            'Eliminar subcategorias',

            // Empresas (Corporativo)
            'Crear empresas',
            'Leer empresas',
            'Actualizar empresas',
            'Eliminar empresas',

            // Departamentos (Corporativo)
            'Crear departamentos',
            'Leer departamentos',
            'Actualizar departamentos',
            'Eliminar departamentos',

            // Financiero
            'Ver financiero admin',       // Admin
            'Ver financiero instructor',  // Instructor

            // Auditoría y Configuración
            'Ver auditoria',
            'Ver dashboard',            // Admin
            'Ver configuracion',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }
    }
}
