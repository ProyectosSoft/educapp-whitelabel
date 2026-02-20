<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta_evaluaciones extends Model
{
    protected $guarded=['id'];
    use HasFactory;

    //Relacion uno a muchos inversa
    public function Preguntas_evaluaciones(){
        return $this->belongsTo('App\Models\Preguntas_evaluaciones');
    }

    public function User(){
        return $this->belongsTo('App\Models\User');
    }
}
