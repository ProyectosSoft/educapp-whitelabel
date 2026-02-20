<?php

namespace Database\Seeders;

use App\Models\Moneda;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MonedaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Moneda::Create([
            'nombre'=>'Peso Colombian',
            'abreviatura'=>'COP',
            'simbolo'=>'$',
            'estado'=>1,
        ]);
        Moneda::Create([
            'nombre'=>'Peso Mexicano',
            'abreviatura'=>'MXN',
            'simbolo'=>'$',
            'estado'=>1,
        ]);
        Moneda::Create([
            'nombre'=>'Dolar Estadounidense',
            'abreviatura'=>'USD',
            'simbolo'=>'$',
            'estado'=>1,
        ]);
    }
}
