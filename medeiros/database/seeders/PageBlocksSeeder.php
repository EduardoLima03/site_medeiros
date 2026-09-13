<?php

namespace Database\Seeders;

use App\Models\PageBlock;
use Illuminate\Database\Seeder;

class PageBlocksSeeder extends Seeder
{
    public function run(): void
    {
        if (PageBlock::where('page', 'home')->exists()) {
            return;
        }

        $blocos = [
            [
                'type' => 'banner',
                'titulo' => 'Bem-vindo ao Mercantil Medeiros',
                'conteudo' => 'O supermercado da sua família, com produtos de qualidade pelo menor preço.',
                'link' => '/ofertas',
            ],
            [
                'type' => 'ofertas',
                'titulo' => 'OFERTAS DA SEMANA',
                'conteudo' => 'Corra e aproveite os melhores preços.',
            ],
            [
                'type' => 'achados',
                'titulo' => 'ACHADOS E PERDIDOS',
                'conteudo' => 'Perdeu algo em nossas lojas? Confira aqui.',
            ],
            [
                'type' => 'mapa',
                'titulo' => 'NOSSAS LOJAS',
                'conteudo' => 'Venha nos visitar, estamos pertinho de você.',
            ],
            [
                'type' => 'vagas',
                'titulo' => 'TRABALHE CONOSCO',
                'conteudo' => 'Venha fazer parte do time Medeiros.',
            ],
            [
                'type' => 'cta_app',
                'titulo' => 'Baixe o app do Medeiros',
                'conteudo' => 'Faça suas compras pelo celular e receba ofertas exclusivas.',
            ],
        ];

        foreach ($blocos as $ordem => $bloco) {
            PageBlock::create(array_merge($bloco, [
                'page' => 'home',
                'ordem' => $ordem,
                'ativo' => true,
            ]));
        }
    }
}
