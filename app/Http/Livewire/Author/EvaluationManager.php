<?php

namespace App\Http\Livewire\Author;

use App\Models\Evaluation;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Seccion_curso;
use App\Models\Curso;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class EvaluationManager extends Component
{
    use AuthorizesRequests;

    public $section;
    public $course;
    public $evaluation;
    public $showForm = false;

    // Form fields
    public $name, $description, $time_limit, $max_attempts, $passing_score, $wait_time_minutes, $start_mode, $is_visible;
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
        if ($this->section) {
            $this->evaluation = Evaluation::where('section_id', $this->section->id)->with('questions.answers')->first();
        } elseif ($this->course) {
             $this->evaluation = Evaluation::where('course_id', $this->course->id)->with('questions.answers')->first();
        }

        if ($this->evaluation) {
            $this->name = $this->evaluation->name;
            $this->description = $this->evaluation->description;
            $this->time_limit = $this->evaluation->time_limit;
            $this->max_attempts = $this->evaluation->max_attempts;
            $this->passing_score = $this->evaluation->passing_score;
            $this->wait_time_minutes = $this->evaluation->wait_time_minutes;
            $this->start_mode = $this->evaluation->start_mode ?? 'automatic';
            $this->is_visible = (bool)$this->evaluation->is_visible;
            
            $this->questions = [];
            // Map existing questions to array
            foreach($this->evaluation->questions as $q) {
                $answers = $q->answers->map(function($a) {
                    return ['text' => $a->text, 'is_correct' => (bool)$a->is_correct];
                })->toArray();
                
                $this->questions[] = [
                    'id' => $q->id,
                    'statement' => $q->statement,
                    'points' => $q->points,
                    'answers' => $answers,
                    'is_expanded' => false 
                ];
            }
        }
    }

    public function createEvaluation()
    {
        $this->showForm = true;
        // Defaults
        $label = $this->section ? 'Evaluación de ' . $this->section->nombre : 'Evaluación Final del Curso';
        $this->name = $label;
        $this->start_mode = 'automatic';
        $this->is_visible = true;
        $this->max_attempts = 1;
        $this->passing_score = 80;
        $this->questions = [];
        $this->addQuestion(); // Start with one question
    }

    public function editEvaluation()
    {
        $this->showForm = true;
    }

    public function cancel()
    {
        $this->showForm = false;
        $this->reset(['name', 'description', 'time_limit', 'max_attempts', 'passing_score', 'questions', 'start_mode', 'is_visible']);
        $this->loadEvaluation();
    }

    public function addQuestion()
    {
        $this->questions[] = [
            'id' => null, // New question
            'statement' => '',
            'points' => 10,
            'answers' => [
                ['text' => '', 'is_correct' => false],
                ['text' => '', 'is_correct' => false],
            ],
            'is_expanded' => true
        ];
    }

    public function removeQuestion($index)
    {
        unset($this->questions[$index]);
        $this->questions = array_values($this->questions);
    }

    public function addAnswer($qIndex)
    {
        $this->questions[$qIndex]['answers'][] = ['text' => '', 'is_correct' => false];
    }

    public function removeAnswer($qIndex, $aIndex)
    {
        unset($this->questions[$qIndex]['answers'][$aIndex]);
        $this->questions[$qIndex]['answers'] = array_values($this->questions[$qIndex]['answers']);
    }

    public function save()
    {
        $this->validate();

        if (!$this->evaluation) {
            $this->evaluation = new Evaluation();
            if ($this->section) {
                $this->evaluation->section_id = $this->section->id;
            } elseif ($this->course) {
                $this->evaluation->course_id = $this->course->id;
            }
        }

        $this->evaluation->name = $this->name;
        $this->evaluation->description = $this->description;
        $this->evaluation->time_limit = empty($this->time_limit) ? null : $this->time_limit;
        $this->evaluation->max_attempts = $this->max_attempts;
        $this->evaluation->passing_score = $this->passing_score;
        $this->evaluation->wait_time_minutes = empty($this->wait_time_minutes) ? 0 : $this->wait_time_minutes;
        $this->evaluation->start_mode = $this->start_mode;
        $this->evaluation->is_visible = $this->is_visible;
        $this->evaluation->save();

        // Sync questions
        // Ideally we should handle deletions properly, but for prototype simpler sync:
        
        // 1. Get current question IDs
        $existingQIds = isset($this->evaluation->id) ? $this->evaluation->questions()->pluck('id')->toArray() : [];
        $submittedQIds = array_column(array_filter($this->questions, fn($q) => $q['id']), 'id');
        
        // 2. Delete removed questions
        $toDelete = array_diff($existingQIds, $submittedQIds);
        Question::destroy($toDelete);

        // 3. Update/Create questions
        foreach ($this->questions as $qData) {
            $question = Question::updateOrCreate(
                ['id' => $qData['id']],
                [
                    'evaluation_id' => $this->evaluation->id,
                    'statement' => $qData['statement'],
                    'points' => $qData['points']
                ]
            );

            // Sync answers
            $question->answers()->delete(); // Brute force simple sync for answers to ensure order/correctness
            foreach ($qData['answers'] as $aData) {
                $question->answers()->create([
                    'text' => $aData['text'],
                    'is_correct' => $aData['is_correct']
                ]);
            }
        }

        $this->showForm = false;
        $this->loadEvaluation();
        $this->dispatchBrowserEvent('swal', [
            'title' => '¡Evaluación guardada!',
            'text' => 'La evaluación se ha actualizado correctamente.',
            'icon' => 'success'
        ]);
    }

    public function render()
    {
        return view('livewire.author.evaluation-manager');
    }
}
