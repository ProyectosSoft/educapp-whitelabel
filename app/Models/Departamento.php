<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $fillable = ['empresa_id', 'nombre', 'jefe_nombre', 'jefe_firma'];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
    
    public function users()
    {
        return $this->hasMany(User::class, 'departamento_id');
    }
}
