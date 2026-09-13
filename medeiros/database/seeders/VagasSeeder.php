<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vaga;
use Illuminate\Database\Seeder;

class VagasSeeder extends Seeder
{
    public function run(): void
    {
        $userRh = User::where('email', 'rh@medeiros.com.br')->first();

        if (! $userRh) {
            return;
        }

        $vagas = [
            [
                'titulo' => 'Caixa',
                'descricao' => 'Responsável pelo atendimento ao cliente no caixa, conferência de valores e emissão de cupons fiscais.',
                'status' => 'aberta',
            ],
            [
                'titulo' => 'Repositor de Prateleiras',
                'descricao' => 'Responsável por repor produtos nas prateleiras, conferir validade e organização dos itens do estoque.',
                'status' => 'aberta',
            ],
            [
                'titulo' => 'Estoquista',
                'descricao' => 'Responsável pelo recebimento, conferência e armazenamento de mercadorias no almoxarifado.',
                'status' => 'aberta',
            ],
        ];

        foreach ($vagas as $vaga) {
            Vaga::create(array_merge($vaga, ['user_id' => $userRh->id]));
        }
    }
}
