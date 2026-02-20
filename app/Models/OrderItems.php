<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    protected $guarded=['id','created_at','updated_at'];
    use HasFactory;


    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function curso()
    {
        return $this->belongsTo('App\Models\Curso');
    }
}
