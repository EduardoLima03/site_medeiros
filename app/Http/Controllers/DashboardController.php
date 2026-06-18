<?php

namespace App\Http\Controllers;

use App\Models\Vaga;
use App\Models\Oferta;
use App\Models\Curriculo;
use App\Models\Candidatura;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.index');
        }
        if ($user->role === 'rh') {
            $vagasAbertas = Vaga::where('status', 'aberta')->count();
            $totalCandidaturas = Candidatura::count();
            $totalCurriculos = Curriculo::count();
            return view('dashboard.rh.home', compact('vagasAbertas', 'totalCandidaturas', 'totalCurriculos'));
        }
        if ($user->role === 'marketing') {
            $ofertasAtivas = Oferta::where('ativa', true)->count();
            $totalOfertas = Oferta::count();
            return view('dashboard.marketing.home', compact('ofertasAtivas', 'totalOfertas'));
        }

        if ($user->role === 'client') {
            $candidaturas = Candidatura::where('user_id', $user->id)->with('vaga')->latest()->get();
            $curriculo = Curriculo::where('user_id', $user->id)->latest()->first();
            return view('dashboard.client.home', compact('candidaturas', 'curriculo'));
        }

        return redirect()->route('site.home');
    }
}
