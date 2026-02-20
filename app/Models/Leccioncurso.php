<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leccioncurso extends Model
{
    use HasFactory;
    protected $guarded=['id'];



    public function getCompletedAttribute(){
      return $this->User->contains(auth()->user()->id);
    }

    //Relacion uno a uno
    public function descripcion(){
        return $this->hasOne('App\Models\Descripcion');
    }
    //Relacion uno a muchos

    //Relacion muchos a muchos
    public function User(){
        return $this->belongsToMany('App\Models\User');
    }
    public function Evaluaciones(){
        return $this->hasMany('App\Models\Evaluaciones');
    }
    //Relacion uno a muchos Inversa

    //Relacion muchos a muchos inversa

    //Relacion uno a uno poliformica

    public function resource(){
        return $this->morphOne('App\Models\Resource','resourceable');
    }
}
