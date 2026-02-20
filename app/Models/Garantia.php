<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garantia extends Model
{
    protected $guarded=['id'];
    use HasFactory;

    //Relacio uno a uno
    public function Curso(){
        return $this->hasOne('App\Models\Curso');
    }

    //Relacion uno a muchos

    //Relacion uno a muchos inversa
    public function Unida_tiempo(){
        return $this->belongsTo('App\Models\Unidad_tiempo');
    }
}
