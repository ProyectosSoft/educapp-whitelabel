<?php

use App\Models\SaldoFavor;
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
        Schema::create('saldo_favors', function (Blueprint $table) {
            $table->id();
            $table->dateTime("date");
            $table->string("name",50);
            $table->float('quantity');
            $table->float('descuento');
            $table->float('subtotal');
            $table->float('impuestos');
            $table->float('total');
            $table->float('saldo_restante');
            $table->string("detail",4000);
            $table->unsignedBigInteger("devolucion_id");
            $table->unsignedBigInteger("order_id");
            $table->unsignedBigInteger("saldo_id");
            $table->unsignedBigInteger("student_id");
            $table->unsignedBigInteger("instructor_id");
            $table->string("instructor_name",200);
            $table->unsignedBigInteger("curso_id");
            $table->string('curso_name',200);
            $table->enum('status', [SaldoFavor::PEDIENTE, SaldoFavor::RECIBIDO, SaldoFavor::ENVIADO, SaldoFavor::ENTREGADO, SaldoFavor::ANULADO, SaldoFavor::PAGADO])->default(SaldoFavor::PEDIENTE);
            $table->boolean('usado')->default(false); // Nuevo campo para indicar si el saldo está completamente usado
            $table->string("observation");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saldo_favors');

    }
};
