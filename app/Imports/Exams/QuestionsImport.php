<?php

namespace App\Imports\Exams;

use App\Models\ExamAnswerOption;
use App\Models\ExamCategory;
use App\Models\ExamDifficultyLevel;
use App\Models\ExamQuestion;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class QuestionsImport implements ToCollection, WithHeadingRow
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        Log::info("Iniciando importación de preguntas. Filas detectadas: " . $rows->count());

        foreach ($rows as $index => $row) {
            // Debug de claves para la primera fila para detectar problemas de cabeceras
            if ($index === 0) {
                Log::info("Cabeceras del Excel detectadas: " . implode(', ', $row->keys()->toArray()));
            }

            // 0. Validaciones básicas: Si no hay los campos mínimos, saltar
            if (!isset($row['categoria']) || !isset($row['enunciado'])) {
                Log::warning("Fila #{$index} saltada. Faltan claves 'categoria' o 'enunciado'. Datos: " . json_encode($row->toArray()));
                continue;
            }

            try {
                DB::transaction(function () use ($row) {
                    // 1. Resolver Categoría (Buscar o crear SOLO para este usuario)
                    $category = ExamCategory::firstOrCreate(
                        [
                            'user_id' => $this->userId,
                            'name' => trim($row['categoria'])
                        ]
                    );

                    // 2. Resolver Dificultad (Opcional, busca por nombre)
                    $difficultyId = null;
                    if (!empty($row['dificultad'])) {
                        $difficultyName = trim($row['dificultad']);
                        // Buscar nivel público (user_id=null) o privado del usuario
                        // Fix: Fetch all candidate levels and match loosely (ignoring case/whitespace) in PHP
                        // to handle "Alta " vs "Alta" discrepancies in DB vs Excel.
                        $allLevels = ExamDifficultyLevel::where(function($q) {
                                $q->whereNull('user_id')->orWhere('user_id', $this->userId);
                            })->get();
                        
                        $difficulty = $allLevels->first(function($level) use ($difficultyName) {
                            return strcasecmp(trim($level->name), $difficultyName) === 0;
                        });
                        
                        // Si existe, asignamos ID. Si no, queda null (predeterminado)
                        if ($difficulty) {
                            $difficultyId = $difficulty->id;
                        }
                    }

                    // 3. Normalizar Tipo
                    $tipoInput = isset($row['tipo']) ? strtolower(trim($row['tipo'])) : 'cerrada';
                    
                    $tipoDb = ($tipoInput == 'abierta' || $tipoInput == 'open') ? 'open' : 'closed';

                    // 4. Crear Pregunta
                    $question = ExamQuestion::create([
                        'category_id' => $category->id,
                        'difficulty_level_id' => $difficultyId,
                        'question_text' => trim($row['enunciado']),
                        'type' => $tipoDb,
                        'value_percent' => 0,
                        'feedback' => isset($row['retroalimentacion']) ? trim($row['retroalimentacion']) : null,
                    ]);

                    // 5. Procesar Opciones (Solo si es cerrada)
                    if ($tipoDb === 'closed') {
                        $this->processOptions($question, $row);
                    }
                });

            } catch (\Exception $e) {
                Log::error("Error importando fila #{$index}: " . $e->getMessage());
                // Continuamos con la siguiente fila, no detenemos todo el proceso
            }
        }
    }

    private function processOptions($question, $row)
    {
        // Detectar dinámicamente todas las columnas que empiecen por 'opcion_'
        foreach ($row as $key => $value) {
            // Buscamos keys como 'opcion_1', 'opcion_2', etc. y que tengan valor no vacío
            if (Str::startsWith($key, 'opcion_') && !empty($value)) {
                
                // Extraer el índice. Ej: 'opcion_1' -> '1'
                $index = Str::replace('opcion_', '', $key);
                
                // Buscar la columna 'es_correcta_X' correspondiente
                $isCorrectKey = "es_correcta_{$index}";
                
                // Determinar si es correcta ('SI', 'YES', '1', etc.)
                $isCorrectRaw = isset($row[$isCorrectKey]) ? strtoupper(trim($row[$isCorrectKey])) : 'NO';
                $isCorrect = in_array($isCorrectRaw, ['SI', 'YES', '1', 'TRUE']);

                ExamAnswerOption::create([
                    'question_id' => $question->id,
                    'option_text' => trim($value),
                    'is_correct' => $isCorrect
                ]);
            }
        }
    }
}
