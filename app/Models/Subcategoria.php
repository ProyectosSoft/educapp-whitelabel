<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategoria extends Model
{

    protected $fillable = ['nombre', 'categoria_id', 'slug', 'image', 'estado', 'empresa_id', 'es_publica'];
    use HasFactory;

    // Scopes
    public function scopePublicas($query) {
        return $query->whereNull('empresa_id')->orWhere('es_publica', true);
    }

    public function scopeDeEmpresa($query, $empresaId) {
        return $query->where('empresa_id', $empresaId);
    }

    public function scopeParaEmpresa($query, $empresaId = null) {
        if ($empresaId) {
            return $query->where(function($q) use ($empresaId) {
                $q->whereNull('empresa_id')
                  ->orWhere('empresa_id', $empresaId)
                  ->orWhere('es_publica', true);
            });
        }
        return $query->publicas();
    }

    //Realcion uno a Muchos Inversa
    public function Categoria(){
        return $this->belongsTo('App\Models\Categoria');
    }

    public function empresa() {
        return $this->belongsTo('App\Models\Empresa');
    }
}
