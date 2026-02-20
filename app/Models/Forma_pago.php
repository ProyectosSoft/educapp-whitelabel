<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Forma_pago extends Model
{

    protected $guarded=['id'];
    use HasFactory;

    //Relacion Muchos a Muchos
    public function precio(){
        return $this->belongsToMany('App\Models\precio');
    }
}
