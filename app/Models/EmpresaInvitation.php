<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresaInvitation extends Model
{
    protected $fillable = [
        'uuid',
        'empresa_id',
        'departamento_id',
        'role_name',
        'email',
        'max_uses',
        'current_uses',
        'expires_at',
        'created_by',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function logs()
    {
        return $this->hasMany(EmpresaInvitationLog::class, 'invitation_id');
    }
}
