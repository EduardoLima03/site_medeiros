<?php

namespace App\Http\Controllers;

use App\Models\Oferta;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.index');
        }

        if ($user->role === 'rh') {
            $rhUrl = env('RH_SITE_URL', 'http://localhost:8001');
            return redirect()->away($rhUrl . '/dashboard');
        }

        if ($user->role === 'marketing') {
            $ofertasAtivas = Oferta::where('ativa', true)->count();
            $totalOfertas = Oferta::count();
            return view('dashboard.marketing.home', compact('ofertasAtivas', 'totalOfertas'));
        }

        if ($user->role === 'client') {
            $rhUrl = env('RH_SITE_URL', 'http://localhost:8001');
            return redirect()->away($rhUrl . '/dashboard');
        }

        return redirect()->route('site.home');
    }
}
