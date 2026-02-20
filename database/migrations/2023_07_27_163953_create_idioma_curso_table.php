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
        Schema::create('idioma_curso', function (Blueprint $table) {
            $table->id();


            $table->unsignedBigInteger("idioma_id");
            $table->unsignedBigInteger("curso_id");
            $table->tinyInteger('estado',$autoIncrement=false,$unsigned=true);

            $table->foreign("curso_id")->references("id")->on("cursos");
            $table->foreign("idioma_id")->references("id")->on("idiomas");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idioma_curso');
    }
};
