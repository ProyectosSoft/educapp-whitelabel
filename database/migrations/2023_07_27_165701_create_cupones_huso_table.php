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
        Schema::create('cupones_huso', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("cupons_id");
            $table->unsignedBigInteger("husos_horarios_id");
            $table->tinyInteger("estado",$autoIncrement=false,$unsigned=true);

            $table->foreign("cupons_id")->references("id")->on("cupons");
            $table->foreign("husos_horarios_id")->references("id")->on("husos_horarios");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cupones_huso');
    }
};
