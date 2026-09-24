<?php

namespace App\Http\Controllers;

use App\Models\PageBlock;
use App\Models\PageBlockSlide;
use Illuminate\Http\Request;

class PageBlockController extends Controller
{
    public function index()
    {
        $blocks = PageBlock::where('page', 'home')->with('slides')->ordenados()->get();

        return view('dashboard.admin.conteudo', compact('blocks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:banner,texto,imagem,carrossel,ofertas,vagas,cta_app,mapa',
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
        $block->load('slides');

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

    public function storeSlide(Request $request, PageBlock $block)
    {
        $validated = $request->validate([
            'imagem' => 'required|image|mimes:jpeg,png,jpg,webp|max:8192',
            'link' => 'nullable|string|max:255',
            'titulo' => 'nullable|string|max:255',
        ]);

        $imagem = $request->file('imagem')->store('blocos/carrossel', 'public');
        $maxOrdem = $block->slides()->max('ordem') ?? -1;

        $block->slides()->create([
            'imagem' => $imagem,
            'link' => $validated['link'] ?? null,
            'titulo' => $validated['titulo'] ?? null,
            'ordem' => $maxOrdem + 1,
        ]);

        return redirect()->route('admin.blocks.edit', $block->id)->with('success', 'Slide adicionado!');
    }

    public function updateSlide(Request $request, PageBlock $block, PageBlockSlide $slide)
    {
        abort_unless($slide->page_block_id === $block->id, 404);

        $validated = $request->validate([
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'link' => 'nullable|string|max:255',
            'titulo' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('imagem')) {
            $validated['imagem'] = $request->file('imagem')->store('blocos/carrossel', 'public');
        }

        $slide->update($validated);

        return redirect()->route('admin.blocks.edit', $block->id)->with('success', 'Slide atualizado!');
    }

    public function destroySlide(PageBlock $block, PageBlockSlide $slide)
    {
        abort_unless($slide->page_block_id === $block->id, 404);

        $slide->delete();

        return redirect()->route('admin.blocks.edit', $block->id)->with('success', 'Slide removido!');
    }

    public function reorderSlides(Request $request, PageBlock $block)
    {
        $request->validate([
            'ordem' => 'required|array',
            'ordem.*' => 'integer',
        ]);

        foreach ($request->ordem as $posicao => $id) {
            PageBlockSlide::where('id', $id)->where('page_block_id', $block->id)->update(['ordem' => $posicao]);
        }

        return redirect()->route('admin.blocks.edit', $block->id)->with('success', 'Ordem dos slides atualizada!');
    }

    public function moveSlide(Request $request, PageBlock $block, PageBlockSlide $slide)
    {
        abort_unless($slide->page_block_id === $block->id, 404);

        $request->validate(['direcao' => 'required|in:subir,descer']);

        $slides = $block->slides()->get()->values();
        $index = $slides->search(fn ($s) => $s->id === $slide->id);
        if ($index === false) {
            return redirect()->route('admin.blocks.edit', $block->id);
        }

        $target = $request->direcao === 'subir' ? $index - 1 : $index + 1;
        if ($target < 0 || $target >= $slides->count()) {
            return redirect()->route('admin.blocks.edit', $block->id);
        }

        $outro = $slides[$target];
        $ordemAtual = $slide->ordem;
        $slide->update(['ordem' => $outro->ordem]);
        $outro->update(['ordem' => $ordemAtual]);

        return redirect()->route('admin.blocks.edit', $block->id)->with('success', 'Slide reordenado!');
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
