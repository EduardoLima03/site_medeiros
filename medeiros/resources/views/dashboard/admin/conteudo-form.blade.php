@extends('layouts.dashboard')

@php
$blockTypes = [
    'banner'    => 'Banner / Hero',
    'texto'     => 'Texto',
    'imagem'    => 'Imagem',
    'ofertas'   => 'Grid de Ofertas',
    'achados'   => 'Achados e Perdidos',
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
@endsection