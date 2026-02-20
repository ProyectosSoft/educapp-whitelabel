<?php

use App\Models\Devolucion;
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
        Schema::create('devolucions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('contact');
            $table->string('phone');
            $table->enum('status', [Devolucion::PEDIENTE, Devolucion::RECIBIDO, Devolucion::ENVIADO, Devolucion::ENTREGADO, Devolucion::ANULADO, Devolucion::PAGADO])->default(Devolucion::PEDIENTE);
            $table->float('total');
            $table->text('observation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devolucions');
    }
};
