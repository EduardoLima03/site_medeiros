<?php

namespace App\Console\Commands;

use App\Models\Oferta;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GerarThumbsOfertas extends Command
{
    protected $signature = 'ofertas:gerar-thumbs';
    protected $description = 'Gera thumbnails para todas as ofertas do tipo PDF que ainda nao possuem';

    public function handle()
    {
        $blocked = array_filter(['exec', 'escapeshellarg'], fn($fn) => !function_exists($fn));
        if ($blocked) {
            foreach ($blocked as $fn) {
                $this->warn("Funcao $fn() desabilitada no PHP - nao e possivel gerar thumbnails de PDF.");
            }
            return Command::SUCCESS;
        }

        $ofertas = Oferta::where('tipo', 'pdf')->whereNull('thumb')->get();

        if ($ofertas->isEmpty()) {
            $this->info('Nenhuma oferta PDF sem thumbnail.');
            return Command::SUCCESS;
        }

        $thumbDir = Storage::disk('public')->path('ofertas/thumbs');
        if (!is_dir($thumbDir)) {
            mkdir($thumbDir, 0755, true);
        }

        $count = 0;

        foreach ($ofertas as $oferta) {
            $pdfPath = Storage::disk('public')->path($oferta->arquivo);
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
