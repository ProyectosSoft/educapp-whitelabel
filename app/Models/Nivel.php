<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    protected $guarded=['id'];
    use HasFactory;

    //Relacion uno a muchos
    public function curso(){
        return $this->hasMany('App\Models\Curso');
    }
}
