<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precio extends Model
{

    protected $guarded=['id'];
    use HasFactory;
    //Relacion uno a uno inversa
    public function Moneda(){
        return $this->belongsTo('App\Models\Moneda');
    }
    public function Curso(){
        return $this->belongsTo('App\Models\Curso');
    }

    //Relacion uno a muchos




}
