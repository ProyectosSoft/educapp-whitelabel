<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resena_curso>
 */
class Resena_cursoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'comentarios' => $this->faker->text(),
            'calificacion' => $this->faker->numberBetween(3, 5),
            'user_id' => User::all()->random()->id
        ];
    }
}
