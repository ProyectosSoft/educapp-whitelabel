<?php

namespace Database\Seeders;

use App\Models\price;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        price::create([
            'nombre' => 'Gratis',
            'valor' => 0,
            'dctoMax' => 0,
            'dctoMin' => 0,
            'estado' => 1,
            'moneda_id' => 1,
            'user_id' => 1,
        ]);

        price::create([
            'nombre' => 'Básico',
            'valor' => 9.99,
            'dctoMax' => 0,
            'dctoMin' => 0,
            'estado' => 1,
            'moneda_id' => 1,
            'user_id' => 1,
        ]);
        
        price::create([
            'nombre' => 'Premium',
            'valor' => 19.99,
            'dctoMax' => 10,
            'dctoMin' => 5,
            'estado' => 1,
            'moneda_id' => 1,
            'user_id' => 1,
        ]);
    }
}
