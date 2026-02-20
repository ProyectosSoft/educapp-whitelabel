<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preguntas_evaluaciones extends Model
{
    protected $guarded=['id'];
    use HasFactory;

    //Relacion uno a muchos
    public function Respuesta_evaluaciones(){
        return $this->hasMany('App\Models\Respuesta_evaluaciones');
    }
    //Relacion uno a muchos inversa
    public function Tipo_pregunta_evaluacion(){
        return $this->belongsTo('App\Models\Tipo_pregunta_evaluacion');
    }

    public function Evaluaciones(){
        return $this->belongsTo('App\Models\Evaluaciones');
    }
}
