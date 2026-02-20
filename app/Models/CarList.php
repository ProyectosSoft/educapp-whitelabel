<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarList extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function cupon()
    {
        return $this->belongsTo('App\Models\CarList');
    }
}
