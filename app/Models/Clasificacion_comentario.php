<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clasificacion_comentario extends Model
{
    protected $guarded=['id'];
    use HasFactory;


    //Relacion uno a muchos
    public function Comentarios(){
        return $this->hasMany('App\Model\Comentarios');
     }
}
