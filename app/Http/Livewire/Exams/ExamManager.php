<?php

namespace App\Http\Livewire\Exams;

use App\Models\Categoria;
use App\Models\Curso;
use App\Models\Departamento;
use App\Models\Empresa;
use App\Models\Exam;
use App\Models\ExamEvaluation;
use App\Models\Seccion_curso;
use App\Models\Subcategoria;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Livewire\WithPagination;

class ExamManager extends Component
{
    use WithPagination;

    public $search = '';

    public $evalNumRequests = 1;
    public $evalWaitTime = 0;
    public $evalTimeLimit = 0;
    public $evalPassingScore = 80;
    public $evalName = '';
    public $evalIsActive = true;
    public $evalIsPublic = true;
    public $evalEmpresaId;
    public $evalDepartamentoId;

    public $evalCategoryId;
    public $evalSubcategoryId;

    public $evalTargetType = 'certificate'; // certificate | course
    public $evalCourseId;
    public $evalScope = 'final'; // final | section
    public $evalSectionId;
    public $evalStartMode = 'automatic'; // automatic | manual (solo curso)

    public $examId;

    public $isCreating = false;
    public $isEditing = false;
    public $selectedEvaluationId;

    public $categories = [];
    public $subcategories = [];

    public $empresas = [];
    public $departamentosFilter = [];

    public $courses = [];
    public $sectionsFilter = [];

    public $filterCourseId;
    public $supportsCourseContext = false;

    protected $rules = [
        'evalName' => 'required|string|max:255',
        'evalNumRequests' => 'required|integer|min:1',
        'evalWaitTime' => 'required|integer|min:0',
        'evalTimeLimit' => 'nullable|integer|min:0',
        'evalPassingScore' => 'required|integer|min:0|max:100',
        'evalCategoryId' => 'required|exists:categorias,id',
        'evalSubcategoryId' => 'nullable|exists:subcategorias,id',
        'evalIsPublic' => 'boolean',
        'evalEmpresaId' => 'nullable|exists:empresas,id',
        'evalDepartamentoId' => 'nullable|exists:departamentos,id',
        'evalTargetType' => 'required|in:certificate,course',
        'evalCourseId' => 'nullable|exists:cursos,id',
        'evalScope' => 'nullable|in:final,section',
        'evalSectionId' => 'nullable|exists:seccion_cursos,id',
        'evalStartMode' => 'nullable|in:automatic,manual',
    ];

    public function mount()
    {
        $this->supportsCourseContext = $this->hasCourseContextColumns();

        $this->categories = Categoria::all();
        $this->empresas = Empresa::all();
        $this->courses = Curso::where('user_id', auth()->id())->orderBy('nombre')->get();

        $this->filterCourseId = request()->integer('course_id') ?: null;

        if (request()->boolean('create')) {
            $this->openCreateModal();

            if ($this->supportsCourseContext && request('target') === 'course') {
                $this->evalTargetType = 'course';
                $this->evalCourseId = $this->filterCourseId;
                $this->evalScope = request('scope') === 'section' ? 'section' : 'final';
                $this->updatedEvalCourseId($this->evalCourseId);
                $this->evalSectionId = request()->integer('section_id') ?: null;
            }
        }
    }

    public function updatedEvalCategoryId($value)
    {
        $this->subcategories = Subcategoria::where('categoria_id', $value)->get();
        $this->evalSubcategoryId = null;
    }

    public function updatedEvalEmpresaId($value)
    {
        $this->departamentosFilter = Departamento::where('empresa_id', $value)->get();
        $this->evalDepartamentoId = null;
    }

    public function updatedEvalTargetType($value)
    {
        if ($value !== 'course') {
            $this->evalCourseId = null;
            $this->evalScope = 'final';
            $this->evalSectionId = null;
            $this->sectionsFilter = [];
        }
    }

