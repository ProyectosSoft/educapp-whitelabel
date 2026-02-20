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
        Schema::create('comprobante_pago_detalles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comprobante_pago_id');
            $table->unsignedBigInteger("order_id");
            $table->unsignedBigInteger("curso_id");
            $table->string('curso_name',200);
            $table->string('observacion');
            $table->float('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comprobante_pago_detalles');
    }
};
