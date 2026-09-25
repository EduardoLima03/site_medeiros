<?php

namespace App\Console\Commands;

use App\Models\Oferta;
use Illuminate\Console\Command;

class AtualizarStatusOfertas extends Command
{
    protected $signature = 'ofertas:atualizar-status';
    protected $description = 'Desativa ofertas vencidas (data_fim anterior a hoje) e informa as agendadas';

    public function handle()
    {
        $hoje = now()->format('Y-m-d');

        $desativadas = Oferta::vencidas()->update(['ativa' => false]);

        $futuras = Oferta::ativas()
            ->whereNotNull('data_inicio')
            ->where('data_inicio', '>', $hoje)
            ->count();

        $this->info("{$desativadas} oferta(s) desativada(s) por data de vigência expirada.");
        $this->info("{$futuras} oferta(s) aguardando a data de início (não exibidas no site).");
    }
}