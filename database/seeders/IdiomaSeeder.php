<?php

namespace Database\Seeders;

use App\Models\Idioma;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IdiomaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Idioma::Create([
            'nombre'=>'Ingles',
            'estado'=>1,
        ]);
        Idioma::Create([
            'nombre'=>'Español',
            'estado'=>1,
        ]);
        Idioma::Create([
            'nombre'=>'Protugues',
            'estado'=>1,
        ]);
    }
}
