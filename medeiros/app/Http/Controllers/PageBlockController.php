<?php

namespace App\Http\Controllers;

use App\Models\PageBlock;
use Illuminate\Http\Request;

class PageBlockController extends Controller
{
    public function index()
    {
        $blocks = PageBlock::where('page', 'home')->ordenados()->get();

        return view('dashboard.admin.conteudo', compact('blocks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:banner,texto,imagem,ofertas,achados,vagas,cta_app,mapa',
            'titulo' => 'nullable|string|max:255',
            'conteudo' => 'nullable|string',
        ]);

        $maxOrdem = PageBlock::where('page', 'home')->max('ordem') ?? 0;

        PageBlock::create([
            'page' => 'home',
            'type' => $validated['type'],
            'titulo' => $validated['titulo'] ?? null,
            'conteudo' => $validated['conteudo'] ?? null,
            'ordem' => $maxOrdem + 1,
            'ativo' => true,
        ]);

        return redirect()->route('admin.blocks')->with('success', 'Bloco adicionado!');
    }

    public function edit(PageBlock $block)
    {
        return view('dashboard.admin.conteudo-form', compact('block'));
    }

    public function update(Request $request, PageBlock $block)
    {
        $validated = $request->validate([
            'titulo' => 'nullable|string|max:255',
            'conteudo' => 'nullable|string',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'link' => 'nullable|string|max:255',
            'ativo' => 'boolean',
        ]);

        if ($request->hasFile('imagem')) {
            $validated['imagem'] = $request->file('imagem')->store('blocos', 'public');
        }

        $validated['ativo'] = $request->boolean('ativo');

        $block->update($validated);

        return redirect()->route('admin.blocks')->with('success', 'Bloco atualizado!');
    }

    public function destroy(PageBlock $block)
    {
        $block->delete();

        return redirect()->route('admin.blocks')->with('success', 'Bloco removido!');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'ordem' => 'required|array',
            'ordem.*' => 'integer|exists:page_blocks,id',
        ]);

        foreach ($request->ordem as $posicao => $id) {
            PageBlock::where('id', $id)->update(['ordem' => $posicao]);
        }

        return redirect()->route('admin.blocks')->with('success', 'Ordem atualizada!');
    }
}
