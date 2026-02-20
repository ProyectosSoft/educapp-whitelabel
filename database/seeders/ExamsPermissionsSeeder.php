<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ExamsPermissionsSeeder extends Seeder
{
    public function run()
    {
        // 1. Definir los permisos del módulo de exámenes
        $permissions = [
            'Ver dashboard examenes',
            'Crear examenes',
            'Editar examenes',
            'Eliminar examenes',
            'Crear preguntas',
            'Editar preguntas',
            'Eliminar preguntas',
            'Calificar examenes',
            'Ver monitoreo examenes',
            'Ver estadisticas examenes',
            'Gestionar niveles dificultad',
        ];

        // 2. Crear permisos si no existen
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // 3. Asignar todos los permisos al Administrador
        $adminRole = Role::where('name', 'Administrador')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($permissions);
        }

        // 4. Asignar permisos específicos al Instructor
        $instructorRole = Role::where('name', 'Instructor')->first();
        if ($instructorRole) {
            // El instructor puede hacer todo, excepto tal vez borrar exámenes de otros (si hubiera esa lógica), 
            // pero por ahora le daremos acceso completo al módulo para que pueda gestionar sus cursos.
            $instructorRole->givePermissionTo($permissions);
        }
        
        // 5. El Alumno NO debe tener estos permisos (solo 'Ver Dashboard Alumno' que ya tiene)
    }
}
