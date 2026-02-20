<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {

        $starDate ='-1 month'; //Fecha de inicio un mesw atras
        $endDate ='now';// Fecha fin, igual a fecha actual
        $typeTransaction = ['Venta', 'Devolucion'];
        return [
            'date' => $this->faker->dateTimeBetween($starDate,$endDate),
            'name' => $this->faker->name(),
            'transaction' => $this->faker->randomElement($typeTransaction),
            'number' => $this->faker->numberBetween(0,100),
            'detail' => "Creación: REMISIÓN DE VENTA: PPAL-3340 (transacción vigente) Cliente: 1551354132. CC: 1020455861",
            'total' =>$this->faker->numberBetween(1000,10000),
            'observation'=> "N/A",
            'status' => "Activa"
        ];
    }
}
