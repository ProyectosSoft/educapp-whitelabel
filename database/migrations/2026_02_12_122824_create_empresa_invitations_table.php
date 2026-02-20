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
        Schema::create('empresa_invitations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->foreignId('departamento_id')->nullable()->constrained('departamentos')->onDelete('cascade');
            $table->string('role_name')->default('Estudiante'); // 'Estudiante', 'Instructor', etc.
            $table->string('email')->nullable(); // If restricted to specific email
            $table->integer('max_uses')->default(1);
            $table->integer('current_uses')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresa_invitations');
    }
};
