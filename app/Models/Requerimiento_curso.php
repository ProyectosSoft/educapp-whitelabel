<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requerimiento_curso extends Model
{
    protected $guarded=['id'];
    use HasFactory;

    //Relacion uno a muchos

    //Relacion uno a muchos inversa
    public function curso(){
        return $this->belongsTo('App\Models\Curso');
    }

}
