<?php

namespace App\Http\Livewire\Exams;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\ExamCategory;
use App\Models\ExamQuestion;
use App\Models\ExamAnswerOption;
use App\Models\ExamDifficultyLevel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Exams\QuestionsImport;
use App\Exports\Exams\QuestionsTemplateExport;
use Illuminate\Support\Facades\Log;

class QuestionBank extends Component
{
    use WithPagination, WithFileUploads;
    
    public $search = '';
    public $viewDeleted = false; // Toggle for deleted questions

    // -- Category State --
    public $showCategoryModal = false;
    public $catId = null;
    public $catName;
    
    // -- Question State --
    public $showQuestionModal = false;
    public $qId = null;
    public $qCategoryId; 
    public $qText;
    public $qType = 'closed';
    // public $qValue; // Removed from UI, default to 0 in DB
    public $qDifficultyLevelId; // NEW: Difficulty Level
    public $qFeedback;
    public $qOptions = []; 
    
    // -- Difficulty Levels for Select --
    public $difficultyLevels = [];

    // -- Import State --
    public $importFile;
    public $showImportModal = false;

    protected $listeners = ['refreshBank' => '$refresh'];

    public function importQuestions()
    {

        
        $this->validate([
            'importFile' => 'required|mimes:xlsx,xls|max:10240', // Max 10MB
        ]);

        $fullPath = null; // Initialize $fullPath outside try for finally block access

        try {
            // Guardar temporalmente en disco para evitar problemas de stream con Livewire
            // Usar disco LOCAL explícitamente y obtener ruta absoluta correcta
            $path = $this->importFile->store('temp_imports', 'local');
            $fullPath = Storage::disk('local')->path($path);

            if (!file_exists($fullPath)) {
                Log::warning("Archivo importado NO encontrado en ruta: " . $fullPath);
                throw new \Exception("Error guardando el archivo temporal (Ruta perdida).");
            }

            // Validar estructura primero (sin importar aún)
            // Pasamos la ruta del archivo físico, no el objeto Livewire
            $collections = Excel::toCollection(new QuestionsImport(Auth::id()), $fullPath);
            
            $firstSheet = $collections->first();
            
            if ($firstSheet->count() > 0) {
                $firstRow = $firstSheet->first();
                $detectedKeys = implode(', ', $firstRow->keys()->toArray());
                
                // Procesar importación real pasando la ruta del archivo físico
                Excel::import(new QuestionsImport(Auth::id()), $fullPath);
                
                $this->reset(['importFile', 'showImportModal']);
                $this->emit('refreshBank');
                
                // Notificación con SweetAlert
                $this->emit('swal:success', [
                    'title' => '¡Importación Exitosa!',
                    'text' => "Se han importado las preguntas correctamente."
                ]);
            } else {
                throw new \Exception("El archivo Excel parece estar vacío.");
            }
        } catch (\Exception $e) {
            Log::error("Import Error: " . $e->getMessage());
            
            $errorMsg = '';
            if(str_contains($e->getMessage(), 'The import file failed to upload')) {
                 $errorMsg = 'El archivo no se pudo cargar. Puede que exceda el límite de tamaño del servidor.';
            } else {
                 $errorMsg = 'Error al importar: ' . $e->getMessage();
            }
            
            $this->addError('importFile', $errorMsg);
            
            $this->emit('swal:error', [
                'title' => 'Error de Importación',
                'text' => $errorMsg
            ]);
        } finally {
            // Limpieza del archivo temporal
            if (isset($fullPath) && file_exists($fullPath)) {
                @unlink($fullPath);
            }
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new QuestionsTemplateExport, 'plantilla_preguntas.xlsx');
    }

    public function mount()
    {
        // Fetch difficulty levels (User-specific or global)
        $this->difficultyLevels = ExamDifficultyLevel::where('user_id', Auth::id())
            ->orWhereNull('user_id')
            ->orderBy('id') // Order by something logical? Or defaults first
            ->get();
    }

