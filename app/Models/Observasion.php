<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observasion extends Model
{
    use HasFactory;
    protected $fillable = ['body','curso_id'];

    //Relacion uno a uno inversa
    public function curso(){
        return $this->belongsTo('App\Models\Curso');
    }
}
