<?php

namespace App\Console\Commands;

use App\Models\Oferta;
use Illuminate\Console\Command;

class GerarThumbsOfertas extends Command
{
    protected $signature = 'ofertas:gerar-thumbs';
    protected $description = 'Gera thumbnails para todas as ofertas do tipo PDF que ainda nao possuem';

    public function handle()
    {
        $ofertas = Oferta::where('tipo', 'pdf')->whereNull('thumb')->get();

        if ($ofertas->isEmpty()) {
            $this->info('Nenhuma oferta PDF sem thumbnail.');
            return Command::SUCCESS;
        }

        $thumbDir = storage_path('app/public/ofertas/thumbs');
        if (!is_dir($thumbDir)) {
            mkdir($thumbDir, 0755, true);
        }

        $count = 0;

        foreach ($ofertas as $oferta) {
            $pdfPath = storage_path('app/public/' . $oferta->arquivo);
            if (!file_exists($pdfPath)) {
                $this->warn("Arquivo nao encontrado: {$oferta->arquivo}");
                continue;
            }

            $thumbName = pathinfo($oferta->arquivo, PATHINFO_FILENAME) . '_thumb.jpg';
            $thumbPath = $thumbDir . '/' . $thumbName;

            $cmd = sprintf(
                'gs -dNOPAUSE -dBATCH -sDEVICE=jpeg -r72 -dFirstPage=1 -dLastPage=1 -dTextAlphaBits=4 -dGraphicsAlphaBits=4 -sOutputFile=%s %s 2>/dev/null',
                escapeshellarg($thumbPath),
                escapeshellarg($pdfPath)
            );

            exec($cmd, $output, $exitCode);

            if ($exitCode === 0 && file_exists($thumbPath)) {
                $oferta->update(['thumb' => 'ofertas/thumbs/' . $thumbName]);
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
