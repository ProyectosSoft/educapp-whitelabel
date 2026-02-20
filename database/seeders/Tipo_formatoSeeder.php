<?php

namespace Database\Seeders;

use App\Models\Tipo_formato;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Tipo_formatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tipo_formato::Create([
            'nombre'=>'Video',
            'estado'=>1,
        ]);
        Tipo_formato::Create([
            'nombre'=>'eBooks o Documentos',
            'estado'=>1,
        ]);
        Tipo_formato::Create([
            'nombre'=>'Plantillas, Código fuente',
            'estado'=>1,
        ]);
        Tipo_formato::Create([
            'nombre'=>'software, Porgrama para descargar',
            'estado'=>1,
        ]);
        Tipo_formato::Create([
            'nombre'=>'Curso online',
            'estado'=>1,
        ]);
    }
}
