@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Ofertas</h2>
    <a href="{{ route('marketing.ofertas.create') }}" class="btn btn-success rounded-pill"><i class="bi bi-plus-lg"></i> Nova Oferta</a>
</div>

@if($ofertas->count() > 0)
<div class="row g-3">
    @foreach($ofertas as $oferta)
    @php
        $expirada = $oferta->data_fim && $oferta->data_fim->isPast();
        $vigente = $oferta->ativa && !$expirada;
    @endphp
    <div class="col-md-4">
        <div class="card card-dashboard {{ $expirada ? 'opacity-50' : '' }}">
            @if($oferta->tipo === 'imagem')
            <img src="{{ Storage::url($oferta->arquivo) }}" alt="{{ $oferta->titulo }}" style="height: 180px; object-fit: cover; border-radius: 10px 10px 0 0;">
            @else
            <img src="{{ $oferta->thumb ? Storage::url($oferta->thumb) : '/images/default-oferta.jpg' }}" alt="{{ $oferta->titulo }}" style="height: 180px; object-fit: cover; border-radius: 10px 10px 0 0;">
            @endif
            <div class="card-body">
                <h5 class="fw-semibold">{{ $oferta->titulo }}</h5>
                <span class="badge bg-{{ $oferta->tipo === 'imagem' ? 'primary' : 'danger' }}">{{ $oferta->tipo }}</span>
                <span class="badge bg-{{ $vigente ? 'success' : 'secondary' }}">{{ $vigente ? 'Ativa' : ($expirada ? 'Expirada' : 'Inativa') }}</span>
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
