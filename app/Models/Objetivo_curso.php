<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objetivo_curso extends Model
{
    protected $guarded=['id'];
    use HasFactory;


    //Relacio uno a Muchos Inversa
    public function Curso(){
        return $this->belongsTo('App\Models\Curso');
    }
}
