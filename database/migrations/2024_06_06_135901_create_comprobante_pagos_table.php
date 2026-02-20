<?php

use App\Models\comprobante_pago;
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
        Schema::create('comprobante_pagos', function (Blueprint $table) {
            $table->id();
            $table->string('numero');
            $table->date('fecha');
            $table->unsignedBigInteger('persona_id');
            $table->string('nombre');
            $table->date('fecha_elaboracion');
            $table->unsignedBigInteger('user_id');
            $table->enum('status', [comprobante_pago::PEDIENTE,comprobante_pago::RECIBIDO,comprobante_pago::ENVIADO,comprobante_pago::ENTREGADO,comprobante_pago::ANULADO,comprobante_pago::PAGADO])->default(comprobante_pago::PEDIENTE);
            $table->float('total');
            $table->string('observacion');
            $table->foreign('persona_id')->references('id')->on('users');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comprobante_pagos');
    }
};
