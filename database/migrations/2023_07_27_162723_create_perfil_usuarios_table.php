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
        Schema::create('perfil_usuarios', function (Blueprint $table) {
            $table->id();


            $table->string("titulo",1000)->nullable();
            $table->string("website",50)->nullable();
            $table->string("facebook",45)->nullable();
            $table->string("linkedin",45)->nullable();
            $table->string("youtube",45)->nullable();
            $table->string("numerodeidentifacion",45)->nullable();
            $table->string("direccion",45)->nullable();
            $table->string("ciudad",50)->nullable();
            $table->string("codigopostal",45)->nullable();
            $table->string("movil",20)->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pais_id');
            $table->tinyInteger("estado",$autoIncrement=false,$unsigned=true);

            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("pais_id")->references("id")->on("pais");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perfil_usuarios');
    }
};
