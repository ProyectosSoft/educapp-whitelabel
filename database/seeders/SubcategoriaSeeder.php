<?php

namespace Database\Seeders;

use App\Models\Subcategoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubcategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subcategoria::Create([
            'nombre'=>'Mascotas',
            'categoria_id'=>1,
            'estado'=>1,
        ]);

        Subcategoria::Create([
            'nombre'=>'Astrología',
            'categoria_id'=>2,
            'estado'=>1,
        ]);
        Subcategoria::Create([
            'nombre'=>'Espiritualidad',
            'categoria_id'=>2,
            'estado'=>1,
        ]);
        Subcategoria::Create([
            'nombre'=>'Meditar',
            'categoria_id'=>2,
            'estado'=>1,
        ]);
        Subcategoria::Create([
            'nombre'=>'Teología',
            'categoria_id'=>2,
            'estado'=>1,
        ]);
        Subcategoria::Create([
            'nombre'=>'Carrera',
            'categoria_id'=>3,
            'estado'=>1,
        ]);
        Subcategoria::Create([
            'nombre'=>'Coaching',
            'categoria_id'=>3,
            'estado'=>1,
        ]);
        Subcategoria::Create([
            'nombre'=>'Desarrollo Personal',
            'categoria_id'=>3,
            'estado'=>1,
        ]);
        Subcategoria::Create([
            'nombre'=>'Oratoria',
            'categoria_id'=>3,
            'estado'=>1,
        ]);
        Subcategoria::Create([
            'nombre'=>'Repostería',
            'categoria_id'=>4,
            'estado'=>1,
        ]);
        Subcategoria::Create([
            'nombre'=>'Cocteles',
            'categoria_id'=>4,
            'estado'=>1,
        ]);
        Subcategoria::Create([
            'nombre'=>'Gastronomia',
            'categoria_id'=>4,
            'estado'=>1,
        ]);
        Subcategoria::Create([
            'nombre'=>'Ingresos',
            'categoria_id'=>4,
            'estado'=>1,
        ]);



    }
}
