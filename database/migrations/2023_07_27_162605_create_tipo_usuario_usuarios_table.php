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
        Schema::create('tipo_usuario_usuarios', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("tipo_usuario_id");
            $table->unsignedBigInteger("user_id");
            $table->tinyInteger('estado',$autoIncrement=false,$unsigned=true);

            $table->foreign("tipo_usuario_id")->references("id")->on("tipo_usuarios");
            $table->foreign("user_id")->references("id")->on("users");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_usuario_usuarios');
    }
};
