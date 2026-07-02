<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('curriculos', function (Blueprint $table) {
            $table->string('endereco')->nullable()->after('telefone');
            $table->string('familia')->nullable()->after('endereco');
            $table->integer('idade')->nullable()->after('familia');
            $table->string('sexo')->nullable()->after('idade');
            $table->text('objetivo')->nullable()->after('sexo');
            $table->text('formacao')->nullable()->after('objetivo');
            $table->text('experiencia_profissional')->nullable()->after('formacao');
        });
    }

    public function down(): void
    {
        Schema::table('curriculos', function (Blueprint $table) {
            $table->dropColumn(['endereco', 'familia', 'idade', 'sexo', 'objetivo', 'formacao', 'experiencia_profissional']);
        });
    }
};
