@extends('layouts.dashboard')

@php
$blockTypes = [
    'banner'    => 'Banner / Hero',
    'carrossel' => 'Carrossel de Imagens',
    'texto'     => 'Texto',
    'imagem'    => 'Imagem',
    'ofertas'   => 'Grid de Ofertas',
    'vagas'     => 'Vagas Abertas',
    'cta_app'   => 'CTA App',
    'mapa'      => 'Mapa de Lojas',
];
@endphp

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0" style="font-weight: 700;"><i class="bi bi-pencil-square"></i> Editar Bloco</h2>
        <a href="{{ route('admin.blocks') }}" class="small text-muted text-decoration-none"><i class="bi bi-arrow-left"></i> Voltar aos blocos</a>
    </div>
    <span class="badge bg-light border text-dark fs-6">{{ $blockTypes[$block->type] ?? $block->type }}</span>
</div>

<div class="card card-dashboard">
    <div class="card-body">
        <form action="{{ route('admin.blocks.update', $block->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Título</label>
                <input type="text" name="titulo" value="{{ old('titulo', $block->titulo) }}" class="form-control">
                <div class="form-text">Título exibido acima do bloco no site.</div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Conteúdo / Descrição</label>
                <textarea name="conteudo" rows="4" class="form-control">{{ old('conteudo', $block->conteudo) }}</textarea>
            </div>

            @if(in_array($block->type, ['banner', 'imagem']))
            <div class="mb-3">
                <label class="form-label fw-semibold">Imagem</label>
                <input type="file" name="imagem" accept="image/*" class="form-control">
                @if($block->imagem)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $block->imagem) }}" alt="Imagem atual" class="rounded" style="max-height: 120px;">
                    <div class="form-text">Deixe vazio para manter a imagem atual.</div>
                </div>
                @endif
            </div>
            @endif

            <div class="mb-3">
                <label class="form-label fw-semibold">Link (URL)</label>
                <input type="url" name="link" value="{{ old('link', $block->link) }}" class="form-control" placeholder="https://...">
            </div>

            <div class="mb-4 form-check form-switch">
                <input class="form-check-input" type="checkbox" name="ativo" value="1" {{ old('ativo', $block->ativo) ? 'checked' : '' }} id="ativoSwitch">
                <label class="form-check-label fw-semibold" for="ativoSwitch">Visível no site</label>
            </div>

            <button type="submit" class="btn btn-success rounded-pill px-4"><i class="bi bi-save"></i> Salvar Alterações</button>
            <a href="{{ route('admin.blocks') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancelar</a>
        </form>
    </div>
</div>

@if($block->type === 'carrossel')
<div class="card card-dashboard mt-4">
    <div class="card-body">
        <h5 class="fw-bold mb-1"><i class="bi bi-collection"></i> Slides do Carrossel</h5>
        <p class="text-muted small">Adicione imagens e, se quiser, um link para onde o slide deve levar ao ser clicado.</p>

        <form action="{{ route('admin.blocks.slides.store', $block) }}" method="POST" enctype="multipart/form-data" class="row g-2 align-items-end border-bottom pb-4 mb-4">
            @csrf
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Imagem *</label>
                <input type="file" name="imagem" accept="image/*" class="form-control form-control-sm" required>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Título (opcional)</label>
                <input type="text" name="titulo" class="form-control form-control-sm" placeholder="Ex: Oferta da semana">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Link (opcional)</label>
                <input type="text" name="link" class="form-control form-control-sm" placeholder="/ofertas ou https://...">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success btn-sm rounded-pill w-100"><i class="bi bi-plus-lg"></i> Adicionar</button>
            </div>
        </form>

        @forelse($block->slides as $i => $slide)
        <div class="d-flex flex-wrap align-items-center gap-3 border rounded-3 p-2 mb-2">
            <img src="{{ Storage::url($slide->imagem) }}" alt="{{ $slide->titulo }}" class="rounded" style="width: 110px; height: 68px; object-fit: cover; flex-shrink: 0;">

            <form action="{{ route('admin.blocks.slides.update', [$block, $slide]) }}" method="POST" enctype="multipart/form-data" class="row g-2 flex-grow-1 align-items-end m-0" style="min-width: 320px;">
                @csrf
                @method('PUT')
                <div class="col-md-4">
                    <label class="form-label small text-muted mb-0">Substituir imagem</label>
                    <input type="file" name="imagem" accept="image/*" class="form-control form-control-sm">
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted mb-0">Título</label>
                    <input type="text" name="titulo" value="{{ $slide->titulo }}" class="form-control form-control-sm">
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted mb-0">Link</label>
                    <input type="text" name="link" value="{{ $slide->link }}" class="form-control form-control-sm" placeholder="/ofertas ou https://...">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-sm btn-outline-primary w-100" title="Salvar slide"><i class="bi bi-save"></i></button>
                </div>
            </form>

            <div class="d-flex flex-column gap-1">
                <form action="{{ route('admin.blocks.slides.move', [$block, $slide]) }}" method="POST" class="m-0">
                    @csrf
                    <input type="hidden" name="direcao" value="subir">
                    <button class="btn btn-sm btn-outline-secondary py-0 px-2" title="Mover para cima" {{ $loop->first ? 'disabled' : '' }}><i class="bi bi-arrow-up"></i></button>
                </form>
                <form action="{{ route('admin.blocks.slides.move', [$block, $slide]) }}" method="POST" class="m-0">
                    @csrf
                    <input type="hidden" name="direcao" value="descer">
                    <button class="btn btn-sm btn-outline-secondary py-0 px-2" title="Mover para baixo" {{ $loop->last ? 'disabled' : '' }}><i class="bi bi-arrow-down"></i></button>
                </form>
            </div>

            <form action="{{ route('admin.blocks.slides.destroy', [$block, $slide]) }}" method="POST" class="m-0" onsubmit="return confirm('Remover este slide?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-outline-danger" title="Remover slide"><i class="bi bi-trash"></i></button>
            </form>
        </div>
        @empty
        <div class="text-center text-muted py-4">
            <i class="bi bi-images fs-1 d-block mb-2"></i>
            Nenhum slide adicionado ainda. Envie a primeira imagem acima.
        </div>
        @endforelse
    </div>
</div>
@endif
@endsection