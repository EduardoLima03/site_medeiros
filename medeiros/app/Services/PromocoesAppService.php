<?php

namespace App\Services;

use DOMDocument;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PromocoesAppService
{
    public const URL = 'https://www.app.medeirossupermercado.cloud/promocoes?page=4';

    public function obter(int $limite = 5): array
    {
        return Cache::remember('promocoes_app', now()->addHour(), function () use ($limite) {
            return $this->buscarDaOrigem($limite);
        });
    }

    public function esquecer(): void
    {
        Cache::forget('promocoes_app');
    }

    private function buscarDaOrigem(int $limite): array
    {
        try {
            $resposta = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64; rv:156.0) Gecko/20100101 Firefox/156.0',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language' => 'pt-BR,pt;q=0.9,en;q=0.8',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Referer' => 'https://www.app.medeirossupermercado.cloud/',
                'Sec-Fetch-Dest' => 'document',
                'Sec-Fetch-Mode' => 'navigate',
                'Sec-Fetch-Site' => 'same-origin',
            ])->withOptions(['decode_content' => true])
                ->timeout(15)
                ->get(self::URL);

            $corpo = $resposta->body();

            if (blank($corpo) || str_contains($corpo, 'Just a moment')) {
                return [];
            }

            return array_slice($this->extrairProdutos($corpo), 0, $limite);
        } catch (\Throwable $e) {
            Log::warning('Promoções do app indisponíveis: '.$e->getMessage());

            return [];
        }
    }

    private function extrairProdutos(string $html): array
    {
        $produtos = $this->extrairDoDOM($html);

        if ($produtos->isEmpty()) {
            $produtos = $this->extrairDoJSON($html);
        }

        return $produtos->groupBy('link')->map->first()->values()->all();
    }

    private function extrairDoDOM(string $html): Collection
    {
        $dom = new DOMDocument();
        @$dom->loadHTML('<?xml encoding="UTF-8">' . $html);

        $produtos = collect();

        foreach ($dom->getElementsByTagName('a') as $a) {
            $href = $a->getAttribute('href');
            if (!preg_match('#(?:/product|/produto|/item|/producto)/#i', $href)) {
                continue;
            }

            $imagem = null;
            $alt = null;
            foreach ($a->getElementsByTagName('img') as $img) {
                if ($img->getAttribute('src')) {
                    $imagem = $img->getAttribute('src');
                    $alt = $img->getAttribute('alt') ?: $img->getAttribute('title');
                }
            }
            if (!$imagem) {
                continue;
            }

            $nome = trim($alt ?: $a->textContent);
            $nome = preg_replace('/\s+/u', ' ', $nome);
            if (mb_strlen($nome) > 200) {
                $nome = mb_substr($nome, 0, 200);
            }

            $preco = $this->precoDe($a->textContent);

            $produtos->push([
                'nome' => $nome,
                'imagem' => $imagem,
                'preco' => $preco,
                'link' => $this->absolutizar($href),
            ]);
        }

        return $produtos;
    }

    private function extrairDoJSON(string $html): Collection
    {
        $produtos = collect();
        $padrao = '#"([A-Za-zÀ-ú0-9 ]{4,120})"[^}]{0,400}?"(?:price|sale_price|price_formatted)"\s*:\s*"?([0-9.]+)#';

        if (preg_match_all($padrao, $html, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $m) {
                $produtos->push([
                    'nome' => trim($m[1]),
                    'imagem' => null,
                    'preco' => number_format((float) $m[2], 2, ',', '.'),
                    'link' => self::URL,
                ]);
            }
        }

        return $produtos;
    }

    private function precoDe(string $texto): ?string
    {
        if (preg_match('/R\$\s?(\d{1,3}(?:\.\d{3})*,\d{2})/', $texto, $m)) {
            return 'R$ ' . $m[1];
        }

        return null;
    }

    private function absolutizar(string $url): string
    {
        if (str_starts_with($url, 'http')) {
            return $url;
        }

        return 'https://www.app.medeirossupermercado.cloud' . (str_starts_with($url, '/') ? '' : '/') . $url;
    }
}