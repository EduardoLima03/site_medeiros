@extends('layouts.dashboard')

@php
$blockTypes = [
    'banner'    => ['Hero / Banner', 'bi-image'],
    'carrossel' => ['Carrossel de Imagens', 'bi-collection'],
    'texto'     => ['Texto / Parágrafo', 'bi-text-paragraph'],
    'imagem'    => ['Imagem', 'bi-image-fill'],
    'ofertas'   => ['Grid de Ofertas', 'bi-tag-fill'],
    'vagas'     => ['Vagas Abertas', 'bi-briefcase-fill'],
    'cta_app'   => ['CTA App', 'bi-phone-fill'],
    'mapa'      => ['Mapa de Lojas', 'bi-geo-alt-fill'],
];
@endphp

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0" style="font-weight: 700;"><i class="bi bi-grid-3x3-gap"></i> Blocos da Home</h2>
    <span class="badge bg-secondary fs-6">{{ $blocks->count() }} {{ Str::plural('bloco', $blocks->count()) }}</span>
</div>

<p class="text-muted">Arraste para reordenar · Ative/desative · Adicione novas seções ao site.</p>

{{-- Formulário novo bloco --}}
<div class="card card-dashboard mb-4">
    <div class="card-body">
        <h6 class="fw-bold mb-3"><i class="bi bi-plus-circle"></i> Adicionar Bloco</h6>
        <form action="{{ route('admin.blocks.store') }}" method="POST" class="d-flex flex-wrap gap-2 align-items-end">
            @csrf
            <div class="flex-grow-1" style="min-width: 200px;">
                <label class="form-label small text-muted">Tipo</label>
                <select name="type" class="form-select form-select-sm" required>
                    @foreach($blockTypes as $value => $label)
                    <option value="{{ $value }}">{{ $label[0] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-grow-1" style="min-width: 250px;">
                <label class="form-label small text-muted">Título (opcional)</label>
                <input type="text" name="titulo" class="form-control form-control-sm" placeholder="Ex: NOSSAS LOJAS">
            </div>
            <button type="submit" class="btn btn-success btn-sm rounded-pill px-4"><i class="bi bi-plus-lg"></i> Adicionar</button>
        </form>
    </div>
</div>

{{-- Lista de blocos --}}
<form action="{{ route('admin.blocks.reorder') }}" method="POST" id="reorderForm">
    @csrf
    @method('PUT')
    <div class="d-flex justify-content-end mb-3">
        <button type="submit" class="btn btn-outline-primary btn-sm rounded-pill px-3" id="saveOrderBtn" style="display: none;">
            <i class="bi bi-check-lg"></i> Salvar nova ordem
        </button>
    </div>
    <div id="blockList" class="vstack gap-3">
        @forelse($blocks as $block)
        @php $info = $blockTypes[$block->type] ?? ['Desconhecido', 'bi-question-circle']; @endphp
        <div class="card card-dashboard block-item" draggable="true" data-id="{{ $block->id }}">
            <input type="hidden" name="ordem[]" value="{{ $block->id }}">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <div class="text-muted fs-4" style="cursor: grab;" title="Arrastrar"><i class="bi bi-grip-vertical"></i></div>

                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background: var(--primary, #387543); color: #fff; flex-shrink: 0;">
                    <i class="bi {{ $info[1] }}"></i>
                </div>

                <div class="flex-grow-1">
                    <div class="fw-semibold">
                        {{ $info[0] }}
                        @if($block->titulo)
                        <span class="text-muted fw-normal"> · {{ $block->titulo }}</span>
                        @endif
                    </div>
                    @if($block->conteudo)
                    <div class="text-muted small">{{ Str::limit($block->conteudo, 80) }}</div>
                    @endif
                </div>

                <div class="d-flex align-items-center gap-2">
                    <span class="badge {{ $block->ativo ? 'bg-success' : 'bg-secondary' }} rounded-pill">
                        {{ $block->ativo ? 'Ativo' : 'Inativo' }}
                    </span>
                    <a href="{{ route('admin.blocks.edit', $block->id) }}" class="btn btn-sm btn-outline-primary" title="Editar"><i class="bi bi-pencil"></i></a>
                    <button form="destroyForm-{{ $block->id }}" class="btn btn-sm btn-outline-danger" title="Remover"><i class="bi bi-trash"></i></button>
                </div>
            </div>
        </div>
        @empty
        <div class="card card-dashboard">
            <div class="card-body text-center text-muted py-5">
                <i class="bi bi-grid-3x3-gap fs-1 d-block mb-2"></i>
                Nenhum bloco adicionado. Adicione o primeiro bloco acima!
            </div>
        </div>
        @endforelse
    </div>
</form>

{{-- Formulários de exclusão fora do form de reordenar (HTML não permite forms aninhados) --}}
@foreach($blocks as $block)
<form action="{{ route('admin.blocks.destroy', $block->id) }}" method="POST" id="destroyForm-{{ $block->id }}" onsubmit="return confirm('Remover este bloco?')">
    @csrf
    @method('DELETE')
</form>
@endforeach

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const list = document.getElementById('blockList');
    if (!list) return;
    let dragged = null;

    list.addEventListener('dragstart', e => {
        dragged = e.target.closest('.block-item');
        if (dragged) { dragged.style.opacity = '0.4'; e.dataTransfer.effectAllowed = 'move'; }
    });
    list.addEventListener('dragend', e => {
        if (dragged) dragged.style.opacity = '1';
        dragged = null;
    });
    list.addEventListener('dragover', e => {
        e.preventDefault();
        const target = e.target.closest('.block-item');
        if (target && target !== dragged) {
            const rect = target.getBoundingClientRect();
            const midY = rect.top + rect.height / 2;
            if (e.clientY < midY) list.insertBefore(dragged, target);
            else list.insertBefore(dragged, target.nextSibling);
        }
    });
    list.addEventListener('drop', () => {
        document.getElementById('saveOrderBtn').style.display = 'inline-block';
    });
});
</script>
@endpush
@endsection