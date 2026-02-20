<?php

namespace App\Http\Livewire\Exams;

use Livewire\Component;
use App\Models\ExamEvaluation;
use App\Models\ExamUserAttempt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Exports\ExamStatisticsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;


class ExamStatistics extends Component
{
    public ExamEvaluation $evaluation;

    // Stats
    public $totalStudents = 0;
    public $avgScore = 0;
    public $maxScore = 0;
    public $minScore = 0;
    public $avgTimeMinutes = 0;
    public $avgAttemptsPerStudent = 0;
    public $completionRate = 0;
    
    // Top Tables
    public $topQuestions = []; // Best performed
    public $worstQuestions = []; // Worst performed
    // Charts Data
    public $chartDistData = [0, 0, 0, 0, 0]; // 0-20, 21-40, 41-60, 61-80, 81-100

    public $chartApprovalData = [0, 0]; // [Approved, Failed]
    public $chartStatusData = [0, 0, 0, 0]; // [Finished/Graded, In Progress, Expired, Void]
    public $voidReasons = []; // [Reason => count]

    public function mount(ExamEvaluation $evaluation)
    {
        if ($evaluation->user_id !== Auth::id() && !Auth::user()->hasRole('Administrador')) {
             // Permitir admin puede ser util, si no solo Auth::id()
             if ($evaluation->user_id !== Auth::id()) {
                 abort(403, 'Acceso no autorizado a esta evaluación.');
             }
        }
        $this->evaluation = $evaluation;
        $this->calculateStats();
    }

