<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Examen: entidad principal
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // 2. Evaluación: configuración evaluativa
        Schema::create('exam_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
            $table->string('name');
            $table->integer('max_attempts')->default(1);
            $table->integer('wait_time_minutes')->default(0); // Tiempo de espera mínimo entre intentos
            $table->integer('time_limit_minutes')->nullable(); // Duración máxima del intento
            $table->integer('passing_score')->default(80); // Regla de aprobación %
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // 3. Categorías: agrupaciones de preguntas
        Schema::create('exam_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluation_id')->constrained('exam_evaluations')->onDelete('cascade');
            $table->string('name');
            $table->decimal('weight_percent', 5, 2); // Peso porcentual de la categoría
            $table->integer('questions_per_attempt'); // Cantidad de preguntas a incluir en cada intento
            $table->timestamps();
        });

        // 4. Preguntas
        Schema::create('exam_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('exam_categories')->onDelete('cascade');
            $table->text('question_text');
            $table->enum('type', ['closed', 'open'])->default('closed');
            $table->decimal('value_percent', 5, 2); // Valor porcentual de la pregunta dentro de la categoría
            $table->text('feedback')->nullable(); // Retroalimentación general (opcional)
            $table->timestamps();
        });

        // 5. Opciones de respuesta (para preguntas cerradas)
        Schema::create('exam_answer_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('exam_questions')->onDelete('cascade');
            $table->string('option_text');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });

        // 6. Intentos de evaluación
        Schema::create('exam_user_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('evaluation_id')->constrained('exam_evaluations')->onDelete('cascade');
            // 'in_progress', 'finished', 'pending_review', 'graded', 'void', 'expired'
            $table->string('status')->default('in_progress');
            $table->decimal('final_score', 5, 2)->nullable();
            $table->boolean('is_approved')->nullable(); // Calculado al final según regla de aprobación
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->integer('attempt_number');
            $table->timestamps();
        });

        // 7. Preguntas del intento (Snapshot de qué preguntas le salieron)
        Schema::create('exam_attempt_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->constrained('exam_user_attempts')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('exam_questions')->onDelete('cascade');
            $table->integer('order_in_attempt'); // Para mantener el orden visual
            $table->timestamps();
        });

        // 8. Opciones mostradas en el intento (Snapshot de las 4 opciones mostradas para preguntas cerradas)
        Schema::create('exam_attempt_question_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_question_id')->constrained('exam_attempt_questions')->onDelete('cascade');
            $table->foreignId('option_id')->constrained('exam_answer_options')->onDelete('cascade');
            $table->integer('order_in_question'); // Para mantener orden visual de las opciones
            $table->timestamps();
        });

        // 9. Respuestas del usuario
        Schema::create('exam_attempt_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_question_id')->constrained('exam_attempt_questions')->onDelete('cascade');
            // Para cerradas:
            $table->foreignId('selected_option_id')->nullable()->constrained('exam_answer_options'); 
            // Para abiertas:
            $table->text('text_answer')->nullable();
            
            $table->decimal('score_obtained', 5, 2)->nullable(); // Puntos obtenidos en esta pregunta
            $table->text('grader_feedback')->nullable(); // Observaciones del evaluador
            $table->foreignId('graded_by')->nullable()->constrained('users'); // Quién calificó
            $table->timestamp('graded_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_attempt_answers');
        Schema::dropIfExists('exam_attempt_question_options');
        Schema::dropIfExists('exam_attempt_questions');
        Schema::dropIfExists('exam_user_attempts');
        Schema::dropIfExists('exam_answer_options');
        Schema::dropIfExists('exam_questions');
        Schema::dropIfExists('exam_categories');
        Schema::dropIfExists('exam_evaluations');
        Schema::dropIfExists('exams');
    }
};
