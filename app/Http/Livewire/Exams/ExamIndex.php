<?php

namespace App\Http\Livewire\Exams;

use Livewire\Component;
use App\Models\Exam;

class ExamIndex extends Component
{
    public function render()
    {
        $exams = Exam::with(['evaluations' => function ($query) {
            $query->where('is_active', true)
                  ->with(['userAttempts' => function($q) {
                      $q->where('user_id', auth()->id());
                  }]);
        }])->where('is_active', true)->get();

        return view('livewire.exams.exam-index', compact('exams'))->layout('layouts.app');
    }
}
