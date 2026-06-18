<?php

namespace Database\Seeders;

use App\Models\PageContent;
use Illuminate\Database\Seeder;

class PageContentsSeeder extends Seeder
{
    public function run(): void
    {
        $contents = [
            // Home
            ['page' => 'home', 'section' => 'banner_titulo', 'content' => 'FAÇA SUAS COMPRAS NO MEDEIROS SUPERMERCADO SEM SAIR DE CASA'],
            ['page' => 'home', 'section' => 'encarte_titulo', 'content' => 'BAIXE NOSSO ENCARTE'],
            ['page' => 'home', 'section' => 'encarte_subtitulo', 'content' => 'Confira os nossos encartes de oferta!'],
            ['page' => 'home', 'section' => 'ofertas_titulo', 'content' => 'OFERTAS DA SEMANA'],
            ['page' => 'home', 'section' => 'ofertas_badge', 'content' => 'GRÁTIS'],

            // Sobre
            ['page' => 'sobre', 'section' => 'titulo', 'content' => 'Sobre nós'],
            ['page' => 'sobre', 'section' => 'texto_1', 'content' => 'O <strong>Mercantil Medeiros LTDA</strong> é uma rede de supermercados comprometida em oferecer produtos de qualidade com preços justos para a população de Fortaleza e região metropolitana. Com mais de 30 anos de história, o Medeiros Supermercado se destaca pelo atendimento humanizado e pela variedade de produtos.'],
            ['page' => 'sobre', 'section' => 'texto_2', 'content' => 'Nossas lojas estão estrategicamente localizadas para atender você com conforto e praticidade. Contamos com um amplo mix de produtos, desde hortifrúti fresquinho até carnes selecionadas, além de mercearia, laticínios, bebidas e muito mais.'],
            ['page' => 'sobre', 'section' => 'acao_social_titulo', 'content' => 'Ação Social'],
            ['page' => 'sobre', 'section' => 'acao_social_texto_1', 'content' => 'O Medeiros Supermercado acredita no poder da transformação social. Por isso, desenvolve projetos e parcerias que beneficiam comunidades locais, promovendo ações de solidariedade e desenvolvimento sustentável.'],
            ['page' => 'sobre', 'section' => 'acao_social_texto_2', 'content' => 'Acreditamos que empresas prosperam quando as comunidades ao seu redor também prosperam. Junte-se a nós nessa missão!'],

            // Lojas
            ['page' => 'lojas', 'section' => 'titulo', 'content' => 'Nossas Lojas'],

            // Ofertas
            ['page' => 'ofertas', 'section' => 'titulo', 'content' => 'OFERTAS DA SEMANA'],
            ['page' => 'ofertas', 'section' => 'badge', 'content' => 'GRÁTIS'],

            // Trabalhe Conosco
            ['page' => 'trabalhe_conosco', 'section' => 'titulo', 'content' => 'Trabalhe conosco'],
            ['page' => 'trabalhe_conosco', 'section' => 'texto_1', 'content' => 'Faça parte da equipe Medeiros Supermercado! Estamos sempre em busca de profissionais talentosos e dedicados para crescer junto conosco.'],
            ['page' => 'trabalhe_conosco', 'section' => 'texto_2', 'content' => '<strong>Confira nossas vagas abaixo ou cadastre-se para oportunidades futuras.</strong>'],
            ['page' => 'trabalhe_conosco', 'section' => 'sem_vagas', 'content' => 'Sem vagas abertas no momento.'],
            ['page' => 'trabalhe_conosco', 'section' => 'sem_vagas_sub', 'content' => 'Cadastre seu currículo e entraremos em contato quando houver oportunidades.'],

            // Global / Footer
            ['page' => 'global', 'section' => 'footer_info_titulo', 'content' => 'Informações'],
            ['page' => 'global', 'section' => 'footer_contato_titulo', 'content' => 'Fale Conosco'],
            ['page' => 'global', 'section' => 'footer_pagamento_titulo', 'content' => 'Formas de Pagamento'],
            ['page' => 'global', 'section' => 'footer_copyright', 'content' => 'Mercantil Medeiros LTDA'],
            ['page' => 'global', 'section' => 'footer_dev', 'content' => 'Desenvolvido por Francisco Rodrigues'],
        ];

        foreach ($contents as $content) {
            PageContent::create($content);
        }
    }
}