    public function updatedEvalCourseId($value)
    {
        if (!$value) {
            $this->sectionsFilter = [];
            $this->evalSectionId = null;
            return;
        }

        $this->sectionsFilter = Seccion_curso::where('curso_id', $value)->orderBy('nombre')->get();

        if ($this->evalScope !== 'section') {
            $this->evalSectionId = null;
        }
    }

    public function updatedEvalScope($value)
    {
        if ($value !== 'section') {
            $this->evalSectionId = null;
        }
    }

    public function render()
    {
        $query = ExamEvaluation::with(['exam', 'course', 'section'])
            ->where('user_id', auth()->id())
            ->where('name', 'like', '%' . $this->search . '%');

        if ($this->supportsCourseContext && $this->filterCourseId) {
            $query->where('course_id', $this->filterCourseId);
        }

        $evaluations = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.exams.exam-manager', [
            'evaluations' => $evaluations,
        ])->layout('layouts.instructor-tailwind');
    }

    public function openCreateModal()
    {
        $this->resetInputFields();
        $this->isCreating = true;

        $exam = Exam::first();
        if (!$exam) {
            $exam = Exam::create([
                'name' => 'Examen General',
                'description' => 'Examen Principal',
                'is_active' => true,
            ]);
        }
        $this->examId = $exam->id;
    }

    public function edit($id)
    {
        $evaluation = ExamEvaluation::where('user_id', auth()->id())->find($id);

        if (!$evaluation) {
            abort(403, 'No autorizado');
        }

        $this->selectedEvaluationId = $id;
        $this->evalName = $evaluation->name;
        $this->evalNumRequests = $evaluation->max_attempts;
        $this->evalWaitTime = $evaluation->wait_time_minutes;
        $this->evalTimeLimit = $evaluation->time_limit_minutes;
        $this->evalPassingScore = $evaluation->passing_score;
        $this->evalIsActive = $evaluation->is_active;
        $this->evalIsPublic = $evaluation->is_public;

        $this->evalCategoryId = $evaluation->categoria_id;
        $this->subcategories = $this->evalCategoryId
            ? Subcategoria::where('categoria_id', $this->evalCategoryId)->get()
            : [];
        $this->evalSubcategoryId = $evaluation->subcategoria_id;

        $this->evalEmpresaId = $evaluation->empresa_id;
        $this->departamentosFilter = $this->evalEmpresaId
            ? Departamento::where('empresa_id', $this->evalEmpresaId)->get()
            : [];
        $this->evalDepartamentoId = $evaluation->departamento_id;

        if ($this->supportsCourseContext) {
            $this->evalTargetType = in_array($evaluation->context_type, ['course_final', 'course_section']) ? 'course' : 'certificate';
            $this->evalCourseId = $evaluation->course_id;
            $this->updatedEvalCourseId($this->evalCourseId);
            $this->evalScope = $evaluation->context_type === 'course_section' ? 'section' : 'final';
            $this->evalSectionId = $evaluation->section_id;
            $this->evalStartMode = $evaluation->start_mode ?? 'automatic';
        }

        $this->examId = $evaluation->exam_id;
        $this->isEditing = true;
    }

    public function store()
    {
        $this->validate();

        if (!$this->validateContextSelection()) {
            return;
        }

        ExamEvaluation::create($this->buildPayload());

        session()->flash('message', 'Evaluación creada correctamente.');
        $this->closeModal();
    }

    public function update()
    {
        $this->validate();

        if (!$this->validateContextSelection()) {
            return;
        }

        $evaluation = ExamEvaluation::where('user_id', auth()->id())->find($this->selectedEvaluationId);

        if (!$evaluation) {
            abort(403, 'No autorizado');
        }

        $evaluation->update($this->buildPayload($evaluation));

        session()->flash('message', 'Evaluación actualizada correctamente.');
        $this->closeModal();
    }

    public function delete($id)
    {
        $evaluation = ExamEvaluation::where('user_id', auth()->id())->find($id);

        if ($evaluation) {
            $evaluation->delete();
            session()->flash('message', 'Evaluación eliminada.');
        }
    }

    public function closeModal()
    {
        $this->isCreating = false;
        $this->isEditing = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->evalName = '';
        $this->evalNumRequests = 1;
        $this->evalWaitTime = 0;
        $this->evalTimeLimit = 0;
        $this->evalPassingScore = 80;
        $this->evalIsActive = true;
        $this->evalIsPublic = true;
        $this->evalCategoryId = null;
        $this->evalSubcategoryId = null;
        $this->evalEmpresaId = null;
        $this->evalDepartamentoId = null;
        $this->subcategories = [];
        $this->departamentosFilter = [];
        $this->selectedEvaluationId = null;

        $this->evalTargetType = 'certificate';
        $this->evalCourseId = $this->filterCourseId;
        $this->evalScope = 'final';
        $this->evalSectionId = null;
        $this->evalStartMode = 'automatic';
        $this->sectionsFilter = [];

        if ($this->evalCourseId) {
            $this->updatedEvalCourseId($this->evalCourseId);
        }
    }

    private function buildPayload(?ExamEvaluation $existing = null): array
    {
        $payload = [
            'exam_id' => $this->examId,
            'name' => $this->evalName,
            'max_attempts' => $this->evalNumRequests,
            'wait_time_minutes' => $this->evalWaitTime,
            'time_limit_minutes' => $this->evalTimeLimit ?: null,
            'passing_score' => $this->evalPassingScore,
            'is_active' => $this->evalIsActive,
            'is_public' => $this->evalIsPublic,
            'empresa_id' => $this->evalIsPublic ? null : $this->evalEmpresaId,
            'departamento_id' => $this->evalIsPublic ? null : $this->evalDepartamentoId,
            'categoria_id' => $this->evalCategoryId,
            'subcategoria_id' => $this->evalSubcategoryId,
            'user_id' => auth()->id(),
        ];

        if ($this->supportsCourseContext) {
            $payload['context_type'] = 'standalone';
            $payload['course_id'] = null;
            $payload['section_id'] = null;
            $payload['start_mode'] = 'manual';
            $payload['is_visible'] = true;

            if ($this->evalTargetType === 'course') {
                $course = Curso::find($this->evalCourseId);
                $payload['context_type'] = $this->evalScope === 'section' ? 'course_section' : 'course_final';
                $payload['course_id'] = $this->evalCourseId;
                $payload['section_id'] = $this->evalScope === 'section' ? $this->evalSectionId : null;
                $payload['start_mode'] = $this->evalStartMode ?: 'automatic';
                $payload['is_public'] = false;
                $payload['empresa_id'] = $course?->empresa_id;
                $payload['departamento_id'] = $course?->departamento_id;
            }
        } elseif ($existing) {
            $payload['context_type'] = $existing->context_type ?: 'standalone';
        } else {
            $payload['context_type'] = 'standalone';
        }

        return $payload;
    }

    private function validateContextSelection(): bool
    {
        if ($this->evalTargetType === 'course') {
            if (!$this->supportsCourseContext) {
                $this->addError('evalTargetType', 'Debes ejecutar migraciones para habilitar evaluaciones ligadas a cursos.');
                return false;
            }

            if (!$this->evalCourseId) {
                $this->addError('evalCourseId', 'Debes seleccionar un curso.');
                return false;
            }

            if ($this->evalScope === 'section' && !$this->evalSectionId) {
                $this->addError('evalSectionId', 'Debes seleccionar una sección.');
                return false;
            }
        }

        return true;
    }

    private function hasCourseContextColumns(): bool
    {
        return Schema::hasColumn('exam_evaluations', 'context_type')
            && Schema::hasColumn('exam_evaluations', 'course_id')
            && Schema::hasColumn('exam_evaluations', 'section_id');
    }
}
