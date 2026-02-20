<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Curso;

class ReseñaCursos extends Component
{
    public $course_id, $comment;

    public $rating = 5;

    public function mount(Curso $course)
    {
        $this->course_id = $course->id;
    }
    public function render()
    {
        $course = Curso::find($this->course_id);
        return view('livewire.reseña-cursos', compact('course'));
    }

    public function store()
    {
        // Validar que los campos no estén vacíos
        $this->validate([
            'comment' => 'required',    // Asegura que el campo comment no esté vacío
            'rating' => 'required'      // Asegura que el campo rating no esté vacío
        ]);

        // Encuentra el curso
        $course = Curso::find($this->course_id);

        // Crea la reseña del curso
        $course->Resena_curso()->create([
            'comentarios' => $this->comment,
            'calificacion' => $this->rating,
            'user_id' => auth()->user()->id
        ]);

        // Limpiar los campos después de almacenar la reseña
        $this->reset(['comment', 'rating']);
    }
}
