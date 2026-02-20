<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seccion_curso extends Model
{

    protected $guarded=['id'];
    use HasFactory;

    //Relacion uno a muchos
    public function Comentarios(){
        return $this->hasMany('App\Models\Comentarios');
    }
    public function Leccion_curso(){
        return $this->hasMany('App\Models\Leccion_curso');
    }

    public function Leccioncurso(){
        return $this->hasMany('App\Models\Leccioncurso');
    }

    //Relacion uno a muchos inversa
    public function Curso(){
        return $this->belongsTo('App\Models\Curso');
    }

    public function evaluations()
    {
        return $this->hasMany('App\Models\Evaluation', 'section_id');
    }
}
