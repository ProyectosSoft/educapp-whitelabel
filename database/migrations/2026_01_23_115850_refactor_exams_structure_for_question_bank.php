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
        // 1. Modify exam_categories to be independent
        Schema::table('exam_categories', function (Blueprint $table) {
            // Drop foreign key first if it exists. Note: names might vary, standard is table_column_foreign
            // I'll attempt to drop column directly, on SQLite/MySQL this might require dropping FK constraint first.
            // Assuming MySQL.
            $table->dropForeign(['evaluation_id']); 
            $table->dropColumn('evaluation_id');
            
            // These columns are now context-specific, so move them to pivot, 
            // BUT a category might keep them as 'defaults' or just drop them.
            // The user says "categorias y preguntas deben crease aparte... y en la evaluacion se escoge... el peso porcentual de la categoria dentro de la evaluacion"
            // So weight and count belong to the PIVOT.
            $table->dropColumn('weight_percent'); 
            $table->dropColumn('questions_per_attempt');

            $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
        });

        // 2. Create the pivot table
        Schema::create('exam_evaluation_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_evaluation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('exam_category_id')->constrained()->cascadeOnDelete();
            
            // Config specific to this attachment
            $table->integer('weight_percent')->default(0);
            $table->integer('questions_per_attempt')->default(1);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_evaluation_category');

        Schema::table('exam_categories', function (Blueprint $table) {
            $table->foreignId('evaluation_id')->nullable()->constrained('exam_evaluations')->cascadeOnDelete();
            $table->integer('weight_percent')->default(0);
            $table->integer('questions_per_attempt')->default(1);
            
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
