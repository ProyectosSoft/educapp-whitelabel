<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresaInvitationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'user_id',
        'ip_address',
    ];

    public function invitation()
    {
        return $this->belongsTo(EmpresaInvitation::class, 'invitation_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
