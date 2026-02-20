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
        Schema::table('course_sessions', function (Blueprint $table) {
            $table->foreignId('last_lesson_id')->nullable()->after('ip_address')->constrained('leccioncursos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_sessions', function (Blueprint $table) {
            $table->dropForeign(['last_lesson_id']);
            $table->dropColumn('last_lesson_id');
        });
    }
};
