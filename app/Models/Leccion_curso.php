<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leccion_curso extends Model
{
    use HasFactory;
    protected $guarded=['id'];


    public function getCompletedAttribute(){
      return $this->users->id ?? '';
      $this->users->contains(auth()->id) ?? '';
    }

    //Relacion uno a muchos

    //Relacion muchos a muchos
    public function User(){
        return $this->belongsToMany('App\Model\User');
    }

    public function Evaluaciones(){
        return $this->hasMany('App\Model\Evaluaciones');
    }

    //Relacion uno a muchos Inversa

    //Relacion muchos a muchos inversa

}
