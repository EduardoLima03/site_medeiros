<?php

namespace App\Http\Controllers;

use App\Models\AchadoPerdido;
use App\Models\Oferta;
use App\Models\PageBlock;
use App\Models\PageContent;
use App\Models\SiteSetting;
use App\Models\Vaga;

class SiteController extends Controller
{
    public function home()
    {
        $blocks = PageBlock::where('page', 'home')->with('slides')->ativos()->ordenados()->get();
        $ofertas = Oferta::vigentes()->latest()->take(8)->get();
        $achados = AchadoPerdido::disponiveis()->latest()->take(6)->get();
        $vagas = Vaga::where('status', 'aberta')->latest()->take(3)->get();
        $settings = SiteSetting::pluck('value', 'key');
        $lojas = $this->lojasLista();

        return view('site.home', compact('blocks', 'ofertas', 'achados', 'vagas', 'settings', 'lojas'));
    }

    public function lojas()
    {
        $settings = SiteSetting::pluck('value', 'key');
        $lojas = $this->lojasLista();

        return view('site.lojas', compact('settings', 'lojas'));
    }

    public function sobre()
    {
        $settings = SiteSetting::pluck('value', 'key');

        return view('site.sobre', compact('settings'));
    }

    public function ofertas()
    {
        $settings = SiteSetting::pluck('value', 'key');
        $ofertas = Oferta::vigentes()->latest()->get();

        return view('site.ofertas', compact('settings', 'ofertas'));
    }

    public function achados()
    {
        $settings = SiteSetting::pluck('value', 'key');
        $achados = AchadoPerdido::disponiveis()->latest()->get();

        return view('site.achados', compact('settings', 'achados'));
    }

    public function trabalhe()
    {
        $settings = SiteSetting::pluck('value', 'key');
        $vagas = Vaga::where('status', 'aberta')->latest()->get();

        return view('site.trabalhe-conosco', compact('settings', 'vagas'));
    }

    public function pagina($slug)
    {
        $contents = PageContent::where('page', $slug)->get()->keyBy('section');
        if ($contents->isEmpty()) {
            abort(404);
        }
        $settings = SiteSetting::pluck('value', 'key');

        return view('site.pagina', compact('contents', 'slug', 'settings'));
    }

    private function lojasLista(): array
    {
        return [
            ['nome' => 'Loja 1 - Pref. José Walter', 'endereco' => 'Av. J, 130 - Pref. José Walter, Fortaleza - CE', 'telefone' => '(85) 9 9159-2951', 'maps' => 'https://maps.app.goo.gl/6ABSApyN1iz8Sngn9', 'imagem' => '/images/loja_01.jpg'],
            ['nome' => 'Loja 2 - Pref. José Walter', 'endereco' => 'Av. I, 1313 - Pref. José Walter, Fortaleza - CE', 'telefone' => '(85) 9 9158-8829', 'maps' => 'https://maps.app.goo.gl/juu4Up2YDXJQRAaQ8', 'imagem' => '/images/loja_02.jpg'],
            ['nome' => 'Loja 3 - Pacatuba', 'endereco' => 'Av. XX, n 230 - Cj - Jereissati II, Pacatuba - CE', 'telefone' => '(85) 9 8166-0326', 'maps' => 'https://maps.app.goo.gl/wk2upoHmCNjz8XgJ8', 'imagem' => '/images/loja_03.jpeg'],
            ['nome' => 'Loja 4 - Siqueira', 'endereco' => 'R. Gen. Rabelo, 447 - Siqueira, Fortaleza - CE', 'telefone' => '(85) 9 8192-2785', 'maps' => 'https://maps.app.goo.gl/ku4fR96rSrr2sRwk6', 'imagem' => '/images/loja_04.jpeg'],
            ['nome' => 'Loja 5 - Conj. Palmeiras', 'endereco' => 'R. Evaldo Braga, 821 - Conj. Palmeiras, Fortaleza - CE, 60870-210', 'telefone' => '(85) 9 8694-0174', 'maps' => 'https://maps.app.goo.gl/4DecPGGyjJ4HbHwr6', 'imagem' => '/images/loja_05.jpeg'],
        ];
    }
}
