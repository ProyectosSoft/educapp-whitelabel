<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{

    protected $fillable = ['nombre', 'slug', 'icon', 'image', 'estado', 'empresa_id', 'es_publica'];
    use HasFactory;

    //Relacion uno a Muchos
    public function Subcategorias(){
        return $this->hasMany('App\Models\Subcategoria');
    }
    public function Curso(){
        return $this->hasMany('App\Models\Curso');
    }
    // Scopes
    public function scopePublicas($query) {
        return $query->whereNull('empresa_id')->orWhere('es_publica', true);
    }

    public function scopeDeEmpresa($query, $empresaId) {
        return $query->where('empresa_id', $empresaId);
    }

    public function scopeParaEmpresa($query, $empresaId = null) {
        if ($empresaId) {
            // Muestra:
            // 1. Categorías globales (empresa_id is NULL)
            // 2. Categorías de la empresa (empresa_id = $empresaId)
            // 3. Categorías de otras empresas que son públicas (es_publica = true)
            return $query->where(function($q) use ($empresaId) {
                $q->whereNull('empresa_id')
                  ->orWhere('empresa_id', $empresaId)
                  ->orWhere('es_publica', true);
            });
        }
        // Si no hay empresa (usuario global?), ver solo públicas globales
        return $query->publicas();
    }

    // Relationships
    public function empresa() {
        return $this->belongsTo('App\Models\Empresa');
    }



}
