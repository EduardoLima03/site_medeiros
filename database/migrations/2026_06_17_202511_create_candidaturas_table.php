<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidaturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vaga_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pendente', 'em_andamento', 'aprovado', 'rejeitado'])->default('pendente');
            $table->timestamps();

            $table->unique(['vaga_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidaturas');
    }
};
