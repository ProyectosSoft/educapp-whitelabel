<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Curso;
use App\Models\Garantia;
use App\Models\Nivel;
use App\Models\Precio;
use App\Models\Tipo_formato;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Curso>
 */
class CursoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title=$this->faker->sentence(10);
        return [
            'nombre' => $title,
            'subtitulo' => $this->faker->sentence(10),
            'descripcion' => $this->faker->paragraph(10),
            'status' => $this->faker->randomElement([Curso::BORRADOR,Curso::REVISION,Curso::PUBLICADO]),
            'slug' => Str::slug($title),
           /* 'user_id'=>User::all()->random()->id,*/
            'user_id'=>$this->faker->randomElement([1,2,3,4,5]),
            'nivel_id'=>Nivel::all()->random()->id,
            'garantia_id'=>Garantia::all()->random()->id,
            'tipo_formato_id'=>Tipo_formato::all()->random()->id,
            // 'precio_id'=>Precio::all()->random()->id,
            'categoria_id'=>Categoria::all()->random()->id,
            'estado'=>1,



        ];
    }
}
