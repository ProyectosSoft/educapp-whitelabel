<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluaciones extends Model
{
    protected $guarded=['id'];
    use HasFactory;

    //relacion uno a muchos
    public function Preguntas_evaluaciones(){
        return $this->hasMany('app\Model\Preguntas_evaluaciones');
    }

    //Relacion muchos a muchos Inversa
    public function Leccion_curso(){
        return $this->hasMany('App\Model\Leccion_curso');
    }
}
