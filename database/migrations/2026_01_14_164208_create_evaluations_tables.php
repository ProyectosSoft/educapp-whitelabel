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
        if (!Schema::hasTable('evaluations')) {
            Schema::create('evaluations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('course_id')->nullable(); 
                $table->unsignedBigInteger('section_id')->nullable(); 
                $table->string('name');
                $table->text('description')->nullable();
                $table->integer('time_limit')->nullable(); 
                $table->integer('max_attempts')->default(1);
                $table->integer('passing_score')->default(80); 
                $table->integer('wait_time_minutes')->default(0); 
                $table->timestamps();

                $table->foreign('course_id')->references('id')->on('cursos')->onDelete('cascade');
                $table->foreign('section_id')->references('id')->on('seccion_cursos')->onDelete('cascade');
            });
        }

        if (!Schema::hasTable('questions')) {
            Schema::create('questions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('evaluation_id');
                $table->text('statement');
                $table->string('type')->default('multiple_choice'); 
                $table->integer('points')->default(10);
                $table->timestamps();

                $table->foreign('evaluation_id')->references('id')->on('evaluations')->onDelete('cascade');
            });
        }

        if (!Schema::hasTable('answers')) {
            Schema::create('answers', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('question_id');
                $table->string('text');
                $table->boolean('is_correct')->default(false);
                $table->timestamps();

                $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            });
        }

        if (!Schema::hasTable('student_attempts')) {
            Schema::create('student_attempts', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('evaluation_id');
                $table->decimal('score', 5, 2); 
                $table->boolean('passed')->default(false);
                $table->integer('attempt_number')->default(1);
                $table->timestamp('completed_at')->nullable();
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('evaluation_id')->references('id')->on('evaluations')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_attempts');
        Schema::dropIfExists('answers');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('evaluations');
    }
};