    public function render()
    {
        // Fetch categories with dynamic relation for questions
        // Fetch categories with dynamic relation for questions
        $categoriesQuery = ExamCategory::where('user_id', Auth::id())
            ->where('name', 'like', '%'.$this->search.'%');
            
        if ($this->viewDeleted) {
            $categoriesQuery->withTrashed()
                ->where(function($query) {
                    $query->whereNotNull('deleted_at')
                          ->orWhereHas('questions', function($q){
                              $q->onlyTrashed();
                          });
                });
        }

        $categories = $categoriesQuery
            ->with(['questions' => function($q){
                if($this->viewDeleted){
                    $q->onlyTrashed();
                } 
                $q->with('difficultyLevel'); // Eager load difficulty
            }])
             // For count, we might want total active unless looking at deleted? 
             // Ideally we want to count what we see. 
             // withCount defaults to regular query. 
             // Let's rely on loading the relation in the view loop for the actual items
            ->withCount('questions') 
            ->latest()
            ->paginate(10);
            
        // Refresh difficulty levels on each render just in case? Or is mount sufficient?
        // Mount is safer for performance, assuming they don't change while on this page.

        return view('livewire.exams.question-bank', compact('categories'))
             ->layout('layouts.instructor-tailwind');
    }

    // --- Category Management ---

    public function createCategory()
    {
        $this->resetCategoryForm();
        $this->showCategoryModal = true;
    }

    public function editCategory($id)
    {
        $cat = ExamCategory::where('user_id', Auth::id())->find($id);
        if(!$cat) return;

        $this->catId = $cat->id;
        $this->catName = $cat->name;
        $this->showCategoryModal = true;
    }

    public function saveCategory()
    {
        $this->validate([
            'catName' => 'required|string|max:255',
        ]);

        if ($this->catId) {
            $cat = ExamCategory::where('user_id', Auth::id())->find($this->catId);
            $cat->update(['name' => $this->catName]);
            session()->flash('message', 'Categoría actualizada.');
        } else {
            ExamCategory::create([
                'user_id' => Auth::id(),
                'name' => $this->catName,
                // pivot fields like weight are handled in builder, not here
            ]);
            session()->flash('message', 'Categoría creada en el banco.');
        }

        $this->showCategoryModal = false;
        $this->resetCategoryForm();
    }

    public function deleteCategory($id)
    {
        $cat = ExamCategory::where('user_id', Auth::id())->find($id);
        if($cat) {
            $cat->delete();
            session()->flash('message', 'Categoría eliminada.');
        }
    }

    public function restoreCategory($id)
    {
        $cat = ExamCategory::withTrashed()->where('user_id', Auth::id())->find($id);
        if($cat) {
            $cat->restore();
            session()->flash('message', 'Categoría restaurada.');
        }
    }

    private function resetCategoryForm()
    {
        $this->catId = null;
        $this->catName = '';
        $this->resetValidation();
    }

    // --- Question Management (Same logic as Builder but scoped to Category) ---

    public function createQuestion($categoryId)
    {
        $this->resetQuestionForm();
        $this->qCategoryId = $categoryId;
        
        // Default to first difficulty level if exists, or null
        $this->qDifficultyLevelId = $this->difficultyLevels->first()->id ?? null;
        
        $this->addOption();
        $this->addOption();
        $this->addOption();
        $this->addOption();
        $this->showQuestionModal = true;
    }

    public function editQuestion($id)
    {
        // Ensure question belongs to a category owned by user
        $q = ExamQuestion::whereHas('category', function($q){
            $q->where('user_id', Auth::id());
        })->with(['options' => function($query){
            // When editing, we might want to see deleted options too if we want to restore them?
            // Actually, for editing active questions, we usually only see active options.
            // But if user requested "falta para las respuestas", they likely want to see and restore deleted OPTIONS within the edit modal.
            $query->withTrashed(); 
        }])->find($id);

        if(!$q) return;

        $this->qId = $q->id;
        $this->qCategoryId = $q->category_id;
        $this->qText = $q->question_text;
        $this->qType = $q->type;
        // $this->qValue = $q->value_percent;
        $this->qDifficultyLevelId = $q->difficulty_level_id;
        $this->qFeedback = $q->feedback;
        
        $this->qOptions = [];
        foreach($q->options as $opt) {
            $this->qOptions[] = [
                'id' => $opt->id,
                'text' => $opt->option_text,
                'is_correct' => (bool)$opt->is_correct,
                'deleted_at' => $opt->deleted_at, // Pass deletion status to view
            ];
        }

        $this->showQuestionModal = true;
    }

