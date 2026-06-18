<?php

namespace App\Console\Commands;

use App\Models\Oferta;
use Illuminate\Console\Command;

class AtualizarStatusOfertas extends Command
{
    protected $signature = 'ofertas:atualizar-status';
    protected $description = 'Desativa ofertas cuja data_fim já passou';

    public function handle()
    {
        $hoje = now()->format('Y-m-d');
        $desativadas = Oferta::where('data_fim', '<', $hoje)
            ->where('ativa', true)
            ->update(['ativa' => false]);

        $this->info("{$desativadas} oferta(s) desativada(s) por data de vigência expirada.");
    }
}
