<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_pregunta_evaluacion extends Model
{
    protected $guarded=['id'];
    use HasFactory;


    //Relacion uno a muchos
    public function Preguntas_evaluaciones(){
        return $this->hasMany('App\Models\Preguntas_evaluaciones');
    }
}
