@extends('layouts.dashboard')

@section('content')
@php
    $semThumb = $ofertas->filter(fn($o) => $o->tipo === 'pdf' && !$o->thumb);
@endphp
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Ofertas</h2>
    <div class="d-flex gap-2">
        @if($semThumb->isNotEmpty())
        <button type="button" class="btn btn-outline-success rounded-pill" id="btnGerarThumbs" title="Renderiza a 1ª página dos PDFs no navegador">
            <i class="bi bi-image"></i> Gerar thumbnails
        </button>
        @endif
        <a href="{{ route('marketing.ofertas.create') }}" class="btn btn-success rounded-pill"><i class="bi bi-plus-lg"></i> Nova Oferta</a>
    </div>
</div>

@if($semThumb->isNotEmpty())
<div class="alert alert-info d-flex align-items-center gap-2">
    <i class="bi bi-info-circle"></i>
    <span>{{ $semThumb->count() }} oferta(s) em PDF sem thumbnail. Use <strong>Gerar thumbnails</strong> para criar a imagem da 1ª página direto no navegador (o servidor não executa Ghostscript).</span>
</div>
@endif

@if($ofertas->count() > 0)
<div class="row g-3">
    @foreach($ofertas as $oferta)
    @php
        $hoje = now()->startOfDay();
        $expirada = $oferta->data_fim && $oferta->data_fim->lt($hoje);
        $agendada = $oferta->data_inicio && $oferta->data_inicio->gt($hoje);
        $vigente = $oferta->ativa && !$agendada && !$expirada;
        $status = $vigente ? 'Ativa' : ($agendada ? 'Agendada' : ($expirada ? 'Expirada' : 'Inativa'));
        $cor = $vigente ? 'success' : ($agendada ? 'info' : 'secondary');
    @endphp
    <div class="col-md-4">
        <div class="card card-dashboard {{ $expirada ? 'opacity-50' : '' }}"
             data-titulo="{{ $oferta->titulo }}"
             data-pdf-url="{{ $oferta->tipo === 'pdf' ? Storage::url($oferta->arquivo) : '' }}"
             data-thumb-url="{{ $oferta->tipo === 'pdf' ? route('marketing.ofertas.thumb', $oferta) : '' }}"
             data-sem-thumb="{{ ($oferta->tipo === 'pdf' && !$oferta->thumb) ? '1' : '0' }}">
            @if($oferta->tipo === 'imagem')
            <img src="{{ Storage::url($oferta->arquivo) }}" alt="{{ $oferta->titulo }}" style="height: 180px; object-fit: cover; border-radius: 10px 10px 0 0;">
            @else
            <img data-thumb-img src="{{ $oferta->thumb ? Storage::url($oferta->thumb) : '/images/default-oferta.jpg' }}" alt="{{ $oferta->titulo }}" style="height: 180px; object-fit: cover; border-radius: 10px 10px 0 0;">
            @endif
            <div class="card-body">
                <h5 class="fw-semibold">{{ $oferta->titulo }}</h5>
                <span class="badge bg-{{ $oferta->tipo === 'imagem' ? 'primary' : 'danger' }}">{{ $oferta->tipo }}</span>
                <span class="badge bg-{{ $cor }}">{{ $status }}</span>
                @if($oferta->data_inicio)
                <div class="mt-1 small text-muted">Início: {{ $oferta->data_inicio->format('d/m/Y') }}</div>
                @endif
                @if($oferta->data_fim)
                <div class="small text-muted">Fim: {{ $oferta->data_fim->format('d/m/Y') }}</div>
                @endif
                <div class="mt-1 small text-muted">Cadastrada em {{ $oferta->created_at->format('d/m/Y') }}</div>
                <div class="mt-2 d-flex gap-1">
                    @if($oferta->tipo === 'pdf')
                    <a href="{{ Storage::url($oferta->arquivo) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="Abrir PDF"><i class="bi bi-file-earmark-pdf"></i></a>
                    @if(!$oferta->thumb)
                    <button type="button" class="btn btn-sm btn-outline-success js-gerar-thumb" title="Gerar thumbnail da 1ª página no navegador"><i class="bi bi-image"></i></button>
                    @endif
                    @endif
                    <a href="{{ route('marketing.ofertas.edit', $oferta) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('marketing.ofertas.destroy', $oferta) }}" method="POST" class="d-inline" onsubmit="return confirm('Remover oferta?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="text-center py-5">
    <i class="bi bi-tag" style="font-size: 3rem; color: #ccc;"></i>
    <p class="mt-2 text-muted">Nenhuma oferta cadastrada.</p>
    <a href="{{ route('marketing.ofertas.create') }}" class="btn btn-success rounded-pill">Criar primeira oferta</a>
</div>
@endif
@endsection

@push('scripts')
<script src="{{ asset('js/pdf-thumb.js') }}"></script>
@endpush
