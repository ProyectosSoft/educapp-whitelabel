<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Curso;
use App\Models\Garantia;
use App\Models\Idioma;
use App\Models\Pais;
use App\Models\Precio;
use App\Models\Tipo_formato;
use App\Models\Unida_tiempo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Storage::deleteDirectory('public/cursos');
        Storage::deleteDirectory('public/categories');


        Storage::makeDirectory('public/cursos');
        Storage::makeDirectory('public/categories');
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        // $this->call(CategoriaSeeder::class);
        // $this->call(SubcategoriaSeeder::class);
        $this->call(NivelSeeder::class);
        $this->call(IdiomaSeeder::class);
        $this->call(Tipo_formatoSeeder::class);
        $this->call(PaisSeeder::class);
        $this->call(Unidad_tiemposSeeder::class);
        $this->call(GarantiasSeeder::class);
        $this->call(MonedaSeeder::class);
        // $this->call(PriceSeeder::class);
        // $this->call(CursoSeeder::class);
        // $this->call(TransactionSeeder::class);


    }
}
