<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Evaluation;
use App\Models\StudentAttempt;
use App\Models\StudentAnswer;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\EvaluationException;
use App\Models\Certificate;
use Illuminate\Support\Facades\DB;

class StudentEvaluation extends Component
{
    public $questions;
    public $userAnswers = []; // [question_id => answer_id]
    public $started = false;
    public $finished = false;
    public $score = 0;
    public $passed = false;
    public $attempt; // The current attempt model
    public $attemptsCount = 0;
    public $secondsUntilNextAttempt = 0;
    public $extraAttempts = 0; // Attempts granted via exception

    public function mount(Evaluation $evaluation)
    {
        $this->evaluation = $evaluation;
        
        // Calculate total attempts
        $this->attemptsCount = StudentAttempt::where('user_id', Auth::id())
                            ->where('evaluation_id', $this->evaluation->id)
                            ->count();
        
        // Check for extra attempts exception
        $exception = EvaluationException::where('user_id', Auth::id())
                        ->where('evaluation_id', $this->evaluation->id)
                        ->first();
        if ($exception) {
            $this->extraAttempts = $exception->extra_attempts;
        }

        // Check for latest attempt
        // Check for ANY passed attempt first
        $passedAttempt = StudentAttempt::where('user_id', Auth::id())
                        ->where('evaluation_id', $this->evaluation->id)
                        ->where('passed', true)
                        ->orderByDesc('score') // Get best score if multiple passed? or latest? Let's assume latest passed.
                        ->latest()
                        ->first();

        if ($passedAttempt) {
            $this->attempt = $passedAttempt;
        } else {
            // Fallback to latest attempt (failed)
            $this->attempt = StudentAttempt::where('user_id', Auth::id())
                                ->where('evaluation_id', $this->evaluation->id)
                                ->latest()
                                ->first();
        }

        // Calculate wait time
        // Calculate wait time
        if ($this->attempt && $this->evaluation->wait_time_minutes > 0) {
            // Ensure we are working with flexible timezone handling
            $completedAt = $this->attempt->completed_at instanceof Carbon 
                            ? $this->attempt->completed_at 
                            : Carbon::parse($this->attempt->completed_at);
            
            // FIX: Handle artifacts from timezone switch (UTC stored read as Local)
            // If completion time is in the future, it's a timezone error (UTC read as Local). 
            // We subtract 5 hours to align it approx with reality for typical Latam usage.
            if ($completedAt->isFuture()) {
                $completedAt->subHours(5);
            }

            $nextAttemptTime = $completedAt->copy()->addMinutes($this->evaluation->wait_time_minutes);
            
            if (Carbon::now()->lessThan($nextAttemptTime)) {
                $this->secondsUntilNextAttempt = Carbon::now()->diffInSeconds($nextAttemptTime);
            }
        }

        if ($this->attempt) {
            $this->finished = true;
            $this->passed = $this->attempt->passed;
            $this->score = $this->attempt->score;
        }
    }

    public function start()
    {
        // Check attempts logic here (omitted for brevity, can be added)
        // 1. Get Questions randomized
        $questions = $this->evaluation->questions()->with('answers')->inRandomOrder()->get();
        
        $processedQuestions = collect();

        foreach ($questions as $question) {
            // Logic for picking 1 correct + 3 random incorrect
            $correctAnswer = $question->answers->where('is_correct', true)->first();
            $incorrectAnswers = $question->answers->where('is_correct', false)->shuffle()->take(3);
            
            // Combine and shuffle again
            $options = collect([]);
            if ($correctAnswer) {
                $options->push($correctAnswer);
            }
            if ($incorrectAnswers) {
                $options = $options->concat($incorrectAnswers);
            }
            
            $question->setRelation('answers', $options->shuffle());
            $processedQuestions->push($question);
        }

        $this->questions = $processedQuestions;
        $this->started = true;
        $this->finished = false; // Reset finished state for retries
        
        // Initialize user answers
        foreach ($this->questions as $question) {
            $this->userAnswers[$question->id] = null;
        }
    }

