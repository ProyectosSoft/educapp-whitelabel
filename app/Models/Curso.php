<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Curso extends Model
{
    protected $guarded=['id,status'];
    protected $withCount=['students','Resena_curso'];
    use HasFactory;

    const BORRADOR=1;
    const REVISION=2;
    const PUBLICADO=3;

        // // Define los valores por defecto para los atributos
        // protected $attributes = [
        //     'status' => '2', // Valor por defecto para el campo 'status'
        // ];


    //Query Scopes

    public function scopeCategoria($query,$categoria_id){
        if($categoria_id){
            return $query->where('categoria_id',$categoria_id);
        };
    }

    public function scopeNivel($query,$nivel_id){
        if($nivel_id){
            return $query->where('nivel_id',$nivel_id);
        };
    }

    public function getRatingAttribute(){
         return $this->Resena_curso->avg('calificacion');
    }

    public function getRouteKeyName()
    {
        return "slug";
    }

    //Relacion uno a uno

    public function observation(){
        return $this->hasOne('App\Models\Observasion');
    }

    //Relacion uno a uno inversa
    public function garantia(){
        return $this->belongsTo('App\Models\Garantia');
    }

    //Relacion uno a muchos inversa
    public function teacher(){
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function Tipo_formato(){
        return $this->belongsTo('App\Model\Tipo_formato');
    }

    public function Nivel(){
        return $this->belongsTo('App\Models\Nivel');
    }

    public function Categoria(){
        return $this->belongsTo('App\Models\Categoria');
    }

    public function orderItems()
    {
        return $this->hasMany('App\Models\OrderItems');
    }
    //Relacion uno a muchos
    public function Resena_curso(){
        return $this->hasMany('App\Models\Resena_curso');
     }

     public function Precio(){
        return $this->hasOne('App\Models\Precio');
    }

    public function favoritos(){
        return $this->hasMany('App\Models\WishList');
    }

    public function Requerimiento_curso(){
        return $this->hasMany('App\Models\Requerimiento_curso');
    }

    public function Objetivo_curso(){
        return $this->hasMany('App\Models\Objetivo_curso');
    }
    public function Seccion_curso(){
        return $this->hasMany('App\Models\Seccion_curso');
    }

    public function Cupon_curso(){
        return $this->hasMany('App\Models\Cupon');
    }

    public function  Referral_curso(){
        return $this->hasMany('App\Models\Referralcode');
    }


    //Realcion muchos a muchos

    public function students(){
        return $this->belongsToMany('App\Models\User');
    }

    public function Idioma(){
        return $this->hasMany('App\Models\Idioma');
    }
    public function User(){
        return $this->hasMany('App\Model\User');
    }
    public function Husos_horarios(){
        return $this->hasMany('App\Models\Husos_horarios');
    }

    //Realcion uno a uno Poliformica
    public function image()
    {
        return $this->morphOne('App\Models\Image','imageable');
    }

    //Relacion hasManyThrough
    public function lecciones(){
        return $this->HasManyThrough('App\Models\Leccioncurso','App\Models\Seccion_curso');
    }

    public function evaluations()
    {
        return $this->hasMany('App\Models\Evaluation', 'course_id');
    }

    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }

    public function departamento()
    {
        return $this->belongsTo('App\Models\Departamento');
    }
}
