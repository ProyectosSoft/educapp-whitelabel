<?php

namespace Database\Seeders;

use App\Models\price;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrecioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeding the 'prices' (Catalog) table, NOT 'precios' (Course Instances).
        // This allows creating generic tariffs without needing a course first.

        \App\Models\price::create([
            'nombre'=>'Plan A',
            'valor'=>20000,
            'dctoMax'=>0,
            'dctoMin'=>0,
            'estado'=>1,
            'moneda_id'=>1,
            'user_id'=>1,
        ]);

        \App\Models\price::create([
            'nombre'=>'Plan B',
            'valor'=>40000,
            'dctoMax'=>0,
            'dctoMin'=>0,
            'estado'=>1,
            'moneda_id'=>1,
            'user_id'=>1,
        ]);
    }
}
