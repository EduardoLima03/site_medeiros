<?php

namespace App\Services;

use App\Models\Oferta;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Throwable;

class PdfThumbnail
{
    public const PASTA = 'ofertas/thumbs';

    public function __construct(protected string $disk = 'public') {}

    public function nomeRelativo(string $arquivo): string
    {
        return self::PASTA.'/'.pathinfo($arquivo, PATHINFO_FILENAME).'_thumb.jpg';
    }

    public function caminhoAbsoluto(string $relativo): string
    {
        return Storage::disk($this->disk)->path($relativo);
    }

    public function dir(): string
    {
        $dir = $this->caminhoAbsoluto(self::PASTA);

        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        return $dir;
    }

    /**
     * Hospedagens compartilhadas costumam bloquear exec(), o que impede
     * renderizar o PDF no servidor. Nesse caso a thumbnail chega pronta
     * do navegador (ver public/js/pdf-thumb.js).
     */
    public function suportaGerarNoServidor(): bool
    {
        return $this->temImagick() || $this->temExec();
    }

    public function temImagick(): bool
    {
        return extension_loaded('imagick') && class_exists(\Imagick::class);
    }

    public function temExec(): bool
    {
        return function_exists('exec') && function_exists('escapeshellarg');
    }

    /**
     * Gera a thumbnail da 1ª página do PDF no servidor e grava em `thumb`.
     */
    public function gerar(Oferta $oferta): bool
    {
        $pdf = $this->caminhoAbsoluto($oferta->arquivo);

        if (! $pdf || ! is_file($pdf)) {
            return false;
        }

        $this->dir();

        $relativo = $this->nomeRelativo($oferta->arquivo);
        $destino = $this->caminhoAbsoluto($relativo);

        $gerado = false;

        if ($this->temImagick()) {
            $gerado = $this->gerarComImagick($pdf, $destino);
        }

        if (! $gerado && $this->temExec()) {
            $gerado = $this->gerarComGhostscript($pdf, $destino);
        }

        if (! $gerado) {
            return false;
        }

        $this->aplicar($oferta, $relativo);

        return true;
    }

    /**
     * Grava a thumbnail já renderizada no navegador (upload via AJAX/formulário).
     */
    public function salvarEnviado(UploadedFile $imagem, Oferta $oferta): string
    {
        $this->dir();

        $relativo = $this->nomeRelativo($oferta->arquivo);
        $destino = $this->caminhoAbsoluto($relativo);

        file_put_contents($destino, file_get_contents($imagem->getRealPath()));

        $this->aplicar($oferta, $relativo);

        return $relativo;
    }

    public function apagar(Oferta $oferta): void
    {
        if (! $oferta->thumb) {
            return;
        }

        if (! str_starts_with($oferta->thumb, self::PASTA.'/')) {
            return;
        }

        $caminho = $this->caminhoAbsoluto($oferta->thumb);

        if (is_file($caminho)) {
            @unlink($caminho);
        }
    }

    private function aplicar(Oferta $oferta, string $relativo): void
    {
        $anterior = $oferta->thumb;
        $oferta->forceFill(['thumb' => $relativo])->save();

        if ($anterior && $anterior !== $relativo && str_starts_with($anterior, self::PASTA.'/')) {
            $caminho = $this->caminhoAbsoluto($anterior);

            if (is_file($caminho)) {
                @unlink($caminho);
            }
        }
    }

    private function gerarComImagick(string $pdf, string $destino): bool
    {
        try {
            $imagick = new \Imagick;
            $imagick->setResolution(96, 96);
            $imagick->readImage($pdf.'[0]');
            $imagick->setImageFormat('jpeg');
            $imagick->setImageCompressionQuality(85);
            $imagick->writeImage($destino);
            $imagick->clear();
        } catch (Throwable $e) {
            logger()->warning('Imagick nao gerou o thumbnail (politica de PDF ou gs ausente): '.$e->getMessage());

            return false;
        }

        return is_file($destino);
    }

    private function gerarComGhostscript(string $pdf, string $destino): bool
    {
        $cmd = sprintf(
            'gs -dNOPAUSE -dBATCH -sDEVICE=jpeg -r96 -dFirstPage=1 -dLastPage=1 -dTextAlphaBits=4 -dGraphicsAlphaBits=4 -sOutputFile=%s %s 2>/dev/null',
            escapeshellarg($destino),
            escapeshellarg($pdf)
        );

        exec($cmd, $output, $exitCode);

        return $exitCode === 0 && is_file($destino);
    }
}
