<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cupon extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    //Realcion muchos a muchos
    public function Husos_horarios()
    {
        return $this->hasMany('App\Models\Husos_horarios');
    }

    public function User()
    {
        return $this->hasMany('App\Models\User');
    }

    //Relacion uno a muchos inversa
    public function Curso()
    {
        return $this->belongsTo('App\Models\Curso');
    }

    public function cartlists()
    {
        return $this->hasMany('App\Models\Cupon');
    }
}
