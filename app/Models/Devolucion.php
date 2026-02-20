<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
    use HasFactory;
    protected $guarded=['id','created_at','updated_at','status'];
    const PEDIENTE=1;
    const RECIBIDO=2;
    const ENVIADO=3;
    const ENTREGADO=4;
    const ANULADO=5;
    const PAGADO=6;

    public function items()
    {
        return $this->hasMany('App\Models\DevolucionItem');
    }
}
