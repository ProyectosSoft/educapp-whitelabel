<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Nivel;

class NivelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Nivel::Create([
            'nombre'=>'Nivel básico',
            'estado'=>1,
        ]);
        Nivel::Create([
            'nombre'=>'Nivel intermedio',
            'estado'=>1,
        ]);
        Nivel::Create([
            'nombre'=>'Nivel avanzado',
            'estado'=>1,
        ]);
    }
}
