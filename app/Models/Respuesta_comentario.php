<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta_comentario extends Model
{
    protected $guarded=['id'];
    use HasFactory;


    //Relacion uno a muchos inversa
    public function Comentarios(){
        return $this->belongsTo('App\Model\Comentarios');
     }

     public function User(){
        return $this->belongsTo('App\Model\User');
     }
}
