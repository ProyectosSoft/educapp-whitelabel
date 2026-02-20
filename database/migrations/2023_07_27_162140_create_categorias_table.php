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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();

            $table->string("nombre",45);
            $table->text('icon')->nullable();
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->tinyInteger("estado",$autoIncrement=false,$unsigned=true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