    public function calculateStats()
    {
        // 1. General Stats (Based on FINISHED attempts only for accuracy)
        $attempts = $this->evaluation->userAttempts()
            ->whereIn('status', ['finished', 'graded'])
            ->get();
            
        $uniqueUsers = $attempts->pluck('user_id')->unique()->count();
        $this->totalStudents = $uniqueUsers;

        if ($attempts->count() > 0) {
            $this->avgScore = $attempts->avg('final_score');
            $this->maxScore = $attempts->max('final_score');
            $this->minScore = $attempts->min('final_score');
            
            // Calc avg time
            $totalSeconds = 0;
            $countTime = 0;
            foreach($attempts as $att) {
                if($att->started_at && $att->completed_at) {
                    $totalSeconds += $att->started_at->diffInSeconds($att->completed_at);
                    $countTime++;
                }
                
                // Distribution calc
                $score = $att->final_score;
                if ($score <= 20) $this->chartDistData[0]++;
                elseif ($score <= 40) $this->chartDistData[1]++;
                elseif ($score <= 60) $this->chartDistData[2]++;
                elseif ($score <= 80) $this->chartDistData[3]++;
                else $this->chartDistData[4]++;
                
                // Approval calc
                if ($score >= $this->evaluation->passing_score) {
                    $this->chartApprovalData[0]++;
                } else {
                    $this->chartApprovalData[1]++;
                }
            }
            $this->avgTimeMinutes = $countTime > 0 ? round(($totalSeconds / $countTime) / 60, 1) : 0;
            
            // Avg Attempts (Total attempts including unfinished ones vs unique users)
            $allAttemptsCount = $this->evaluation->userAttempts()->count();
            $this->avgAttemptsPerStudent = $uniqueUsers > 0 ? round($allAttemptsCount / $uniqueUsers, 1) : 0;
            
            // Completion Rate
            $finishedCount = $attempts->count(); // Already filtered by finished/graded
            $this->completionRate = $allAttemptsCount > 0 ? round(($finishedCount / $allAttemptsCount) * 100, 1) : 0;
            
            // Status Distribution (Use all attempts)
            $allAttempts = $this->evaluation->userAttempts()->get(); // Get fresh collection of all attempts
            
            $finished = 0;
            $inProgress = 0;
            $expired = 0;
            $void = 0;
            
            $reasons = [];

            foreach($allAttempts as $att) {
                if (in_array($att->status, ['finished', 'graded'])) {
                    $finished++;
                } elseif ($att->status === 'in_progress') {
                    $inProgress++;
                } elseif ($att->status === 'expired') {
                    $expired++;
                } elseif ($att->status === 'void') {
                    $void++;
                    $r = $att->invalidation_reason ?? 'Sin razón especificada';
                    if (!isset($reasons[$r])) $reasons[$r] = 0;
                    $reasons[$r]++;
                }
            }
            $this->chartStatusData = [$finished, $inProgress, $expired, $void];
            $this->voidReasons = $reasons;
        } else {
             // Handle case with 0 finished attempts but potentially others (e.g. all in progress)
             $allAttempts = $this->evaluation->userAttempts()->get();
             if($allAttempts->count() > 0) {
                 $finished = 0; $inProgress = 0; $expired = 0; $void = 0;
                 $reasons = [];

                 foreach($allAttempts as $att) {
                    if (in_array($att->status, ['finished', 'graded'])) {
                        $finished++;
                    } elseif ($att->status === 'in_progress') {
                        $inProgress++;
                    } elseif ($att->status === 'expired') {
                        $expired++;
                    } elseif ($att->status === 'void') {
                        $void++;
                        $r = $att->invalidation_reason ?? 'Sin razón especificada';
                        if (!isset($reasons[$r])) $reasons[$r] = 0;
                        $reasons[$r]++;
                    }
                }
                $this->chartStatusData = [$finished, $inProgress, $expired, $void];
                $this->voidReasons = $reasons;
                
                // Also calc attempts per student even if none finished
                 $uniqueUsers = $allAttempts->pluck('user_id')->unique()->count();
                 $this->avgAttemptsPerStudent = $uniqueUsers > 0 ? round($allAttempts->count() / $uniqueUsers, 1) : 0;
             }
        }

        // 2. Question Analysis
        // We need to look at ExamAttemptQuestion + ExamAttemptAnswer
        // Join Tables: exam_attempt_answers -> exam_attempt_questions -> exam_user_attempts (filter by eval_id)
        
        $questionStats = DB::table('exam_attempt_answers as a')
            ->join('exam_attempt_questions as q', 'a.attempt_question_id', '=', 'q.id')
            ->join('exam_user_attempts as ua', 'q.attempt_id', '=', 'ua.id')
            ->join('exam_questions as base_q', 'q.question_id', '=', 'base_q.id')
            ->where('ua.evaluation_id', $this->evaluation->id)
            ->whereIn('ua.status', ['finished', 'graded']) // Only completed exams
            ->select(
                'base_q.id', 
                DB::raw('MAX(base_q.question_text) as question_text'), 
                // Calculate percentage accuracy: SUM(score_obtained) / SUM(max_score) * 100
                // We use SUM/SUM instead of AVG(ratio) to weight properly by attempts
                DB::raw('SUM(a.score_obtained) as total_score'),
                DB::raw('SUM(q.max_score) as total_max_score'),
                DB::raw('COUNT(a.id) as times_answered')
            )
            ->groupBy('base_q.id')
            ->get()
            ->map(function($item) {
                // Calculate accuracy % manually to avoid division by zero in SQL and safer logic
                $maxPayload = $item->total_max_score > 0 ? $item->total_max_score : 1; // Prevent div/0
                $item->accuracy = ($item->total_score / $maxPayload) * 100;
                return $item;
            });

        $this->topQuestions = $questionStats->sortByDesc('accuracy')->values()->take(10);
        $this->worstQuestions = $questionStats->sortBy('accuracy')->values()->take(10);

        // 3. Top 10 Students
        // Get max score per user, then order.
        $this->topStudents = ExamUserAttempt::where('evaluation_id', $this->evaluation->id)
            ->whereIn('status', ['finished', 'graded'])
            ->with('user')
            ->select('user_id', DB::raw('MAX(final_score) as max_score'), DB::raw('COUNT(id) as attempts_count'))
            ->groupBy('user_id')
            ->orderByDesc('max_score')
            ->take(10)
            ->get();
    }

    public function render()
    {
        // Ensure questions are objects for the view (Fix Livewire hydration array issue)
        $this->topQuestions = collect($this->topQuestions)->map(function($q) {
            return (object) $q;
        });
        $this->worstQuestions = collect($this->worstQuestions)->map(function($q) {
            return (object) $q;
        });

        return view('livewire.exams.exam-statistics')->layout('layouts.instructor-tailwind');
    }

