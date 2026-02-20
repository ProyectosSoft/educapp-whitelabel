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
        Schema::create('idioma_curso_usuario', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("curso_id");
            $table->unsignedBigInteger("user_id");
            $table->tinyInteger("estado",$autoIncrement=false,$unsigned=true);

            $table->foreign("curso_id")->references("id")->on("cursos");
            $table->foreign("user_id")->references("id")->on("users");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idioma_curso_usuario');
    }
};
