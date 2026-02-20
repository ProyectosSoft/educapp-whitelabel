<?php

namespace Database\Seeders;

use App\Models\Garantia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GarantiasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Garantia::Create([
            'nombre'=>'Garantía 7 días',
            'valor'=>7,
            'unidad_tiempos_id'=>1,
            'estado'=>1,
        ]);
        Garantia::Create([
            'nombre'=>'Garantía 15 días',
            'unidad_tiempos_id'=>1,
            'valor'=>15,
            'estado'=>1,
        ]);
        Garantia::Create([
            'nombre'=>'Garantía 1 Mes',
            'unidad_tiempos_id'=>2,
            'valor'=>30,
            'estado'=>1,
        ]);
    }
}
