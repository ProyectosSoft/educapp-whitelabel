<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Precio>
 */
class PrecioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre'=>'Plan A',
            'valor'=>20000,
            'dctoMax'=>0,
            'dctoMin'=>0,
            'estado'=>1,
            'moneda_id'=>1,
            'estado'=>1,
            'user_id'=>1,
        ];
    }
}
