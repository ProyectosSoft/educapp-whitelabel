<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Husos_horarios extends Model
{
    protected $guarded=['id'];
    use HasFactory;

    //Relacion muchos a muchos
    public function Cupon(){
        return $this->hasMany('App\Models\Cupon');
    }

    public function Curso(){
        return $this->hasMany('App\Models\Curso');
    }
}
