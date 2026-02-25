<?php

namespace App\Http\Livewire\Author;

use App\Models\Curso;
use App\Models\Evaluation;
use App\Models\Exam;
use App\Models\ExamAnswerOption;
use App\Models\ExamCategory;
use App\Models\ExamDifficultyLevel;
use App\Models\ExamEvaluation;
use App\Models\ExamQuestion;
use App\Models\Question;
use App\Models\Seccion_curso;
use App\Models\Answer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class EvaluationManager extends Component
{
    use AuthorizesRequests;

    public $section;
    public $course;
    public $evaluation;
    public $showForm = false;

    public $name, $time_limit, $max_attempts, $passing_score, $wait_time_minutes, $start_mode, $is_visible;
    public $questions = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'time_limit' => 'nullable|integer|min:1',
        'max_attempts' => 'required|integer|min:1',
        'passing_score' => 'required|integer|min:0|max:100',
        'wait_time_minutes' => 'nullable|integer|min:0',
        'start_mode' => 'required|in:automatic,manual',
        'is_visible' => 'boolean',
        'questions.*.statement' => 'required|string',
        'questions.*.points' => 'required|integer|min:1',
        'questions.*.answers.*.text' => 'required|string',
        'questions.*.answers.*.is_correct' => 'boolean',
    ];

    public function mount($section = null, $course = null)
    {
        $this->section = $section;
        $this->course = $course;
        $this->loadEvaluation();
    }

    public function loadEvaluation()
    {
        if (!$this->usingUnifiedEngine()) {
            $this->loadLegacyEvaluation();
            return;
        }

        $query = ExamEvaluation::query()
            ->where('user_id', auth()->id())
            ->with(['internalCategory.questions.options']);

        if ($this->section) {
            $query->where('section_id', $this->section->id)
                ->where('context_type', 'course_section');
        } elseif ($this->course) {
            $query->where('course_id', $this->course->id)
                ->where('context_type', 'course_final');
        }

        $this->evaluation = $query->first();

        if ($this->evaluation) {
            $this->name = $this->evaluation->name;
            $this->time_limit = $this->evaluation->time_limit_minutes;
            $this->max_attempts = $this->evaluation->max_attempts;
            $this->passing_score = $this->evaluation->passing_score;
            $this->wait_time_minutes = $this->evaluation->wait_time_minutes;
            $this->start_mode = $this->evaluation->start_mode ?? 'automatic';
            $this->is_visible = (bool) $this->evaluation->is_visible;

            $this->questions = [];
            $internalCategory = $this->evaluation->internalCategory;

            if ($internalCategory) {
                foreach ($internalCategory->questions as $q) {
                    $answers = $q->options->map(function ($a) {
                        return ['id' => $a->id, 'text' => $a->option_text, 'is_correct' => (bool) $a->is_correct];
                    })->values()->toArray();

                    $this->questions[] = [
                        'id' => $q->id,
                        'statement' => $q->question_text,
                        'points' => $q->difficultyLevel->points ?? 5,
                        'answers' => $answers,
                        'is_expanded' => false,
                    ];
                }
            }
        }
    }

    public function createEvaluation()
    {
        $this->showForm = true;
        $label = $this->section ? 'Evaluación de ' . $this->section->nombre : 'Evaluación Final del Curso';

        $this->name = $label;
        $this->start_mode = 'automatic';
        $this->is_visible = true;
        $this->max_attempts = 1;
        $this->passing_score = 80;
        $this->wait_time_minutes = 0;
        $this->time_limit = null;
        $this->questions = [];
        $this->addQuestion();
    }

    public function editEvaluation()
    {
        $this->showForm = true;
    }

    public function cancel()
    {
        $this->showForm = false;
        $this->reset(['name', 'time_limit', 'max_attempts', 'passing_score', 'questions', 'start_mode', 'is_visible', 'wait_time_minutes']);
        $this->loadEvaluation();
    }

    public function addQuestion()
    {
        $this->questions[] = [
            'id' => null,
            'statement' => '',
            'points' => 5,
            'answers' => [
                ['id' => null, 'text' => '', 'is_correct' => false],
                ['id' => null, 'text' => '', 'is_correct' => false],
            ],
            'is_expanded' => true,
        ];
    }

    public function removeQuestion($index)
    {
        unset($this->questions[$index]);
        $this->questions = array_values($this->questions);
    }

    public function addAnswer($qIndex)
    {
        $this->questions[$qIndex]['answers'][] = ['id' => null, 'text' => '', 'is_correct' => false];
    }

    public function removeAnswer($qIndex, $aIndex)
    {
        unset($this->questions[$qIndex]['answers'][$aIndex]);
        $this->questions[$qIndex]['answers'] = array_values($this->questions[$qIndex]['answers']);
    }

    public function save()
    {
        if (!$this->usingUnifiedEngine()) {
            $this->saveLegacy();
            return;
        }

        $this->validate();

        $exam = $this->ensureExamContainer();
        $course = $this->resolveCourseContext();

        if (!$this->evaluation) {
            $this->evaluation = new ExamEvaluation();
            $this->evaluation->exam_id = $exam->id;
            $this->evaluation->user_id = auth()->id();
            $this->evaluation->context_type = $this->section ? 'course_section' : 'course_final';
            $this->evaluation->course_id = $course?->id;
            $this->evaluation->section_id = $this->section?->id;
            $this->evaluation->is_public = false;
            $this->evaluation->empresa_id = $course?->empresa_id;
            $this->evaluation->departamento_id = $course?->departamento_id;
            $this->evaluation->is_active = true;
        }

        $this->evaluation->name = $this->name;
        $this->evaluation->time_limit_minutes = empty($this->time_limit) ? null : $this->time_limit;
        $this->evaluation->max_attempts = $this->max_attempts;
        $this->evaluation->passing_score = $this->passing_score;
        $this->evaluation->wait_time_minutes = empty($this->wait_time_minutes) ? 0 : $this->wait_time_minutes;
        $this->evaluation->start_mode = $this->start_mode;
        $this->evaluation->is_visible = $this->is_visible;
        $this->evaluation->save();

        $internalCategory = $this->ensureInternalCategory();
        $this->syncEvaluationCategory($internalCategory);
        $this->syncQuestions($internalCategory);

        $this->showForm = false;
        $this->loadEvaluation();

        $this->dispatchBrowserEvent('swal', [
            'title' => '¡Evaluación guardada!',
            'text' => 'La evaluación se ha actualizado correctamente en Gestión Evaluaciones.',
            'icon' => 'success',
        ]);
    }

    public function render()
    {
        return view('livewire.author.evaluation-manager');
    }

    private function resolveCourseContext(): ?Curso
    {
        if ($this->course) {
            return $this->course;
        }

        if ($this->section) {
            return Curso::find($this->section->curso_id);
        }

        return null;
    }

    private function ensureExamContainer(): Exam
    {
        $exam = Exam::first();

        if (!$exam) {
            $exam = Exam::create([
                'name' => 'Evaluaciones de Cursos',
                'description' => 'Contenedor principal para evaluaciones ligadas a cursos.',
                'is_active' => true,
            ]);
        }

        return $exam;
    }

    private function ensureInternalCategory(): ExamCategory
    {
        if ($this->evaluation->internal_category_id) {
            $category = ExamCategory::find($this->evaluation->internal_category_id);
            if ($category) {
                return $category;
            }
        }

        $suffix = $this->section ? 'Sección ' . $this->section->id : 'Final';
        $category = ExamCategory::create([
            'user_id' => auth()->id(),
            'name' => "Curso {$this->evaluation->course_id} - {$suffix}",
        ]);

        $this->evaluation->internal_category_id = $category->id;
        $this->evaluation->save();

        return $category;
    }

    private function syncEvaluationCategory(ExamCategory $category): void
    {
        $questionsPerAttempt = max(1, count($this->questions));
        $pivotData = [
            'weight_percent' => 100,
            'questions_per_attempt' => $questionsPerAttempt,
            'passing_percentage' => $this->passing_score,
        ];

        if ($this->evaluation->categories()->where('exam_category_id', $category->id)->exists()) {
            $this->evaluation->categories()->updateExistingPivot($category->id, $pivotData);
            return;
        }

        $this->evaluation->categories()->attach($category->id, $pivotData);
    }

    private function syncQuestions(ExamCategory $category): void
    {
        $existingQuestionIds = ExamQuestion::where('category_id', $category->id)->pluck('id')->toArray();
        $submittedQuestionIds = array_column(array_filter($this->questions, fn ($q) => !empty($q['id'])), 'id');
        $toDelete = array_diff($existingQuestionIds, $submittedQuestionIds);

        if (!empty($toDelete)) {
            ExamQuestion::whereIn('id', $toDelete)->delete();
        }

        foreach ($this->questions as $qData) {
            $difficultyId = $this->resolveDifficultyLevelId((int) ($qData['points'] ?? 5));

            $question = ExamQuestion::updateOrCreate(
                ['id' => $qData['id']],
                [
                    'category_id' => $category->id,
                    'question_text' => $qData['statement'],
                    'type' => 'closed',
                    'value_percent' => 0,
                    'difficulty_level_id' => $difficultyId,
                    'feedback' => null,
                ]
            );

            $question->options()->delete();
            foreach ($qData['answers'] as $aData) {
                ExamAnswerOption::create([
                    'question_id' => $question->id,
                    'option_text' => $aData['text'],
                    'is_correct' => (bool) $aData['is_correct'],
                ]);
            }
        }
    }

    private function resolveDifficultyLevelId(int $points): ?int
    {
        $level = ExamDifficultyLevel::query()
            ->where(function ($q) {
                $q->where('user_id', auth()->id())
                    ->orWhereNull('user_id');
            })
            ->orderByRaw('ABS(points - ?) ASC', [$points])
            ->first();

        return $level?->id;
    }

    private function usingUnifiedEngine(): bool
    {
        return Schema::hasColumn('exam_evaluations', 'course_id')
            && Schema::hasColumn('exam_evaluations', 'section_id')
            && Schema::hasColumn('exam_evaluations', 'context_type');
    }

    private function loadLegacyEvaluation(): void
    {
        if ($this->section) {
            $this->evaluation = Evaluation::where('section_id', $this->section->id)->with('questions.answers')->first();
        } elseif ($this->course) {
            $this->evaluation = Evaluation::where('course_id', $this->course->id)->with('questions.answers')->first();
        } else {
            $this->evaluation = null;
        }

        if (!$this->evaluation) {
            return;
        }

        $this->name = $this->evaluation->name;
        $this->time_limit = $this->evaluation->time_limit;
        $this->max_attempts = $this->evaluation->max_attempts;
        $this->passing_score = $this->evaluation->passing_score;
        $this->wait_time_minutes = $this->evaluation->wait_time_minutes;
        $this->start_mode = $this->evaluation->start_mode ?? 'automatic';
        $this->is_visible = (bool) $this->evaluation->is_visible;
        $this->questions = [];

        foreach ($this->evaluation->questions as $q) {
            $answers = $q->answers->map(function ($a) {
                return ['id' => $a->id, 'text' => $a->text, 'is_correct' => (bool) $a->is_correct];
            })->values()->toArray();

            $this->questions[] = [
                'id' => $q->id,
                'statement' => $q->statement,
                'points' => $q->points,
                'answers' => $answers,
                'is_expanded' => false,
            ];
        }
    }

    private function saveLegacy(): void
    {
        $this->validate();

        if (!$this->evaluation || !$this->evaluation instanceof Evaluation) {
            $this->evaluation = new Evaluation();
            if ($this->section) {
                $this->evaluation->section_id = $this->section->id;
            } elseif ($this->course) {
                $this->evaluation->course_id = $this->course->id;
            }
        }

        $this->evaluation->name = $this->name;
        $this->evaluation->time_limit = empty($this->time_limit) ? null : $this->time_limit;
        $this->evaluation->max_attempts = $this->max_attempts;
        $this->evaluation->passing_score = $this->passing_score;
        $this->evaluation->wait_time_minutes = empty($this->wait_time_minutes) ? 0 : $this->wait_time_minutes;
        $this->evaluation->start_mode = $this->start_mode;
        $this->evaluation->is_visible = $this->is_visible;
        $this->evaluation->save();

        $existingQIds = $this->evaluation->questions()->pluck('id')->toArray();
        $submittedQIds = array_column(array_filter($this->questions, fn ($q) => !empty($q['id'])), 'id');
        $toDelete = array_diff($existingQIds, $submittedQIds);
        if (!empty($toDelete)) {
            Question::destroy($toDelete);
        }

        foreach ($this->questions as $qData) {
            $question = Question::updateOrCreate(
                ['id' => $qData['id']],
                [
                    'evaluation_id' => $this->evaluation->id,
                    'statement' => $qData['statement'],
                    'points' => $qData['points'] ?? 10,
                ]
            );

            $question->answers()->delete();
            foreach ($qData['answers'] as $aData) {
                Answer::create([
                    'question_id' => $question->id,
                    'text' => $aData['text'],
                    'is_correct' => (bool) $aData['is_correct'],
                ]);
            }
        }

        $this->showForm = false;
        $this->loadLegacyEvaluation();
        $this->dispatchBrowserEvent('swal', [
            'title' => '¡Evaluación guardada!',
            'text' => 'La evaluación se guardó con el motor actual.',
            'icon' => 'success',
        ]);
    }
}
