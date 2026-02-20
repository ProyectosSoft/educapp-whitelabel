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
        // 1. Create Difficulty Levels Table
        if (!Schema::hasTable('exam_difficulty_levels')) {
            Schema::create('exam_difficulty_levels', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // Alta, Media, Baja
                $table->integer('points')->default(1); // 10, 5, 1
                $table->unsignedBigInteger('user_id')->nullable(); // Created by instructor
                $table->timestamps();
            });
        }

        // 2. Add difficulty_level_id to exam_questions
        if (Schema::hasTable('exam_questions') && !Schema::hasColumn('exam_questions', 'difficulty_level_id')) {
            Schema::table('exam_questions', function (Blueprint $table) {
                $table->foreignId('difficulty_level_id')->nullable()->constrained('exam_difficulty_levels')->nullOnDelete();
            });
        }

        // 3. Add passing_percentage to pivot exam_evaluation_category
        if (Schema::hasTable('exam_evaluation_category') && !Schema::hasColumn('exam_evaluation_category', 'passing_percentage')) {
            Schema::table('exam_evaluation_category', function (Blueprint $table) {
                $table->integer('passing_percentage')->default(60)->after('weight_percent'); // Min score to pass this category
            });
        }
    }

    public function down(): void
    {
        Schema::table('exam_evaluation_category', function (Blueprint $table) {
            $table->dropColumn('passing_percentage');
        });

        Schema::table('exam_questions', function (Blueprint $table) {
            $table->dropForeign(['difficulty_level_id']);
            $table->dropColumn('difficulty_level_id');
        });

        Schema::dropIfExists('exam_difficulty_levels');
    }
};
