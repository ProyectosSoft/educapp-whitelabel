<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_formato extends Model
{

    protected $guarded=['id'];
    use HasFactory;

    //Relacion uno a Muchos

    public function Curso(){
        return $this->hasMany('App\Models\Curso');
    }
}
