<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moneda extends Model
{
    protected $guarded=['id'];
    use HasFactory;

    //Relacion uno a uno

    public function Precio(){
        return $this->hasMany('App\Models\Precio');
    }

    public function Price(){
        return $this->hasMany('App\Models\price');
    }

}


