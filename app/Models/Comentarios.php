<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentarios extends Model
{
    protected $guarded=['id'];
    use HasFactory;



    //Relacion uno a muchos inversa
     public function Clasificacion_comentario(){
        return $this->belongsTo('App\Model\Clasificacion_comentario');
     }

     public function Seccion_curso(){
        return $this->belongsTo('App\Model\Seccion_curso');
     }

     public function User(){
        return $this->belongsTo('App\Model\User');
     }

     //Relacion uno a muchos
     public function Respuesta_comentario(){
        return $this->hasMany('App\Model\Respuesta_comentario');
     }
}

