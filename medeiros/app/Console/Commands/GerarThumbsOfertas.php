<?php

namespace App\Console\Commands;

use App\Models\Oferta;
use App\Services\PdfThumbnail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GerarThumbsOfertas extends Command
{
    protected $signature = 'ofertas:gerar-thumbs';
    protected $description = 'Gera thumbnails para todas as ofertas do tipo PDF que ainda nao possuem';

    public function handle(PdfThumbnail $thumbnails)
    {
        $ofertas = Oferta::where('tipo', 'pdf')->whereNull('thumb')->get();

        if ($ofertas->isEmpty()) {
            $this->info('Nenhuma oferta PDF sem thumbnail.');
            return Command::SUCCESS;
        }

        if (! $thumbnails->suportaGerarNoServidor()) {
            $this->warn('Este servidor nao renderiza PDF: exec()/escapeshellarg() desabilitadas e Imagick indisponivel.');
            $this->info('Sem alterar o PHP, gere as thumbnails pelo painel:');
            $this->line('  Dashboard > Marketing > Ofertas > "Gerar thumbnails" (o navegador renderiza com PDF.js).');
            return Command::SUCCESS;
        }

        $count = 0;

        foreach ($ofertas as $oferta) {
            if (! Storage::disk('public')->exists($oferta->arquivo)) {
                $this->warn("Arquivo nao encontrado: {$oferta->arquivo}");
                continue;
            }

            if ($thumbnails->gerar($oferta)) {
                $this->info("Thumb gerado: {$oferta->titulo}");
                $count++;
            } else {
                $this->warn("Falha ao gerar thumb: {$oferta->titulo}");
            }
        }

        $this->info("{$count} thumbnail(s) gerado(s).");
        return Command::SUCCESS;
    }
}
