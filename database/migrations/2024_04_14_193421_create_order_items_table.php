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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->float('price');
            $table->string('currency');
            $table->string('nombre');
            $table->float('quantity');
            $table->float('descuento');
            $table->float('subtotal');
            $table->float('impuestos');
            $table->float('total');
            $table ->unsignedBigInteger('order_id')->nullable();
            $table ->unsignedBigInteger('curso_id')->nullable();
            $table->unsignedBigInteger("instructor_id")->nullable();
            $table->string('instructor_name',200);
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('curso_id')->references('id')->on('cursos');
            $table->string('curso_name',200);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
