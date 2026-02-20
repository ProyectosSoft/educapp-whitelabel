<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class AuditLog extends Component
{
    use WithPagination;

    public $search;
    public $perPage = 10;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $audits = \App\Models\Audit::with('user')
            ->where(function($query){
                $query->where('event', 'like', '%'.$this->search.'%')
                      ->orWhere('ip_address', 'like', '%'.$this->search.'%')
                      ->orWhereHas('user', function($q){
                          $q->where('name', 'like', '%'.$this->search.'%')
                            ->orWhere('email', 'like', '%'.$this->search.'%');
                      });
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.audit-log', compact('audits'))->layout('layouts.admin');
    }
}
