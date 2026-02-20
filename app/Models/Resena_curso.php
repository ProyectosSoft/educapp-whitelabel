<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resena_curso extends Model
{

    protected $guarded=['id'];
    use HasFactory;

    //Relacion uno a muchos Inversa
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function curso(){
        return $this->belongsTo('App\Models\Curso');
    }
}


