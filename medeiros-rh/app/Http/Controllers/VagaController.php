<?php

namespace App\Http\Controllers;

use App\Models\Vaga;
use App\Models\Candidatura;
use Illuminate\Http\Request;

class VagaController extends Controller
{
    public function index()
    {
        $vagas = Vaga::latest()->get();
        return view('dashboard.rh.vagas', compact('vagas'));
    }

    public function create()
    {
        return view('dashboard.rh.vaga-form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:aberta,fechada',
        ]);
        $data['user_id'] = auth()->id();
        if ($request->hasFile('imagem')) {
            $data['imagem'] = $request->file('imagem')->store('vagas', 'public');
        }
        Vaga::create($data);
        return redirect()->route('rh.vagas')->with('success', 'Vaga criada com sucesso!');
    }

    public function edit(Vaga $vaga)
    {
        return view('dashboard.rh.vaga-form', compact('vaga'));
    }

    public function update(Request $request, Vaga $vaga)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:aberta,fechada',
        ]);
        if ($request->hasFile('imagem')) {
            $data['imagem'] = $request->file('imagem')->store('vagas', 'public');
        }
        $vaga->update($data);
        return redirect()->route('rh.vagas')->with('success', 'Vaga atualizada com sucesso!');
    }

    public function destroy(Vaga $vaga)
    {
        $vaga->delete();
        return redirect()->route('rh.vagas')->with('success', 'Vaga removida!');
    }

    public function candidaturas(Vaga $vaga)
    {
        $candidaturas = $vaga->candidaturas()->with('user', 'curriculo')->latest()->get();
        return view('dashboard.rh.candidaturas', compact('vaga', 'candidaturas'));
    }
}
