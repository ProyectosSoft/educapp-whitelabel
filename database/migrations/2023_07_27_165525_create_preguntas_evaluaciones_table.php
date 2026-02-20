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
        Schema::create('preguntas_evaluaciones', function (Blueprint $table) {
            $table->id();


            $table->string('descripcion',500);
            $table->tinyInteger('pregunta_correcta');
            $table->unsignedBigInteger("evaluaciones_id");
            $table->unsignedBigInteger("tipo_pregunta_evaluacions_id");
            $table->tinyInteger("estado",$autoincrement=false,$unsigned=true);

            $table->foreign("evaluaciones_id")->references("id")->on("evaluaciones");
            $table->foreign("tipo_pregunta_evaluacions_id")->references("id")->on("tipo_pregunta_evaluacions");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preguntas_evaluaciones');
    }
};
