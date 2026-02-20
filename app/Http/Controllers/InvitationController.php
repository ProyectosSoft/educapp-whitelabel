<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\EmpresaInvitation;

class InvitationController extends Controller
{
    public function accept($uuid)
    {
        $invitation = EmpresaInvitation::where('uuid', $uuid)->firstOrFail();

        // Validations
        if ($invitation->current_uses >= $invitation->max_uses) {
             return view('auth.invitation-error', ['message' => 'Esta invitación ha alcanzado el límite de usos.']);
        }

        if ($invitation->expires_at && $invitation->expires_at->isPast()) {
             return view('auth.invitation-error', ['message' => 'Esta invitación ha expirado.']);
        }

        // Store in session
        session(['invitation_token' => $uuid]);

        return redirect()->route('register');
    }
}
