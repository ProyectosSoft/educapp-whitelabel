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
        Schema::create('horarios_cursos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('husos_horarios_id');
            $table->unsignedBigInteger('curso_id');

            $table->foreign('husos_horarios_id')->references('id')->on('husos_horarios');
            $table->foreign('curso_id')->references('id')->on('cursos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios_cursos');
    }
};
