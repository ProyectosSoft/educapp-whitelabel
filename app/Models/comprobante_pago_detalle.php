<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comprobante_pago_detalle extends Model
{
    protected $guarded=['id'];
    use HasFactory;

    public function comprobantePago()
    {
        return $this->belongsTo('App\Models\comprobante_pago');
    }
}
