<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpresaInvitation;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'nit', 'slug', 'ceo_nombre', 'ceo_firma', 'estado'];

    public function departamentos()
    {
        return $this->hasMany(Departamento::class);
    }

    public function invitations()
    {
        return $this->hasMany(EmpresaInvitation::class);
    }
}
