<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Leccioncurso>
 */
class LeccioncursoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre'=>$this->faker->sentence(10),
            'url'=>'https://youtu.be/-hYFFU68uwc',
            'iframe'=>'<iframe width="560" height="315" src="https://www.youtube.com/embed/-hYFFU68uwc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>',
            'estado'=>1,
        ];
    }
}
