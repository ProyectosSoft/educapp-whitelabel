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
        Schema::create('comentario', function (Blueprint $table) {
            $table->id();

            $table->string("descripcion");
            $table->unsignedBigInteger("seccion_cursos_id");
            $table->unsignedBigInteger("clasificacion_comentarios_id");
            $table->unsignedBigInteger("user_id");
            $table->tinyInteger("estado",$autoIncrement=false,$unsigned=true);

            $table->foreign("clasificacion_comentarios_id")->references("id")->on("clasificacion_comentario");
            $table->foreign("seccion_cursos_id")->references("id")->on("seccion_cursos");
            $table->foreign("user_id")->references("id")->on("users");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentario');
    }
};
