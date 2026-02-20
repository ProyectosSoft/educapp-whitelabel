<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil_usuario extends Model
{

    protected $guarded=['id'];
    use HasFactory;

    //Relacion uno a uno Inversa
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    //Relacion uno a Muchos Inversa
    public function Pais(){
        return $this->belongsTo('App\Models\Pais');
    }



    //Relacion Muchos a Muchos Inversa
    public function Forma_pago (){
        return $this->belongsToMany('App\Models\Forma_pago');
     }
}
