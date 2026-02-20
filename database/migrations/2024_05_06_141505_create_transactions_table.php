<?php

use App\Models\Transaction;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->dateTime("date");
            $table->string("name",50);
            $table->string("transaction",200);
            $table->integer("number");
            $table->float('quantity');
            $table->float('descuento');
            $table->float('subtotal');
            $table->float('impuestos');
            $table->float('total');
            $table->string("detail",4000);
            $table->unsignedBigInteger("devolucion_id");
            $table->unsignedBigInteger("order_id");
            $table->unsignedBigInteger("saldo_id");
            $table->unsignedBigInteger("student_id");
            $table->unsignedBigInteger("instructor_id");
            $table->string("instructor_name",200);
            $table->unsignedBigInteger("curso_id");
            $table->string("curso_name",200);
            $table->string("observation");
            $table->enum('status', [Transaction::PEDIENTE, Transaction::RECIBIDO, Transaction::ENVIADO, Transaction::ENTREGADO, Transaction::ANULADO, Transaction::PAGADO])->default(Transaction::PEDIENTE);
            $table->enum('auxstatus', [Transaction::PEDIENTE, Transaction::RECIBIDO, Transaction::ENVIADO, Transaction::ENTREGADO, Transaction::ANULADO, Transaction::PAGADO])->default(Transaction::PEDIENTE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
