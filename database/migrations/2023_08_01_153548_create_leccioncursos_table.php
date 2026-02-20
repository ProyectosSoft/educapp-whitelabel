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
        Schema::create('leccioncursos', function (Blueprint $table) {
            $table->id();

            $table->string("nombre");
            $table->string("url",2000);
            $table->string("iframe",4000);
            $table->unsignedBigInteger("seccion_curso_id");
            $table->tinyInteger("estado",$autoincrement=false,$unsigned=true);

            $table->foreign("seccion_curso_id")->references("id")->on("seccion_cursos");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leccioncursos');
    }
};
