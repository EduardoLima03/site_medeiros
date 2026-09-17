<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_block_slides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_block_id')->constrained('page_blocks')->cascadeOnDelete();
            $table->string('imagem')->nullable();
            $table->string('link')->nullable();
            $table->string('titulo')->nullable();
            $table->integer('ordem')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_block_slides');
    }
};