<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_usuario extends Model
{
    protected $guarded=['id'];
    use HasFactory;


    //Relacion muchos a muchos
    public function user(){
        return $this->hasMany('App\Models\User');
    }
}
