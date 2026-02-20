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
        Schema::create('devolucion_items', function (Blueprint $table) {
            $table->id();
            $table->float('price');
            $table->string('currency');
            $table->string('nombre');
            $table->float('quantity');
            $table->float('descuento');
            $table->float('subtotal');
            $table->float('impuestos');
            $table->float('total');
            $table->unsignedBigInteger("instructor_id");
            $table->string("instructor_name",200);
            $table ->unsignedBigInteger('curso_id')->nullable();
            $table->string('curso_name',200);
            $table ->unsignedBigInteger('devolucion_id')->nullable();
            $table->foreign('devolucion_id')->references('id')->on('devolucions');
            $table->foreign('curso_id')->references('id')->on('cursos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devolucion_items');
    }
};
