<?php

namespace App\Http\Controllers;

use App\Models\AchadoPerdido;
use Illuminate\Http\Request;

class AchadoPerdidoController extends Controller
{
    public function index()
    {
        $achados = AchadoPerdido::latest()->get();

        return view('dashboard.marketing.achados', compact('achados'));
    }

    public function create()
    {
        return view('dashboard.marketing.achado-form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'local_encontrado' => 'nullable|string|max:255',
            'data_encontrado' => 'nullable|date',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
            'entregue' => 'boolean',
        ]);

        if ($request->hasFile('imagem')) {
            $data['imagem'] = $request->file('imagem')->store('achados', 'public');
        }

        $data['entregue'] = $request->boolean('entregue');
        $data['user_id'] = auth()->id();

        AchadoPerdido::create($data);

        return redirect()->route('marketing.achados')->with('success', 'Item cadastrado como achado e perdido!');
    }

    public function edit(AchadoPerdido $achado)
    {
        return view('dashboard.marketing.achado-form', compact('achado'));
    }

    public function update(Request $request, AchadoPerdido $achado)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'local_encontrado' => 'nullable|string|max:255',
            'data_encontrado' => 'nullable|date',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
            'entregue' => 'boolean',
        ]);

        if ($request->hasFile('imagem')) {
            $data['imagem'] = $request->file('imagem')->store('achados', 'public');
        }

        $data['entregue'] = $request->boolean('entregue');

        $achado->update($data);

        return redirect()->route('marketing.achados')->with('success', 'Item atualizado!');
    }

    public function destroy(AchadoPerdido $achado)
    {
        $achado->delete();

        return redirect()->route('marketing.achados')->with('success', 'Item removido!');
    }
}
