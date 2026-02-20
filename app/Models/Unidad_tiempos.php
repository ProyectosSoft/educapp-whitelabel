<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidad_tiempos extends Model
{

    protected $guarded=['id'];
    use HasFactory;

    //Relacion uno a muchos

    //Relacion uno a muchos inversa
    public function garantias(){
        return $this->hasMany ('App\Models\Unida_tiempo');
    }
}
