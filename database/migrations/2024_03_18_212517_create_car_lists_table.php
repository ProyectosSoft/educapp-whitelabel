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
        Schema::create('car_lists', function (Blueprint $table) {
            $table->id();
            $table->float('price');
            $table->string('currency');
            $table->string('nombre');
            $table->string('url');
            $table->float('descuento');
            $table->float('subtotal');
            $table->float('impuestos');
            $table->float('total');
            $table ->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger("instructor_id");
            $table->string("instructor_name",200);
            $table->uuid('session_id')->nullable();
            $table ->unsignedBigInteger('curso_id');
            $table ->unsignedBigInteger('cupon_id');
            $table->foreign('curso_id')->references('id')->on('cursos');
            $table->string('curso_name');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('cupon_id')->references('id')->on('cupons');
            $table->tinyInteger("estado",$autoincrement=false,$unsigned=true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_lists');
    }
};
