<?php

namespace App\Http\Livewire\Exams;

use Livewire\Component;
use App\Models\Exam;
use App\Models\ExamEvaluation;
use App\Models\ExamCategory;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\Empresa;
use App\Models\Departamento;
use Livewire\WithPagination;

class ExamManager extends Component
{
    use WithPagination;

    public $search = '';
    public $confirmingEvaluationDeletion = false;
    public $managingEvaluationId; 
    public $viewingEvaluation; // For the modal/edit view

    // Form fields for Evaluation
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
    
    public $examId; // To attach new evaluation to an exam

    public $isCreating = false;
    public $isEditing = false;
    public $selectedEvaluationId;

    public $categories = [];
    public $subcategories = [];
    
    public $empresas = [];
    public $departamentosFilter = [];

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
    ];

    public function mount()
    {
        // For simplicity, we can assume we are managing evaluations for the first exam or all exams
        // Or we list all evaluations grouped by Exam.
        $this->categories = Categoria::all();
        $this->empresas = Empresa::all();
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

    public function render()
    {
        $evaluations = ExamEvaluation::with('exam')
            ->where('user_id', auth()->id()) // SEGURO: Filtrar por usuario
            ->where('name', 'like', '%'.$this->search.'%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.exams.exam-manager', [
            'evaluations' => $evaluations
        ])->layout('layouts.instructor-tailwind');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isCreating = true;
        
        $exam = Exam::first();
        if (!$exam) {
            $exam = Exam::create([
                'name' => 'Examen General',
                'description' => 'Examen Principal',
                'is_active' => true
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
        if($this->evalCategoryId) {
            $this->subcategories = Subcategoria::where('categoria_id', $this->evalCategoryId)->get();
        } else {
            $this->subcategories = [];
        }
        $this->evalSubcategoryId = $evaluation->subcategoria_id;

        $this->evalEmpresaId = $evaluation->empresa_id;
        if ($this->evalEmpresaId) {
            $this->departamentosFilter = Departamento::where('empresa_id', $this->evalEmpresaId)->get();
        } else {
            $this->departamentosFilter = [];
        }
        $this->evalDepartamentoId = $evaluation->departamento_id;

        $this->examId = $evaluation->exam_id;
        
        $this->isEditing = true;
    }

    public function store()
    {
        $this->validate();

        ExamEvaluation::create([
            'exam_id' => $this->examId,
            'name' => $this->evalName,
            'max_attempts' => $this->evalNumRequests,
            'wait_time_minutes' => $this->evalWaitTime,
            'time_limit_minutes' => $this->evalTimeLimit ?: null,
            'passing_score' => $this->evalPassingScore,
            'is_active' => $this->evalIsActive,
            'is_public' => $this->evalIsPublic,
            'empresa_id' => $this->evalIsPublic ? null : $this->evalEmpresaId, // If public, no company filter
            'departamento_id' => $this->evalIsPublic ? null : $this->evalDepartamentoId,
            'categoria_id' => $this->evalCategoryId,
            'subcategoria_id' => $this->evalSubcategoryId,
            'user_id' => auth()->id(),
        ]);

        session()->flash('message', 'Evaluación creada correctamente.');
        $this->closeModal();
    }

    public function update()
    {
        $this->validate();

        $evaluation = ExamEvaluation::where('user_id', auth()->id())->find($this->selectedEvaluationId);

        if (!$evaluation) {
            abort(403, 'No autorizado');
        }
        $evaluation->update([
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
        ]);

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
        // Keep categories loaded, just reset selection
        $this->evalCategoryId = null;
        $this->evalSubcategoryId = null;
        $this->evalEmpresaId = null;
        $this->evalDepartamentoId = null;
        $this->subcategories = [];
        $this->departamentosFilter = [];
        $this->selectedEvaluationId = null;
    }
}
