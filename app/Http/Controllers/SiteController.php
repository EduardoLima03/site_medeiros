<?php

namespace App\Http\Controllers;

use App\Models\PageContent;
use App\Models\SiteSetting;
use App\Models\Vaga;
use App\Models\Oferta;
use App\Models\Loja;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function home()
    {
        $contents = PageContent::whereIn('page', ['home', 'global'])->get()->keyBy('section');
        $ofertas = Oferta::vigentes()->latest()->take(8)->get();
        $settings = SiteSetting::pluck('value', 'key');
        return view('site.home', compact('contents', 'ofertas', 'settings'));
    }

    public function lojas()
    {
        $contents = PageContent::where('page', 'lojas')->get()->keyBy('section');
        $settings = SiteSetting::pluck('value', 'key');
        $lojas = [
            ['nome' => 'Loja 1 - Pref. José Walter', 'endereco' => 'Av. J, 130 - Pref. José Walter, Fortaleza - CE', 'telefone' => '(85) 9 9159-2951', 'maps' => 'https://maps.app.goo.gl/6ABSApyN1iz8Sngn9', 'imagem' => '/images/loja_01.jpg'],
            ['nome' => 'Loja 2 - Pref. José Walter', 'endereco' => 'Av. I, 1313 - Pref. José Walter, Fortaleza - CE', 'telefone' => '(85) 9 9158-8829', 'maps' => 'https://maps.app.goo.gl/juu4Up2YDXJQRAaQ8', 'imagem' => '/images/loja_02.jpg'],
            ['nome' => 'Loja 3 - Pacatuba', 'endereco' => 'Av. XX, n 230 - Cj - Jereissati II, Pacatuba - CE', 'telefone' => '(85) 9 8166-0326', 'maps' => 'https://maps.app.goo.gl/wk2upoHmCNjz8XgJ8', 'imagem' => '/images/loja_03.jpeg'],
            ['nome' => 'Loja 4 - Siqueira', 'endereco' => 'R. Gen. Rabelo, 447 - Siqueira, Fortaleza - CE', 'telefone' => '(85) 9 8192-2785', 'maps' => 'https://maps.app.goo.gl/ku4fR96rSrr2sRwk6', 'imagem' => '/images/loja_04.jpeg'],
            ['nome' => 'Loja 5 - Conj. Palmeiras', 'endereco' => 'R. Evaldo Braga, 821 - Conj. Palmeiras, Fortaleza - CE, 60870-210', 'telefone' => '(85) 9 8694-0174', 'maps' => 'https://maps.app.goo.gl/4DecPGGyjJ4HbHwr6', 'imagem' => '/images/loja_05.jpeg'],
        ];
        return view('site.lojas', compact('contents', 'settings', 'lojas'));
    }

    public function sobre()
    {
        $contents = PageContent::where('page', 'sobre')->get()->keyBy('section');
        $settings = SiteSetting::pluck('value', 'key');
        return view('site.sobre', compact('contents', 'settings'));
    }

    public function ofertas()
    {
        $contents = PageContent::where('page', 'ofertas')->get()->keyBy('section');
        $ofertas = Oferta::vigentes()->latest()->get();
        $settings = SiteSetting::pluck('value', 'key');
        return view('site.ofertas', compact('contents', 'ofertas', 'settings'));
    }

    public function trabalheConosco()
    {
        $contents = PageContent::where('page', 'trabalhe_conosco')->get()->keyBy('section');
        $vagas = Vaga::where('status', 'aberta')->latest()->get();
        $settings = SiteSetting::pluck('value', 'key');
        return view('site.trabalhe-conosco', compact('contents', 'vagas', 'settings'));
    }
}
