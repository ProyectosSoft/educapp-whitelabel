<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CourseSession;

class CourseAudits extends Component
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
        $sessions = CourseSession::with(['user', 'course'])
            ->where(function($query){
                $query->whereHas('user', function($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('email', 'like', '%'.$this->search.'%');
                })
                ->orWhereHas('course', function($q){
                    $q->where('nombre', 'like', '%'.$this->search.'%');
                });
            })
            ->latest('started_at')
            ->paginate($this->perPage);

        return view('livewire.admin.course-audits', compact('sessions'))->layout('layouts.admin');
    }
}
