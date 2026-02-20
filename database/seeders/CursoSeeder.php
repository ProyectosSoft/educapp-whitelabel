<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\Descripcion;
use App\Models\Image;
use App\Models\Leccion_curso;
use App\Models\Objetivo_curso;
use App\Models\Requerimiento_curso;
use App\Models\Seccion_curso;
use App\Models\Leccioncurso;
use App\Models\Precio;
use App\Models\Resena_curso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      // $courses = Curso::factory(40)->create();
      //
      // foreach($courses as $course){
      //   Resena_curso::factory(5)->create([
      //       'curso_id'=>$course->id
      //   ]);
      //
      //   Image::factory(1)->create([
      //       'imageable_id' => $course->id,
      //       'imageable_type' => 'App\Models\Curso'
      //   ]);
      //
      //   Requerimiento_curso::factory(4)->create([
      //       'curso_id'=>$course->id
      //   ]);
      //
      //  Objetivo_curso::factory(4)->create([
      //       'curso_id'=>$course->id
      //   ]);
      //
      //  Precio::factory(1)->create([
      //       'curso_id'=>$course->id
      //   ]);
      //
      //   $sections = Seccion_curso::factory(4)->create([
      //       'curso_id'=>$course->id
      //   ]);
      //
      //   foreach ($sections as $section){
      //       Leccion_curso::factory(4)->create(['seccion_curso_id'=> $section->id]);
      //   }
      //
      //   foreach ($sections as $section){
      //       $lecciones=Leccioncurso::factory(4)->create(['seccion_curso_id'=> $section->id]);
      //       foreach($lecciones as $leccion){
      //          Descripcion::factory(1)->create(['leccioncurso_id'=> $leccion->id]);
      //       }
      //   }
      // }
    }
}
