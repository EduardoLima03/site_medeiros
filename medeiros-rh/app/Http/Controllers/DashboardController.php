<?php

namespace App\Http\Controllers;

use App\Models\Vaga;
use App\Models\Candidatura;
use App\Models\Curriculo;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (in_array($user->role, ['admin', 'rh'])) {
            $vagasAbertas = Vaga::where('status', 'aberta')->count();
            $totalCandidaturas = Candidatura::count();
            $totalCurriculos = Curriculo::count();
            return view('dashboard.rh.home', compact('vagasAbertas', 'totalCandidaturas', 'totalCurriculos'));
        }

        if ($user->role === 'client') {
            $candidaturas = Candidatura::where('user_id', $user->id)->with('vaga')->latest()->get();
            $curriculo = Curriculo::where('user_id', $user->id)->latest()->first();
            return view('dashboard.client.home', compact('candidaturas', 'curriculo'));
        }

        return redirect()->route('site.home');
    }
}
