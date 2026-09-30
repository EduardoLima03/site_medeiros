<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    /**
     * Um candidato tem um unico curriculo: ele e reutilizado em todas as candidaturas,
     * evitando linhas duplicadas na listagem do RH.
     */
    public function up(): void
    {
        $duplicados = DB::table('curriculos')
            ->whereNotIn('id', function ($query) {
                $query->selectRaw('MAX(id)')->from('curriculos')->groupBy('user_id');
            })
            ->get(['id', 'arquivo']);

        $arquivosEmUso = DB::table('curriculos')->whereNotNull('arquivo')->pluck('arquivo')->all();

        foreach ($duplicados as $duplicado) {
            DB::table('curriculos')->where('id', $duplicado->id)->delete();
        }

        $orfaos = array_filter(
            $duplicados->pluck('arquivo')->all(),
            fn ($arquivo) => $arquivo && ! in_array($arquivo, $arquivosEmUso, true)
        );

        if ($orfaos) {
            Storage::disk('public')->delete($orfaos);
        }

        Schema::table('curriculos', function (Blueprint $table) {
            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        // No MySQL a FK de user_id usa este indice, entao outro indice e criado antes de remover o unique.
        Schema::table('curriculos', function (Blueprint $table) {
            $table->index('user_id');
        });

        Schema::table('curriculos', function (Blueprint $table) {
            $table->dropUnique(['user_id']);
        });
    }
};
