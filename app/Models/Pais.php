<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{

    protected $guarded=['id'];
    use HasFactory;


    //Relacion uno a muchos
    public function Perfil_usuario(){
        return $this->hasMany('App\Model\Perfil_usuario');
    }
}
