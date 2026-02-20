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
        Schema::create('referralcodes', function (Blueprint $table) {
            $table->id();
            $table->string("nombre",50);
            $table->string('codigo',50);
            $table->dateTime('fecha_inicio');
            $table->datetime('fecha_fin');
            $table->float('valor');
            $table->integer("cantidad");
            $table->unsignedBigInteger("curso_id");
            $table->tinyInteger("estado",$autoincrement=false,$unsigned=true);
            $table->foreign("curso_id")->references("id")->on("cursos");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referralcodes');
    }
};
