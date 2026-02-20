<?php

namespace App\Http\Livewire\Exams;

use Livewire\Component;
use App\Models\ExamEvaluation;
use App\Models\ExamUserAttempt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GlobalStats extends Component
{
    // Filters
    public $dateFilter = '7'; // 7, 30, this_month, all

    // Summary Metrics & Trends
    public $totalEvaluations = 0;
    public $totalStudents = 0;
    
    public $approvalRate = 0;
    public $approvalRateTrend = 0; // Difference vs previous period

    public $avgDuration = 0; // In minutes
    public $avgDurationTrend = 0;

    public $globalAvgScore = 0;
    public $globalAvgScoreTrend = 0;

    // Charts Data
    public $chartActivity = []; // [labels, approved, failed]
    public $chartStatusDist = [0, 0, 0, 0]; // [Finished, Progress, Expired, Void]
    public $chartScoreDist = [0, 0, 0, 0, 0]; // Global score distribution
    
    // Top Lists
    public $topEvaluations = []; 
    public $recentActivity = [];
    public $studentsAtRisk = []; // Replaces Top Students for actionable insight
    public $criticalEvaluations = [];

    protected $queryString = ['dateFilter' => ['except' => '7']];

    public function mount()
    {
        $this->calculateGlobalStats();
    }

    public function updatedDateFilter()
    {
        $this->calculateGlobalStats();
    }

    public function calculateGlobalStats()
    {
        // 1. Date Range Logic
        $endDate = Carbon::now();
        $startDate = match($this->dateFilter) {
            '7' => Carbon::now()->subDays(7),
            '30' => Carbon::now()->subDays(30),
            'this_month' => Carbon::now()->startOfMonth(),
            'all' => Carbon::create(2000, 1, 1),
            default => Carbon::now()->subDays(30),
        };

        // Comparison Period (for trends)
        $diffInDays = $startDate->diffInDays($endDate) ?: 1;
        $prevEndDate = (clone $startDate)->subSecond(); // End of prev period is just before start of current
        $prevStartDate = (clone $prevEndDate)->subDays($diffInDays);

        // 2. Base Query Scope
        $evaluations = ExamEvaluation::where('user_id', Auth::id())->get();
        $this->totalEvaluations = $evaluations->count();
        $evalIds = $evaluations->pluck('id');

        if ($evalIds->isEmpty()) {
            return;
        }

        $allAttemptsQuery = ExamUserAttempt::whereIn('evaluation_id', $evalIds);
        
        // Filtered Query
        $filteredAttempts = (clone $allAttemptsQuery)
            ->whereBetween('created_at', [$startDate, $endDate]);

        // Previous Period Query
        $prevAttempts = (clone $allAttemptsQuery)
            ->whereBetween('created_at', [$prevStartDate, $prevEndDate]);

        // 3. Basic Counts
        $this->totalStudents = (clone $filteredAttempts)->distinct('user_id')->count('user_id');

        // 4. KPIs & Trends

        // A) Global Avg Score & Approval Rate
        $currFinished = (clone $filteredAttempts)->whereIn('status', ['finished', 'graded']);
        $this->globalAvgScore = $currFinished->count() > 0 ? round($currFinished->avg('final_score'), 1) : 0;
        
        $prevFinished = (clone $prevAttempts)->whereIn('status', ['finished', 'graded']);
        $prevAvgScore = $prevFinished->count() > 0 ? $prevFinished->avg('final_score') : 0;
        $this->globalAvgScoreTrend = round($this->globalAvgScore - $prevAvgScore, 1);

        // Approval Rate calculation
        // Check if is_approved is reliable (boolean). 
        $currApprovedCount = (clone $currFinished)->where('is_approved', true)->count();
        $this->approvalRate = $currFinished->count() > 0 
            ? round(($currApprovedCount / $currFinished->count()) * 100, 1) 
            : 0;

        $prevApprovedCount = (clone $prevFinished)->where('is_approved', true)->count();
        $prevApprovalRate = $prevFinished->count() > 0
            ? ($prevApprovedCount / $prevFinished->count()) * 100
            : 0;
        $this->approvalRateTrend = round($this->approvalRate - $prevApprovalRate, 1);

        // C) Avg Duration (Minutes)
        $currDurations = (clone $currFinished)->whereNotNull('completed_at')->whereNotNull('started_at')->get();
        $totalMinutes = 0;
        $countDur = 0;
        foreach($currDurations as $att) {
            $start = Carbon::make($att->started_at);
            $end = Carbon::make($att->completed_at);
            if($start && $end) {
                $totalMinutes += $end->diffInMinutes($start);
                $countDur++;
            }
        }
        $this->avgDuration = $countDur > 0 ? round($totalMinutes / $countDur) : 0;

        $prevDurations = (clone $prevFinished)->whereNotNull('completed_at')->whereNotNull('started_at')->get();
        $prevTotalMin = 0;
        $prevCountDur = 0;
        foreach($prevDurations as $att) {
            $start = Carbon::make($att->started_at);
            $end = Carbon::make($att->completed_at);
            if($start && $end) {
                $prevTotalMin += $end->diffInMinutes($start);
                $prevCountDur++;
            }
        }
        $prevAvgDur = $prevCountDur > 0 ? ($prevTotalMin / $prevCountDur) : 0;
        $this->avgDurationTrend = round($this->avgDuration - $prevAvgDur);

        
        // 5. Activity Chart (Approved vs Failed)
        Carbon::setLocale('es');
        
        $dailyApproved = (clone $filteredAttempts)
            ->where('is_approved', true)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->pluck('count', 'date')->toArray();

        $dailyFailed = (clone $filteredAttempts)
            ->whereIn('status', ['finished', 'graded'])
            ->where('is_approved', false)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->pluck('count', 'date')->toArray();

        // Fill period gaps
        // Handle edge case where startDate > endDate (shouldn't happen with correct logic but safe to check)
        if ($startDate->lte($endDate)) {
            $period = new \DatePeriod(
                new \DateTime($startDate->format('Y-m-d')),
                new \DateInterval('P1D'),
                new \DateTime($endDate->copy()->addDay()->format('Y-m-d'))
            );

            $labels = [];
            $dataApproved = [];
            $dataFailed = [];

            foreach ($period as $date) {
                $d = $date->format('Y-m-d');
                $labels[] = ucfirst(Carbon::createFromFormat('Y-m-d', $d)->translatedFormat('d M'));
                $dataApproved[] = $dailyApproved[$d] ?? 0;
                $dataFailed[] = $dailyFailed[$d] ?? 0;
            }

            $this->chartActivity = [
                'labels' => $labels,
                'approved' => $dataApproved,
                'failed' => $dataFailed,
            ];
        } else {
             $this->chartActivity = ['labels' => [], 'approved' => [], 'failed' => []];
        }


        // 6. Students At Risk (Low Avg Score < 60%)
        $userIdsInPeriod = (clone $filteredAttempts)->distinct('user_id')->pluck('user_id');
        
        $this->studentsAtRisk = ExamUserAttempt::whereIn('user_id', $userIdsInPeriod)
            ->whereIn('status', ['finished', 'graded'])
            ->with('user')
            ->select('user_id', DB::raw('AVG(final_score) as avg_score'), DB::raw('COUNT(id) as total_attempts'))
            ->groupBy('user_id')
            ->having('avg_score', '<', 60)
            ->orderBy('avg_score', 'asc')
            ->take(5)
            ->get();


        // 7. Status Distribution
        $statusCounts = (clone $filteredAttempts)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $finishedTotal = ($statusCounts['finished'] ?? 0) + ($statusCounts['graded'] ?? 0);
        $progress = $statusCounts['in_progress'] ?? 0;
        $expired = $statusCounts['expired'] ?? 0;
        $void = $statusCounts['void'] ?? 0;
        $this->chartStatusDist = [$finishedTotal, $progress, $expired, $void];


        // 8. Score Distribution
        $this->chartScoreDist = [0, 0, 0, 0, 0];
        $scores = (clone $currFinished)->pluck('final_score');
        foreach ($scores as $score) {
            if ($score <= 20) $this->chartScoreDist[0]++;
            elseif ($score <= 40) $this->chartScoreDist[1]++;
            elseif ($score <= 60) $this->chartScoreDist[2]++;
            elseif ($score <= 80) $this->chartScoreDist[3]++;
            else $this->chartScoreDist[4]++;
        }


        // 9. Tables
        $this->topEvaluations = ExamEvaluation::withCount(['userAttempts' => function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->orderByDesc('user_attempts_count')
            ->take(5)
            ->get();

        $this->criticalEvaluations = ExamEvaluation::whereIn('id', $evalIds)
            ->withAvg(['userAttempts' => function($query) use ($startDate, $endDate) {
                $query->whereIn('status', ['finished', 'graded'])
                      ->whereBetween('created_at', [$startDate, $endDate]);
            }], 'final_score')
            ->havingNotNull('user_attempts_avg_final_score')
            ->orderBy('user_attempts_avg_final_score', 'asc')
            ->take(5)
            ->get();
            
        // 10. Recent Activity
        $this->recentActivity = (clone $filteredAttempts)
            ->with(['evaluation', 'user'])
            ->orderByDesc('updated_at')
            ->take(6)
            ->get();
    }

    public function render()
    {
        return view('livewire.exams.global-stats')->layout('layouts.instructor-tailwind');
    }
}