    public function exportExcel()
    {
        // Gather data
        // Fetch ALL questions stats for export
        $allQuestions = DB::table('exam_questions as eq')
            ->join('exam_categories as ec', 'eq.category_id', '=', 'ec.id')
            ->join('exam_evaluation_category as eec', 'ec.id', '=', 'eec.exam_category_id')
            ->leftJoin('exam_attempt_questions as eaq', 'eq.id', '=', 'eaq.question_id')
            ->leftJoin('exam_user_attempts as eua', function($join) {
                $join->on('eaq.attempt_id', '=', 'eua.id')
                     ->whereIn('eua.status', ['finished', 'graded']);
            })
            ->leftJoin('exam_attempt_answers as eaa', 'eaq.id', '=', 'eaa.attempt_question_id')
            ->where('eec.exam_evaluation_id', $this->evaluation->id)
            ->select(
                'eq.id',
                'eq.question_text',
                DB::raw('COUNT(CASE WHEN eua.id IS NOT NULL THEN eaq.id END) as times_answered'),
                DB::raw('COALESCE(SUM(CASE WHEN eua.id IS NOT NULL THEN eaa.score_obtained ELSE 0 END), 0) as total_score'),
                DB::raw('COALESCE(SUM(CASE WHEN eua.id IS NOT NULL THEN eaq.max_score ELSE 0 END), 0) as total_max_score')
            )
            ->groupBy('eq.id', 'eq.question_text')
            ->get()
            ->map(function ($item) {
                // Calculate accuracy carefully avoiding division by zero
                $item->accuracy = ($item->total_max_score > 0) 
                    ? ($item->total_score / $item->total_max_score) * 100 
                    : 0;
                return $item;
            })
            ->sortByDesc('accuracy')
            ->values();
        
        // Re-fetch students to ensure relationships are loaded properly
        $students = ExamUserAttempt::where('evaluation_id', $this->evaluation->id)
            ->whereIn('status', ['finished', 'graded'])
            ->with('user')
            ->select('user_id', DB::raw('MAX(final_score) as max_score'), DB::raw('COUNT(id) as attempts_count'))
            ->groupBy('user_id')
            ->orderByDesc('max_score')
            ->take(10)
            ->get();
        
        $data = [
            'totalStudents' => $this->totalStudents,
            'avgScore' => number_format($this->avgScore, 1),
            'avgTimeMinutes' => $this->avgTimeMinutes,
            'avgAttemptsPerStudent' => $this->avgAttemptsPerStudent,
            'completionRate' => $this->completionRate,
            'questions' => $allQuestions,
            'students' => $students
        ];

        return Excel::download(new ExamStatisticsExport($data), 'estadisticas_' . Str::slug($this->evaluation->name) . '.xlsx');
    }

    public function exportPdf()
    {
        // Fetch ALL questions stats for export
        $allQuestions = DB::table('exam_questions as eq')
            ->join('exam_categories as ec', 'eq.category_id', '=', 'ec.id')
            ->join('exam_evaluation_category as eec', 'ec.id', '=', 'eec.exam_category_id')
            ->leftJoin('exam_attempt_questions as eaq', 'eq.id', '=', 'eaq.question_id')
            ->leftJoin('exam_user_attempts as eua', function($join) {
                $join->on('eaq.attempt_id', '=', 'eua.id')
                     ->whereIn('eua.status', ['finished', 'graded']);
            })
            ->leftJoin('exam_attempt_answers as eaa', 'eaq.id', '=', 'eaa.attempt_question_id')
            ->where('eec.exam_evaluation_id', $this->evaluation->id)
            ->select(
                'eq.id',
                'eq.question_text',
                DB::raw('COUNT(CASE WHEN eua.id IS NOT NULL THEN eaq.id END) as times_answered'),
                DB::raw('COALESCE(SUM(CASE WHEN eua.id IS NOT NULL THEN eaa.score_obtained ELSE 0 END), 0) as total_score'),
                DB::raw('COALESCE(SUM(CASE WHEN eua.id IS NOT NULL THEN eaq.max_score ELSE 0 END), 0) as total_max_score')
            )
            ->groupBy('eq.id', 'eq.question_text')
            ->get()
            ->map(function ($item) {
                // Calculate accuracy carefully avoiding division by zero
                $item->accuracy = ($item->total_max_score > 0) 
                    ? ($item->total_score / $item->total_max_score) * 100 
                    : 0;
                return $item;
            })
            ->sortByDesc('accuracy')
            ->values();

        // Re-fetch students to ensure relationships are loaded properly
        $students = ExamUserAttempt::where('evaluation_id', $this->evaluation->id)
            ->whereIn('status', ['finished', 'graded'])
            ->with('user')
            ->select('user_id', DB::raw('MAX(final_score) as max_score'), DB::raw('COUNT(id) as attempts_count'))
            ->groupBy('user_id')
            ->orderByDesc('max_score')
            ->take(10)
            ->get();

        $data = [
            'evaluationName' => $this->evaluation->name,
            'totalStudents' => $this->totalStudents,
            'avgScore' => $this->avgScore,
            'avgTimeMinutes' => $this->avgTimeMinutes,
            'avgAttemptsPerStudent' => $this->avgAttemptsPerStudent,
            'completionRate' => $this->completionRate,
            'questions' => $allQuestions,
            'students' => $students
        ];

        $pdf = Pdf::loadView('exports.exam-statistics-pdf', $data);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'estadisticas_' . Str::slug($this->evaluation->name) . '.pdf');
    }
}
