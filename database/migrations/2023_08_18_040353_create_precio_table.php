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
        Schema::create('precios', function (Blueprint $table) {
            $table->id();

            $table->string("nombre",45);
            $table->float("valor");
            $table->float("dctoMax");
            $table->float("dctoMin");
            $table->tinyInteger("estado",$autoIncrement=false,$unsigned=true);

            $table->unsignedBigInteger("moneda_id");
            $table->unsignedBigInteger("curso_id");
            $table->unsignedBigInteger("user_id");
            $table->foreign("moneda_id")->references("id")->on("monedas");
            $table->foreign("curso_id")->references("id")->on("cursos");
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('precio');
    }
};
