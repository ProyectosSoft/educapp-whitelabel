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
        Schema::table('cursos', function (Blueprint $table) {
            $table->boolean('is_public')->default(true)->after('status'); // true = visible en home a todos, false = restringido
            $table->unsignedBigInteger('empresa_id')->nullable()->after('is_public');
            $table->unsignedBigInteger('departamento_id')->nullable()->after('empresa_id');
            
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('set null');
            $table->foreign('departamento_id')->references('id')->on('departamentos')->onDelete('set null');
        });

        Schema::table('exam_evaluations', function (Blueprint $table) {
            $table->boolean('is_public')->default(true)->after('is_active');
            $table->unsignedBigInteger('empresa_id')->nullable()->after('is_public');
            $table->unsignedBigInteger('departamento_id')->nullable()->after('empresa_id');
            
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('set null');
            $table->foreign('departamento_id')->references('id')->on('departamentos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropForeign(['empresa_id']);
            $table->dropForeign(['departamento_id']);
            $table->dropColumn(['is_public', 'empresa_id', 'departamento_id']);
        });

        Schema::table('exam_evaluations', function (Blueprint $table) {
            $table->dropForeign(['empresa_id']);
            $table->dropForeign(['departamento_id']);
            $table->dropColumn(['is_public', 'empresa_id', 'departamento_id']);
        });
    }
};
