<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $categorias=[
            [
                'nombre'=>'Animales y Mascotas',
                'slug' => Str::slug('Animales y Mascotas'),
                'icon' => '<i class="fas fa-paw"></i>',
                'estado'=>1,
            ],
            [
                'nombre'=>'Autoconocimiento y Espiritualidad',
                'slug' => Str::slug('Autoconocimiento y Espiritualidad'),
                'icon' => '<i class="fas fa-hamsa"></i>',
                'estado'=>1,
            ],
            [
                'nombre'=>'Carrera y Desarrollo Personal',
                'slug' => Str::slug('Carrera y Desarrollo Personal'),
                'icon' => '<i class="fas fa-user-friends"></i>',
                'estado'=>1,
            ],
            [
                'nombre'=>'Culinaria y Gastronomía',
                'slug' => Str::slug('Culinaria y Gastronomía'),
                'icon' => '<i class="fas fa-cocktail"></i>',
                'estado'=>1,
            ]
        ];

        foreach ($categorias as $categoria) {
            $categoria=Categoria::factory(1)->create($categoria)->first();

         }
    }
}
