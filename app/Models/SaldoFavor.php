<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaldoFavor extends Model
{
    use HasFactory;
    const PEDIENTE = 1;
    const RECIBIDO = 2;
    const ENVIADO = 3;
    const ENTREGADO = 4;
    const ANULADO = 5;
    const PAGADO = 6;

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
}
