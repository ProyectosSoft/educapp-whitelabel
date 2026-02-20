<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Clear permission cache to ensure new permissions are recognized immediately
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define new permissions for the Exams Module
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
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assign permissions to roles
        $adminRole = \Spatie\Permission\Models\Role::where('name', 'Administrador')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($permissions);
        }

        $instructorRole = \Spatie\Permission\Models\Role::where('name', 'Instructor')->first();
        if ($instructorRole) {
            $instructorRole->givePermissionTo($permissions);
        }
    }

    public function down(): void
    {
        // Optional: Remove permissions on rollback
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
        ];
        
        // We usually don't delete permissions on rollback in production to avoid data loss on Pivot tables,
        // but for dev it might be useful. Skipping for safety.
    }
};
