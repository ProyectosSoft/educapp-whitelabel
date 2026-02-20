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
        Schema::create('evaluacion_leccion', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("evaluaciones_id");
            $table->unsignedBigInteger("leccion_curso_id");
            $table->tinyInteger("estado",$autoIncrement=false,$unsigned=true);

            $table->foreign("evaluaciones_id")->references("id")->on("evaluaciones");
            $table->foreign("leccion_curso_id")->references("id")->on("leccion_cursos");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluacion_leccion');
    }
};
