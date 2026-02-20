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
        Schema::create('forma_pago_precios', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("precio_id");
            $table->unsignedBigInteger("forma_pagos_id");
            $table->tinyInteger("estado",$autoIncrement=false,$unsigned=true);

            $table->foreign("forma_pagos_id")->references("id")->on("forma_pagos");
            $table->foreign("precio_id")->references("id")->on("precios");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forma_pago_precio');
    }
};
