<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exam;
use App\Models\ExamEvaluation;
use App\Models\ExamCategory;
use App\Models\ExamQuestion;
use App\Models\ExamAnswerOption;

class ExamsModuleSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Exam
        $exam = Exam::create([
            'name' => 'Examen de Desarrollo Full Stack',
            'description' => 'Evaluación de competencias técnicas en Backend y Frontend.',
            'is_active' => true,
        ]);

        // 2. Create Evaluation
        $evaluation = ExamEvaluation::create([
            'exam_id' => $exam->id,
            'name' => 'Evaluación Técnica Inicial',
            'max_attempts' => 3,
            'wait_time_minutes' => 60, // 1 hour wait
            'time_limit_minutes' => 45, // 45 min limit
            'passing_score' => 80,
            'is_active' => true,
        ]);

        // 3. Create Categories
        // Backend: 60%, 2 questions to select
        $backendCat = ExamCategory::create([
            'evaluation_id' => $evaluation->id,
            'name' => 'Backend (PHP/Laravel)',
            'weight_percent' => 60,
            'questions_per_attempt' => 2,
        ]);

        // Frontend: 40%, 2 questions to select
        $frontendCat = ExamCategory::create([
            'evaluation_id' => $evaluation->id,
            'name' => 'Frontend (JS/CSS)',
            'weight_percent' => 40,
            'questions_per_attempt' => 2,
        ]);

        // 4. Create Questions for Backend
        // Create 5 questions. Value per question: if category is 60% and we pick 2, each is effectively 30% of total grade? 
        // The prompt says "cada pregunta tendrá asignado un valor porcentual". 
        // "La suma de los valores porcentuales de las preguntas no puede superar el peso porcentual asignado a la categoría"
        // If I have 5 questions in bank, but only 2 are picked, the sum of ALL 5 usually exceeds the weight safely?
        // Or does it mean *in the attempt*? "Al iniciar un intento... seleccionar de forma aleatoria...".
        // If questions have fixed values, e.g. 30%, then picking any 2 = 60%. Perfect.
        
        $backendQuestions = [
            '¿Qué comando crea una migración en Laravel?' => ['php artisan make:migration', 'php artisan create:table', 'php artisan migration:new', 'laravel new migration'],
            '¿Cuál es el ORM por defecto de Laravel?' => ['Eloquent', 'Doctrine', 'Hibernate', 'Propel'],
            '¿Qué método valida datos en un Request?' => ['validate()', 'check()', 'verify()', 'ensure()'],
            '¿Cómo se define una Ruta GET?' => ['Route::get()', 'Router::get()', 'Web::get()', 'Get::route()'],
            '¿Qué archivo configura la base de datos?' => ['.env', 'config.php', 'database.xml', 'settings.json']
        ];

        foreach ($backendQuestions as $qText => $opts) {
            $q = ExamQuestion::create([
                'category_id' => $backendCat->id,
                'question_text' => $qText,
                'type' => 'closed',
                'value_percent' => 30, // 30 * 2 = 60
            ]);

            // Options
            foreach ($opts as $index => $optText) {
                // Add some dummy incorrect options to reach 12 total as per requirement
                // But initially I'll just add the 4 provided. The requirement says "1 correct, 11 incorrect". 
                // I will add the 4 relevant ones and maybe fill with dummies if strict.
                // Requirement: "Cada pregunta cerrada debe contar con 12 opciones... Mostrar únicamente 4".
                // I will generate 12 options.
                
                $isCorrect = $index === 0;
                ExamAnswerOption::create([
                    'question_id' => $q->id,
                    'option_text' => $optText,
                    'is_correct' => $isCorrect,
                ]);
            }
            // Add 8 more dummy incorrect options
            for ($i=0; $i<8; $i++) {
                 ExamAnswerOption::create([
                    'question_id' => $q->id,
                    'option_text' => 'Opción incorrecta autogenerada ' . ($i+1),
                    'is_correct' => false,
                ]);
            }
        }

        // 5. Create Questions for Frontend
        // 40% weight, 2 quesitons -> 20% each.
        $frontendQuestions = [
            '¿Qué propiedad CSS cambia el color de fondo?' => ['background-color', 'color', 'bg-color', 'structure-color'],
            '¿Cuál es un framework de JS?' => ['Vue.js', 'Laravel', 'Django', 'Flask'],
            '¿Cómo se declara una variable constante en JS?' => ['const', 'var', 'let', 'fixed'],
            '¿Qué etiqueta HTML se usa para enlaces?' => ['<a>', '<link>', '<href>', '<url>'],
            '¿Qué significa DOM?' => ['Document Object Model', 'Data Object Mode', 'Document Oriented Model', 'Digital Object Method']
        ];

        foreach ($frontendQuestions as $qText => $opts) {
            $q = ExamQuestion::create([
                'category_id' => $frontendCat->id,
                'question_text' => $qText,
                'type' => 'closed',
                'value_percent' => 20, // 20 * 2 = 40
            ]);

            foreach ($opts as $index => $optText) {
                $isCorrect = $index === 0;
                ExamAnswerOption::create([
                    'question_id' => $q->id,
                    'option_text' => $optText,
                    'is_correct' => $isCorrect,
                ]);
            }
             // Add 8 more dummy incorrect options
            for ($i=0; $i<8; $i++) {
                 ExamAnswerOption::create([
                    'question_id' => $q->id,
                    'option_text' => 'Opción incorrecta extra ' . ($i+1),
                    'is_correct' => false,
                ]);
            }
        }
    }
}
