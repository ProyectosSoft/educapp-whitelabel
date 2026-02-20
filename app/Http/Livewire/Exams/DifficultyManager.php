<?php

namespace App\Http\Livewire\Exams;
 
use Livewire\Component;
use App\Models\ExamDifficultyLevel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class DifficultyManager extends Component
{
    use AuthorizesRequests;

    public $levels;
    public $name, $points, $selectedLevelId;
    public $isOpen = false;
    public $isConfirmOpen = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'points' => 'required|integer|min:1',
    ];

    public function mount()
    {
        // $this->authorize('viewAny', ExamDifficultyLevel::class); // Optional policy check
    }

    public function render()
    {
        $this->levels = ExamDifficultyLevel::where('user_id', Auth::id())
            ->orWhereNull('user_id') // Optional: Global levels
            ->get();
            
        return view('livewire.exams.difficulty-manager')->layout('layouts.instructor-tailwind');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isOpen = true;
    }

    public function edit($id)
    {
        $level = ExamDifficultyLevel::findOrFail($id);
        $this->selectedLevelId = $id;
        $this->name = $level->name;
        $this->points = $level->points;
        $this->isOpen = true;
    }

    public function store()
    {
        $this->validate();

        ExamDifficultyLevel::updateOrCreate(['id' => $this->selectedLevelId], [
            'name' => $this->name,
            'points' => $this->points,
            'user_id' => Auth::id()
        ]);

        session()->flash('message', $this->selectedLevelId ? 'Nivel actualizado exitosamente.' : 'Nivel creado exitosamente.');
        $this->closeModal();
    }

    public function delete($id)
    {
        $this->selectedLevelId = $id;
        $this->isConfirmOpen = true;
    }

    public function destroy()
    {
        if ($this->selectedLevelId) {
            $level = ExamDifficultyLevel::find($this->selectedLevelId);
            // Check if used by any question
            if ($level->questions()->count() > 0) {
                 session()->flash('error', 'No se puede eliminar este nivel porque está asignado a preguntas existentes.');
            } else {
                $level->delete();
                session()->flash('message', 'Nivel eliminado exitosamente.');
            }
        }
        $this->isConfirmOpen = false;
        $this->selectedLevelId = null;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }
    
    public function closeConfirm()
    {
        $this->isConfirmOpen = false;
        $this->selectedLevelId = null;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->points = '';
        $this->selectedLevelId = null;
    }
}
