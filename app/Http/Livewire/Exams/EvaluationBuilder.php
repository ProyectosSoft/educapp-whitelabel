<?php

namespace App\Http\Livewire\Exams;

use Livewire\Component;
use App\Models\ExamEvaluation;
use App\Models\ExamCategory;
use Illuminate\Support\Facades\Auth;

class EvaluationBuilder extends Component
{
    public ExamEvaluation $evaluation;

    // -- State for configuring attachment --
    public $showAttachModal = false;
    public $selectedCategoryId = null;
    public $configWeight = 0;
    public $configQuestionsCount = 1;
    public $configPassingPercentage = 60; // NEW: Passing Percentage
    public $availableCategories = [];

    // -- Edit config state --
    public $isEditingConfig = false;
    public $editingPivotId = null; // Implicitly we identify by category_id in pivot

    protected $listeners = ['refreshBuilder' => '$refresh'];

    public function mount(ExamEvaluation $evaluation)
    {
        if ($evaluation->user_id !== Auth::id()) {
            abort(403, 'Acceso no autorizado a esta evaluación.');
        }
        $this->evaluation = $evaluation;
    }

    public function render()
    {
        // Load categories attached to this evaluation
        $this->evaluation->load(['categories']); 
        
        $attachedIds = $this->evaluation->categories->pluck('id')->toArray();
        
        // Load available categories owned by user that are NOT attached
        $this->availableCategories = ExamCategory::where('user_id', Auth::id())
            ->whereNotIn('id', $attachedIds)
            ->withCount('questions')
            ->get();

        return view('livewire.exams.evaluation-builder')->layout('layouts.instructor-tailwind');
    }

    public function openAttachModal()
    {
        $this->isEditingConfig = false;
        $this->selectedCategoryId = null;
        $this->configWeight = 0;
        $this->configQuestionsCount = 1;
        $this->configPassingPercentage = 60; // Default
        $this->showAttachModal = true;
    }

    public function editConfig($categoryId)
    {
        $cat = $this->evaluation->categories()->find($categoryId);
        if(!$cat) return;

        $this->isEditingConfig = true;
        $this->selectedCategoryId = $cat->id;
        $this->configWeight = $cat->pivot->weight_percent;
        $this->configQuestionsCount = $cat->pivot->questions_per_attempt;
        $this->configPassingPercentage = $cat->pivot->passing_percentage ?? 60; // Load existing
        $this->showAttachModal = true;
    }

    public function saveAttachment()
    {
        $this->validate([
            'configWeight' => 'required|numeric|min:0|max:100',
            'configQuestionsCount' => 'required|integer|min:1',
            'configPassingPercentage' => 'required|integer|min:0|max:100',
        ]);

        // Validate total weight cannot exceed 100%
        $currentSum = \Illuminate\Support\Facades\DB::table('exam_evaluation_category')
            ->where('exam_evaluation_id', $this->evaluation->id)
            ->when($this->isEditingConfig, function($q) {
                $q->where('exam_category_id', '!=', $this->selectedCategoryId);
            })
            ->sum('weight_percent');

        $newTotal = $currentSum + $this->configWeight;

        if ($newTotal > 100) {
            $this->addError('configWeight', "El porcentaje total no puede superar el 100%. Actual: {$currentSum}%. Nuevo total sería: {$newTotal}%.");
            return;
        }

        if (!$this->isEditingConfig) {
            $this->validate([
                 'selectedCategoryId' => 'required|exists:exam_categories,id',
            ]);

            $category = ExamCategory::withCount('questions')->find($this->selectedCategoryId);

            if ($category->questions_count === 0) {
                $this->dispatchBrowserEvent('swal', [
                    'title' => 'Categoría Vacía',
                    'text' => 'No se puede asignar por que la categoría no tiene preguntas creadas',
                    'icon' => 'error'
                ]);
                return;
            }
            
            // Attach
            $this->evaluation->categories()->attach($this->selectedCategoryId, [
                'weight_percent' => $this->configWeight,
                'questions_per_attempt' => $this->configQuestionsCount,
                'passing_percentage' => $this->configPassingPercentage,
            ]);
            session()->flash('message', 'Categoría añadida a la evaluación.');
        } else {
            // Update Pivot
            $this->evaluation->categories()->updateExistingPivot($this->selectedCategoryId, [
                'weight_percent' => $this->configWeight,
                'questions_per_attempt' => $this->configQuestionsCount,
                'passing_percentage' => $this->configPassingPercentage,
            ]);
            session()->flash('message', 'Configuración actualizada.');
        }

        $this->showAttachModal = false;
    }

    public function detachCategory($categoryId)
    {
        $this->evaluation->categories()->detach($categoryId);
        session()->flash('message', 'Categoría removida de la evaluación.');
    }
}