    public function submit($reason = 'completed')
    {
        $correctCount = 0;
        $totalQuestions = $this->questions->count();
        $studentAnswersData = [];

        foreach ($this->questions as $question) {
            // Handle Livewire rehydration (converted to array)
            $questionObj = (object) $question;
            $questionId = $questionObj->id;
            
            $selectedAnswerId = $this->userAnswers[$questionId] ?? null;
            $isCorrect = false;

            if ($selectedAnswerId) {
                // Get answers, ensuring collection
                $answers = $questionObj->answers ?? [];
                if (is_array($answers)) {
                    $answers = collect($answers);
                }
                
                // Find the selected answer
                $selectedAnswer = $answers->where('id', $selectedAnswerId)->first();
                
                if ($selectedAnswer) {
                    // Handle answer as array or object
                    $answerObj = (object) $selectedAnswer;
                    if ($answerObj->is_correct) {
                        $isCorrect = true;
                        $correctCount++;
                    }
                }
            }
            
            // Prepare data for StudentAnswer
            $studentAnswersData[] = [
                'question_id' => $questionId,
                'answer_id' => $selectedAnswerId,
                'is_correct' => $isCorrect,
                'text_answer' => null, // Future use
            ];
        }

        $this->score = ($totalQuestions > 0) ? ($correctCount / $totalQuestions) * 100 : 0;
        $this->passed = $this->score >= $this->evaluation->passing_score;

        // Record Attempt
        $this->attempt = StudentAttempt::create([
            'user_id' => Auth::id(),
            'evaluation_id' => $this->evaluation->id,
            'score' => $this->score,
            'passed' => $this->passed,
            'attempt_number' => StudentAttempt::where('user_id', Auth::id())->where('evaluation_id', $this->evaluation->id)->count() + 1,
            'completed_at' => Carbon::now(),
            'ip_address' => request()->ip(),
            'closing_reason' => $reason
        ]);

        $this->attemptsCount++;

        // Record Detailed Answers
        foreach ($studentAnswersData as $answerData) {
            StudentAnswer::create([
                'student_attempt_id' => $this->attempt->id,
                'question_id' => $answerData['question_id'],
                'answer_id' => $answerData['answer_id'],
                'is_correct' => $answerData['is_correct'],
                'text_answer' => $answerData['text_answer'],
            ]);
        }

        $this->finished = true;
        
        // Recalculate wait time for the view
        if (!$this->passed && $this->evaluation->wait_time_minutes > 0) {
            // Since we just finished, the wait time is exactly the full duration
            $this->secondsUntilNextAttempt = $this->evaluation->wait_time_minutes * 60;
        } else {
             $this->secondsUntilNextAttempt = 0;
        }
        
        // Emit event for confetti or other UI feedback if needed
        if ($this->passed) {
             $this->generateCertificate();
             $this->emit('evaluationPassed');
        }
    }

    public function generateCertificate()
    {
        // Prevent duplicates
        $existing = Certificate::where('user_id', Auth::id())
                        ->where('course_id', $this->evaluation->course_id)
                        ->exists();
        
        if ($existing) {
            return;
        }

        DB::transaction(function () {
             $globalCount = Certificate::max('global_count') + 1;
             $courseCount = Certificate::where('course_id', $this->evaluation->course_id)->max('course_count') + 1;
             $year = date('Y');
             
             $code = "{$globalCount}-{$courseCount}-{$year}";

             Certificate::create([
                 'user_id' => Auth::id(),
                 'course_id' => $this->evaluation->course_id,
                 'student_attempt_id' => $this->attempt->id,
                 'global_count' => $globalCount,
                 'course_count' => $courseCount,
                 'year' => $year,
                 'code' => $code,
                 'issued_at' => now(),
             ]);
        });
    }


    public function render()
    {
        return view('livewire.student-evaluation');
    }
}
