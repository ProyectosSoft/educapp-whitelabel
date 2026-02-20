<?php

use App\Models\Curso;
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
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();

            $table->string ("nombre",200);
            $table->string("subtitulo",200);
            $table->string("descripcion",2000);
            $table->enum('status',[Curso::BORRADOR,Curso::REVISION,Curso::PUBLICADO])->default(Curso::BORRADOR);
            $table->string('slug');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('nivel_id');
            $table->unsignedBigInteger('garantia_id');
            $table->unsignedBigInteger('tipo_formato_id');
            // $table->unsignedBigInteger('precio_id');
            $table->unsignedBigInteger('categoria_id');

            $table->tinyInteger('estado',$autoIncrement=false,$unsigned=true);

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('nivel_id')->references('id')->on('nivels');
            $table->foreign('garantia_id')->references('id')->on('garantias');
            $table->foreign('tipo_formato_id')->references('id')->on('tipo_formatos');
            // $table->foreign('precio_id')->references('id')->on('precios');
            $table->foreign('categoria_id')->references('id')->on('categorias');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curso');
    }
};
