<?php

namespace Database\Seeders;

use App\Models\Unida_tiempo;
use App\Models\Unidad_tiempos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Unidad_tiemposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unidad_tiempos::Create([
            'nombre'=>'Día',
            'estado'=>1,
        ]);
        Unidad_tiempos::Create([
            'nombre'=>'Mes',
            'estado'=>1,
        ]);
        Unidad_tiempos::Create([
            'nombre'=>'Año',
            'estado'=>1,
        ]);
    }
}
