<?php

namespace App\Http\Livewire\Exams;

use Livewire\Component;
use App\Models\ExamEvaluation;
use App\Models\ExamUserAttempt;
use App\Models\ExamAttemptQuestion;
use App\Models\ExamAttemptAnswer;
use App\Models\ExamAttemptQuestionOption;
use App\Models\ExamAnswerOption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExamTaker extends Component
{
    public ExamEvaluation $evaluation;
    public $currentAttempt;
    public $questions = [];
    public $answers = []; // [attempt_question_id => val]
    public $timeLeft = 0;

    public function mount(ExamEvaluation $evaluation)
    {
        // Security: Prevent taking inactive exams unless instructor
        if (!$evaluation->is_active && $evaluation->user_id !== Auth::id()) {
            abort(403, 'Esta evaluación no está activa.');
        }

        $this->evaluation = $evaluation;
        $this->loadCurrentAttempt();

        if (!$this->currentAttempt && request()->has('auto_start')) {
            $this->startAttempt();
        }
    }

    public function loadCurrentAttempt()
    {
        $this->currentAttempt = ExamUserAttempt::where('user_id', Auth::id())
            ->where('evaluation_id', $this->evaluation->id)
            ->where('status', 'in_progress')
            ->latest()
            ->first();

        if ($this->currentAttempt) {
            // Check expiry
            if ($this->evaluation->time_limit_minutes) {
                $endTime = $this->currentAttempt->started_at->addMinutes($this->evaluation->time_limit_minutes);
                if (now()->greaterThan($endTime)) {
                    $this->expireAttempt();
                    return;
                }
                $this->timeLeft = now()->diffInSeconds($endTime, false);
            }
            
            // Load structure
            $this->questions = $this->currentAttempt->attemptQuestions()
                ->with(['question', 'shownOptions.option'])
                ->get();
        }
    }

    public function expireAttempt()
    {
        $this->currentAttempt->update(['status' => 'expired', 'completed_at' => now()]);
        $this->currentAttempt = null;
        $this->questions = [];
        session()->flash('error', 'El tiempo del intento ha expirado.');
    }

    public function startAttempt()
    {
        // Validation
        // 1. Max attempts
        $attemptsCount = ExamUserAttempt::where('user_id', Auth::id())
            ->where('evaluation_id', $this->evaluation->id)
            ->count();
            
        if ($attemptsCount >= $this->evaluation->max_attempts) {
            session()->flash('error', 'Has superado el número máximo de intentos.');
            return;
        }

        // 2. Wait time
        $lastAttempt = ExamUserAttempt::where('user_id', Auth::id())
            ->where('evaluation_id', $this->evaluation->id)
            ->whereIn('status', ['finished', 'pending_review', 'graded', 'void', 'expired'])
            ->latest('completed_at')
            ->first();
        
        if ($lastAttempt && $lastAttempt->completed_at) {
            $diff = $lastAttempt->completed_at->diffInMinutes(now());
            if ($diff < $this->evaluation->wait_time_minutes) {
                 session()->flash('error', 'Debes esperar ' . ($this->evaluation->wait_time_minutes - $diff) . ' minutos antes del próximo intento.');
                 return;
            }
        }

        DB::transaction(function () use ($attemptsCount) {
             $attempt = ExamUserAttempt::create([
                'user_id' => Auth::id(),
                'evaluation_id' => $this->evaluation->id,
                'status' => 'in_progress',
                'started_at' => now(),
                'attempt_number' => $attemptsCount + 1,
                'ip_address' => request()->ip(),
            ]);

            $cats = $this->evaluation->categories;
            $order = 1;

            foreach ($cats as $cat) {
                // Select random questions using Pivot config
                $count = $cat->pivot->questions_per_attempt;
                
                // Fetch random questions with difficulty info
                $randomQuestions = $cat->questions()
                    ->with('difficultyLevel')
                    ->inRandomOrder()
                    ->take($count)
                    ->get();

                foreach ($randomQuestions as $q) {
                    // Use difficulty points or default to 5 (Medium) if not set
                    $points = $q->difficultyLevel ? $q->difficultyLevel->points : 5;

                    $aq = ExamAttemptQuestion::create([
                        'attempt_id' => $attempt->id,
                        'question_id' => $q->id,
                        'order_in_attempt' => $order++,
                        'max_score' => $points, // Stores POINTS (1, 5, 10), not percent
                    ]);

                    if ($q->type === 'closed') {
                        // Select options: 1 correct, 11 incorrect (show 4: 1 correct, 3 incorrect)
                        $correct = $q->options()->where('is_correct', true)->inRandomOrder()->first();
                        $incorrects = $q->options()->where('is_correct', false)->inRandomOrder()->take(3)->get();
                        
                        $optionsToShow = collect([$correct])->merge($incorrects)->shuffle();
                        
                        $optOrder = 1;
                        foreach ($optionsToShow as $opt) {
                            if ($opt) { // safety check
                                ExamAttemptQuestionOption::create([
                                    'attempt_question_id' => $aq->id,
                                    'option_id' => $opt->id,
                                    'order_in_question' => $optOrder++,
                                ]);
                            }
                        }
                    }
                }
            }
            $this->currentAttempt = $attempt;
        });

        $this->loadCurrentAttempt();
    }

    public function submit()
    {
        if (!$this->currentAttempt) return;

        DB::transaction(function () {
            $hasOpenQuestions = false;
            
            // Re-fetch to be safe, including category for grouping
            $attemptQuestions = $this->currentAttempt->attemptQuestions()->with('question.category')->get();
            
            // Load evaluation categories to get weights from Pivot
            $this->evaluation->load('categories');
            
            // Map category_id => pivot data
            $categoryConfig = [];
            foreach($this->evaluation->categories as $ec) {
                $categoryConfig[$ec->id] = [
                    'weight_percent' => $ec->pivot->weight_percent,
                    'passing_percentage' => $ec->pivot->passing_percentage ?? 60
                ];
            }

            // 1. Process Answers and Assign Raw Points
            foreach ($attemptQuestions as $aq) {
                $val = $this->answers[$aq->id] ?? null;
                $q = $aq->question;

                $pointsObtained = 0;
                $selectedOptionId = null;
                $textAnswer = null;

                if ($q->type === 'closed') {
                    $selectedOptionId = $val;
                    if ($selectedOptionId) {
                        $opt = ExamAnswerOption::find($selectedOptionId); 
                        if ($opt && $opt->is_correct) {
                            $pointsObtained = $aq->max_score; // Full points for correct
                        }
                    }
                } else {
                    $textAnswer = $val;
                    $hasOpenQuestions = true;
                    $pointsObtained = 0; // Pending grading
                }

                ExamAttemptAnswer::create([
                    'attempt_question_id' => $aq->id,
                    'selected_option_id' => $selectedOptionId,
                    'text_answer' => $textAnswer,
                    'score_obtained' => ($q->type === 'closed') ? $pointsObtained : null,
                ]);
            }

            // 2. Calculate Final Score using Weighted Performance Logic
            
            // Reload answers to ensure we have the stored `score_obtained`
            $this->currentAttempt->load('attemptQuestions.answer');
            
            $finalScore = 0;
            $failedCategories = false;
            
            if (!$hasOpenQuestions) {
                // Group by Category to calculate performance
                $questionsByCategory = $this->currentAttempt->attemptQuestions->groupBy(function($aq) {
                    return $aq->question->category_id;
                });

                foreach ($questionsByCategory as $catId => $questions) {
                    $totalPointsPossible = $questions->sum('max_score');
                    $totalPointsObtained = $questions->sum(function($aq) {
                        return $aq->answer ? $aq->answer->score_obtained : 0;
                    });
                    
                    // Avoid division by zero
                    $performancePercent = $totalPointsPossible > 0 
                        ? ($totalPointsObtained / $totalPointsPossible) * 100 
                        : 0;
                    
                    // Check if category is approved
                    $catPassing = $categoryConfig[$catId]['passing_percentage'] ?? 60;
                    if ($performancePercent < $catPassing) {
                        $failedCategories = true;
                    }

                    // Add Weighted Contribution to Final Score
                    $catWeight = $categoryConfig[$catId]['weight_percent'] ?? 0;
                    $contribution = ($performancePercent / 100) * $catWeight;
                    
                    $finalScore += $contribution;
                }
            }

            $status = $hasOpenQuestions ? 'pending_review' : 'finished';
            
            // Update attempt
            if ($status === 'finished') {
                // Approved if Total Score >= Exam Passing Score AND No Categories Failed
                $isApproved = ($finalScore >= $this->evaluation->passing_score) && !$failedCategories;
                
                $this->currentAttempt->update([
                    'status' => 'finished',
                    'final_score' => $finalScore,
                    'is_approved' => $isApproved,
                    'completed_at' => now(),
                ]);
            } else {
                 $this->currentAttempt->update([
                    'status' => 'pending_review',
                    'completed_at' => now(),
                    // Final score is not calculated yet for pending review
                ]);
            }
        });
        
        // Refresh to show status
        session()->flash('message', 'Evaluación enviada correctamente.');
        return redirect()->route('exams.index');
    }

    public function render()
    {
        return view('livewire.exams.exam-taker')->layout('layouts.app'); 
    }

    public function forceFail($reason = 'Actividad sospechosa detectada')
    {
        if ($this->currentAttempt && $this->currentAttempt->status === 'in_progress') {
            $this->currentAttempt->update([
                'status' => 'void', // Or 'finished' with 0 score depending on business logic. 'void' implies invalidation.
                'completed_at' => now(),
                'final_score' => 0,
                'is_approved' => false,
                'invalidation_reason' => $reason
            ]);
        }
        
        session()->flash('error', 'Evaluación anulada: ' . $reason);
        return redirect()->route('exams.index');
    }
}
