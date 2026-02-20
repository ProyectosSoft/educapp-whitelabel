<?php

namespace App\Http\Livewire\Exams;

use Livewire\Component;
use App\Models\ExamUserAttempt;
use App\Models\ExamAttemptAnswer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ExamGrader extends Component
{
    public $selectedAttemptId;
    public $selectedAttempt;
    
    // Grading data: [answer_id => score]
    public $grades = []; 
    public $feedbacks = [];
    public $expandedGroups = []; // [evaluation_id => bool]

    public function render()
    {
        $pendingAttempts = ExamUserAttempt::where('status', 'pending_review')
            ->whereHas('evaluation', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->with(['user', 'evaluation.exam'])
            ->latest('completed_at')
            ->get();
            
        // Group by evaluation_id
        $groupedAttempts = $pendingAttempts->groupBy('evaluation_id');

        return view('livewire.exams.exam-grader', compact('pendingAttempts', 'groupedAttempts'))->layout('layouts.instructor-tailwind');
    }

    public function toggleGroup($evaluationId)
    {
        if (isset($this->expandedGroups[$evaluationId])) {
            unset($this->expandedGroups[$evaluationId]);
        } else {
            $this->expandedGroups[$evaluationId] = true;
        }
    }

    public function selectAttempt($id)
    {
        $this->selectedAttemptId = $id;
        $this->selectedAttempt = ExamUserAttempt::with(['attemptQuestions.question', 'attemptQuestions.answer', 'user', 'evaluation'])
            ->whereHas('evaluation', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->find($id);

        if (!$this->selectedAttempt) {
             $this->selectedAttemptId = null;
             session()->flash('error', 'Intento no encontrado o acceso no autorizado.');
             return;
        }

        // Backfill max_score for legacy attempts if needed
        $needsBackfill = $this->selectedAttempt->attemptQuestions->contains(function($aq) {
             return $aq->max_score <= 0;
        });

        if ($needsBackfill) {
             // For legacy backfill, we just assume a standard point value (e.g. 5) 
             // to ensure the math works (Performance = obtained/max).
             foreach ($this->selectedAttempt->attemptQuestions as $aq) {
                 if ($aq->max_score <= 0) {
                     $aq->max_score = 5; // Default "Medium" points
                     $aq->save();
                 }
             }
             $this->selectedAttempt->refresh();
        }
            
        // Initialize inputs
        foreach ($this->selectedAttempt->attemptQuestions as $aq) {
            if ($aq->question && $aq->question->type === 'open') {
                $ans = $aq->answer;
                if ($ans) {
                    $this->grades[$ans->id] = $ans->score_obtained;
                    $this->feedbacks[$ans->id] = $ans->grader_feedback;
                }
            }
        }
    }

    public function saveGrading()
    {
        $this->resetErrorBag();
        $hasErrors = false;

        // 1. Validation Logic
        foreach ($this->selectedAttempt->attemptQuestions as $aq) {
            if ($aq->question->type === 'open' && $aq->answer) {
                // Ensure we handle "0" or empty inputs correctly
                $score = $this->grades[$aq->answer->id] ?? 0;
                if ($score === '') $score = 0;
                
                // Ensure numeric
                if (!is_numeric($score)) {
                    $this->addError("grades.{$aq->answer->id}", "El valor debe ser numérico.");
                    $hasErrors = true;
                    continue;
                }

                if ($score > $aq->max_score) {
                    $this->addError("grades.{$aq->answer->id}", "El puntaje supera el máximo permitido: " . number_format($aq->max_score, 2));
                    $hasErrors = true;
                }

                if ($score < 0) {
                    $this->addError("grades.{$aq->answer->id}", "El puntaje no puede ser negativo.");
                    $hasErrors = true;
                }
            }
        }

        if ($hasErrors) {
            $this->dispatchBrowserEvent('scroll-to-error'); // Optional: could implement JS helper
            session()->flash('error', 'Se encontraron errores en los puntajes asignados. Por favor verifique los campos marcados en rojo.');
            return;
        }

        // 2. Execution Logic
        try {
            DB::transaction(function () {
                // First, save the manual grades
                foreach ($this->selectedAttempt->attemptQuestions as $aq) {
                    $ans = $aq->answer;
                    if ($aq->question->type === 'open' && $ans) {
                        $newScore = $this->grades[$ans->id] ?? 0;
                        if ($newScore === '') $newScore = 0;
                        $feedback = $this->feedbacks[$ans->id] ?? null;
                        
                        $ans->update([
                            'score_obtained' => $newScore,
                            'grader_feedback' => $feedback,
                            'graded_by' => Auth::id(),
                            'graded_at' => now(),
                        ]);
                    }
                }
                
                // Reload relation to get updated scores
                $this->selectedAttempt->load('attemptQuestions.answer');

                // Now calculate Final Score using Weighted Logic (Same as ExamTaker)
                $finalScore = 0;
                $failedCategories = false;
                
                $this->selectedAttempt->evaluation->load('categories');
                $categoryConfig = [];
                foreach($this->selectedAttempt->evaluation->categories as $ec) {
                    $categoryConfig[$ec->id] = [
                        'weight_percent' => $ec->pivot->weight_percent,
                        'passing_percentage' => $ec->pivot->passing_percentage ?? 60
                    ];
                }

                $questionsByCategory = $this->selectedAttempt->attemptQuestions->groupBy(function($aq) {
                    return $aq->question->category_id;
                });

                foreach ($questionsByCategory as $catId => $questions) {
                    $totalPointsPossible = $questions->sum('max_score');
                    $totalPointsObtained = $questions->sum(function($aq) {
                        return $aq->answer ? $aq->answer->score_obtained : 0;
                    });
                    
                    $performancePercent = $totalPointsPossible > 0 
                        ? ($totalPointsObtained / $totalPointsPossible) * 100 
                        : 0;
                    
                    // Check strict category passing
                    $catPassing = $categoryConfig[$catId]['passing_percentage'] ?? 60;
                    if ($performancePercent < $catPassing) {
                        $failedCategories = true;
                    }

                    $catWeight = $categoryConfig[$catId]['weight_percent'] ?? 0;
                    $contribution = ($performancePercent / 100) * $catWeight;
                    
                    $finalScore += $contribution;
                }

                // Update attempt
                $evaluation = $this->selectedAttempt->evaluation;
                // Approved if Final Score >= Exam Passing Score AND No Categories Failed
                $isApproved = ($finalScore >= $evaluation->passing_score) && !$failedCategories;

                $this->selectedAttempt->update([
                    'status' => 'graded', 
                    'final_score' => $finalScore,
                    'is_approved' => $isApproved,
                ]);
            });

            $this->selectedAttempt = null;
            $this->selectedAttemptId = null;
            session()->flash('message', 'Evaluación calificada exitosamente.');

        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al guardar: ' . $e->getMessage());
        }
    }
    
    public function cancel()
    {
        $this->selectedAttempt = null;
        $this->selectedAttemptId = null;
    }
}
