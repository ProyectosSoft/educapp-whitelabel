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
        Schema::create('respuesta_evaluaciones', function (Blueprint $table) {
            $table->id();

            $table->string('descripcion',200);
            $table->tinyInteger('correcta');
            $table->unsignedBigInteger("preguntas_evaluaciones_id");
            $table->unsignedBigInteger("user_id");
            $table->tinyInteger("estado",$autoincrement=false,$unsigned=true);

            $table->foreign("preguntas_evaluaciones_id")->references("id")->on("preguntas_evaluaciones");
            $table->foreign("user_id")->references("id")->on("users");


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuesta_evaluaciones');
    }
};
