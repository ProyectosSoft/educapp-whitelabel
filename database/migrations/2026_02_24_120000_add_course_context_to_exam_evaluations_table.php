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
        Schema::table('exam_evaluations', function (Blueprint $table) {
            if (!Schema::hasColumn('exam_evaluations', 'course_id')) {
                $table->foreignId('course_id')->nullable()->after('exam_id')->constrained('cursos')->nullOnDelete();
            }

            if (!Schema::hasColumn('exam_evaluations', 'section_id')) {
                $table->foreignId('section_id')->nullable()->after('course_id')->constrained('seccion_cursos')->nullOnDelete();
            }

            if (!Schema::hasColumn('exam_evaluations', 'context_type')) {
                $table->string('context_type', 30)->default('standalone')->after('section_id');
            }

            if (!Schema::hasColumn('exam_evaluations', 'start_mode')) {
                $table->enum('start_mode', ['automatic', 'manual'])->default('automatic')->after('context_type');
            }

            if (!Schema::hasColumn('exam_evaluations', 'is_visible')) {
                $table->boolean('is_visible')->default(true)->after('start_mode');
            }

            if (!Schema::hasColumn('exam_evaluations', 'internal_category_id')) {
                $table->foreignId('internal_category_id')->nullable()->after('subcategoria_id')->constrained('exam_categories')->nullOnDelete();
            }

            if (!Schema::hasColumn('exam_evaluations', 'context_type') || !Schema::hasColumn('exam_evaluations', 'course_id')) {
                return;
            }

            $table->index(['context_type', 'course_id'], 'exam_eval_context_course_idx');
            $table->index(['section_id'], 'exam_eval_section_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_evaluations', function (Blueprint $table) {
            if (Schema::hasColumn('exam_evaluations', 'internal_category_id')) {
                $table->dropForeign(['internal_category_id']);
                $table->dropColumn('internal_category_id');
            }

            if (Schema::hasColumn('exam_evaluations', 'is_visible')) {
                $table->dropColumn('is_visible');
            }

            if (Schema::hasColumn('exam_evaluations', 'start_mode')) {
                $table->dropColumn('start_mode');
            }

            if (Schema::hasColumn('exam_evaluations', 'context_type')) {
                $table->dropColumn('context_type');
            }

            if (Schema::hasColumn('exam_evaluations', 'section_id')) {
                $table->dropForeign(['section_id']);
                $table->dropColumn('section_id');
            }

            if (Schema::hasColumn('exam_evaluations', 'course_id')) {
                $table->dropForeign(['course_id']);
                $table->dropColumn('course_id');
            }

        });
    }
};