    public function saveQuestion()
    {
        $this->validate([
            'qText' => 'required|string',
            'qType' => 'required|in:closed,open',
            'qDifficultyLevelId' => 'required|exists:exam_difficulty_levels,id', // Validation for difficulty
            'qOptions.*.text' => 'required_if:qType,closed|string',
        ]);

        if ($this->qType === 'closed') {
             $hasCorrect = false;
             foreach ($this->qOptions as $opt) {
                 if (!empty($opt['is_correct'])) $hasCorrect = true;
             }
             if (!$hasCorrect) {
                 $this->addError('qOptions', 'Debe marcar al menos una opción como correcta.');
                 return;
             }
        }

        DB::transaction(function () {
            $data = [
                'category_id' => $this->qCategoryId,
                'question_text' => $this->qText,
                'type' => $this->qType,
                'value_percent' => 0, // Default to 0 as per user request
                'difficulty_level_id' => $this->qDifficultyLevelId, // Save difficulty
                'feedback' => $this->qFeedback,
            ];

            if ($this->qId) {
                $q = ExamQuestion::find($this->qId);
                $q->update($data);
            } else {
                $q = ExamQuestion::create($data);
                $this->qId = $q->id;
            }

            if ($this->qType === 'closed') {
                $existingDescriptionIds = $q->options()->pluck('id')->toArray();
                $keptIds = [];

                foreach ($this->qOptions as $optData) {
                    if (isset($optData['id']) && $optData['id']) {
                        // Find including trashed to allow restore
                        $opt = ExamAnswerOption::withTrashed()->find($optData['id']);
                        if ($opt) {
                            $opt->update([
                                'option_text' => $optData['text'],
                                'is_correct' => $optData['is_correct'] ?? false,
                                'deleted_at' => null // Restore if it was deleted
                            ]);
                            $keptIds[] = $optData['id'];
                        }
                    } else {
                        $newOpt = ExamAnswerOption::create([
                            'question_id' => $q->id,
                            'option_text' => $optData['text'],
                            'is_correct' => $optData['is_correct'] ?? false,
                        ]);
                        $keptIds[] = $newOpt->id;
                    }
                }
                // Important: Delete options not in keptIds.
                // Since we use softDeletes, this will mask them, preserving history.
                ExamAnswerOption::where('question_id', $q->id)->whereNotIn('id', $keptIds)->delete();
            } else {
                // If switching to Open, delete options.
                $q->options()->delete();
            }
        });

        $this->showQuestionModal = false;
        $this->resetQuestionForm();
        session()->flash('message', 'Pregunta guardada.');
    }

    public function deleteQuestion($id)
    {
         $q = ExamQuestion::whereHas('category', function($q){
            $q->where('user_id', Auth::id());
        })->find($id);
        
        if($q) {
            $q->delete(); // Soft delete
            session()->flash('message', 'Pregunta movida a la papelera.');
        }
    }

    public function restoreQuestion($id)
    {
        $q = ExamQuestion::withTrashed()->whereHas('category', function($query){
            $query->where('user_id', Auth::id());
        })->find($id);

        if($q){
            $q->restore();
            session()->flash('message', 'Pregunta restaurada correctamente.');
        }
    }

    public function restoreOption($index)
    {
        if (isset($this->qOptions[$index])) {
            $this->qOptions[$index]['deleted_at'] = null;
        }
    }

    public function addOption()
    {
        $this->qOptions[] = ['id' => null, 'text' => '', 'is_correct' => false];
    }

    public function removeOption($index)
    {
        unset($this->qOptions[$index]);
        $this->qOptions = array_values($this->qOptions);
    }

    private function resetQuestionForm()
    {
        $this->qId = null;
        $this->qCategoryId = null;
        $this->qText = '';
        $this->qType = 'closed';
        // $this->qValue = 0;
        $this->qFeedback = '';
        $this->qOptions = [];
        $this->resetValidation();
    }
}
