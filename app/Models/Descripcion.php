<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descripcion extends Model
{
    protected $guarded=['id'];
    use HasFactory;

    //Relacion uno a uno inversa
    public function leccion(){
        return $this->belongsToMany('App\Models\Leccioncurso');
    }
}
