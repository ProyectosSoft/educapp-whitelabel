<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comprobante_pago extends Model
{
    protected $guarded=['id'];
    use HasFactory;

    const PEDIENTE = 1;
    const RECIBIDO = 2;
    const ENVIADO = 3;
    const ENTREGADO = 4;
    const ANULADO = 5;
    const PAGADO = 6;



    public function persona()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }


    public function detalles()
    {
        return $this->hasMany('App\Models\comprobante_pago_detalle');
    }

}
