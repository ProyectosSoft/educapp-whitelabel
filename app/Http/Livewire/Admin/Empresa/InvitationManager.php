<?php

namespace App\Http\Livewire\Admin\Empresa;

use Livewire\Component;
use App\Models\Empresa;
use App\Models\EmpresaInvitation;
use App\Models\Departamento;
use Illuminate\Support\Str;

class InvitationManager extends Component
{
    public $empresa; // Changed to public property, will typehint in mount
    public $empresaId; // To store ID if needed, or just use object
    
    // Form Properties
    public $role = 'Estudiante'; 
    public $departamento_id = ''; // Wire model string
    public $max_uses = 1;
    public $expires_in_days = 7;
    public $email = null;

    // public $invitations; // Don't store models in public properties if not needed for direct binding, fetch in render or computed

    protected $rules = [
        'role' => 'required|in:Estudiante,Instructor',
        'departamento_id' => 'nullable', 
        'max_uses' => 'required|integer|min:1',
        'expires_in_days' => 'required|integer|min:1',
        'email' => 'nullable|email',
    ];

    public function mount(Empresa $empresa)
    {
        $this->empresa = $empresa;
        $this->empresaId = $empresa->id;
    }

    public function create()
    {
        $this->validate();

        $uuid = (string) Str::uuid();

        EmpresaInvitation::create([
            'uuid' => $uuid,
            'empresa_id' => $this->empresaId,
            'departamento_id' => $this->departamento_id ?: null,
            'role_name' => $this->role,
            'email' => $this->email,
            'max_uses' => $this->max_uses,
            'current_uses' => 0,
            'expires_at' => now()->addDays($this->expires_in_days),
            'created_by' => auth()->id(),
        ]);

        $this->reset(['role', 'departamento_id', 'max_uses', 'expires_in_days', 'email']);
        session()->flash('message', 'Invitación generada: <a href="'.route('invite.accept', $uuid).'" class="font-bold underline">'.route('invite.accept', $uuid).'</a>');
    }

    public function delete($id)
    {
        EmpresaInvitation::find($id)->delete();
    }

    public $logs = [];
    public $showLogModal = false;

    public function showLogs($invitationId)
    {
        $this->logs = \App\Models\EmpresaInvitationLog::where('invitation_id', $invitationId)
            ->with('user')
            ->latest()
            ->get();
        $this->showLogModal = true;
    }

    public function closeLogModal()
    {
        $this->showLogModal = false;
        $this->logs = [];
    }

    public function render()
    {
        $departamentos = Departamento::where('empresa_id', $this->empresaId)->get();
        $invitations = EmpresaInvitation::where('empresa_id', $this->empresaId)->latest()->get();
        
        return view('livewire.admin.empresa.invitation-manager', [
            'departamentos' => $departamentos,
            'invitations' => $invitations
        ]);
    }
}
