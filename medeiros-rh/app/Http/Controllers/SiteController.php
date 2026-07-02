<?php

namespace App\Http\Controllers;

use App\Models\Vaga;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function home()
    {
        $vagas = Vaga::where('status', 'aberta')->latest()->get();
        return view('site.trabalhe-conosco', compact('vagas'));
    }
}
