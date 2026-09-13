@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0" style="font-weight: 700;"><i class="bi bi-person-vcard"></i> Currículo de {{ $curriculo->nome }}</h2>
    <div>
        <button class="btn btn-outline-primary rounded-pill px-4" onclick="window.print()"><i class="bi bi-printer"></i> Imprimir</button>
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-4">Voltar</a>
    </div>
</div>

<div class="card card-dashboard">
    <div class="card-body p-4" style="background: #fff;">
        <div class="border-bottom pb-3 mb-3">
            <h3 class="fw-bold mb-1">{{ $curriculo->nome }}</h3>
            <div class="text-muted">
                <i class="bi bi-envelope"></i> {{ $curriculo->email }} &nbsp;|&nbsp;
                <i class="bi bi-telephone"></i> {{ $curriculo->telefone }}
                @if($curriculo->idade) &nbsp;|&nbsp; {{ $curriculo->idade }} anos @endif
            </div>
            @if($curriculo->endereco)
            <div class="text-muted small"><i class="bi bi-geo-alt"></i> {{ $curriculo->endereco }}</div>
            @endif
            @if($curriculo->familia)
            <div class="text-muted small"><i class="bi bi-people"></i> {{ $curriculo->familia }}</div>
            @endif
        </div>

        @php
        $secoes = [
            'Objetivo' => $curriculo->objetivo,
            'Formação / Escolaridade' => $curriculo->formacao,
            'Experiência Profissional' => $curriculo->experiencia_profissional,
            'Observações' => $curriculo->observacao,
        ];
        @endphp
        @foreach($secoes as $titulo => $texto)
        @if($texto)
        <div class="mb-4">
            <h6 class="fw-bold text-uppercase text-success" style="letter-spacing: 0.5px;">{{ $titulo }}</h6>
            <p class="mb-0" style="white-space: pre-line;">{{ $texto }}</p>
        </div>
        @endif
        @endforeach

        @if($curriculo->arquivo)
        <div class="mt-4">
            <a href="{{ route('rh.curriculos.download', $curriculo->id) }}" class="btn btn-success rounded-pill px-4">
                <i class="bi bi-file-earmark-pdf"></i> Baixar PDF original
            </a>
        </div>
        @endif
    </div>
</div>

<style>
    @@media print {
        .sidebar, .btn { display: none !important; }
        .main-content { margin: 0 !important; padding: 0 !important; max-width: 100% !important; }
    }
</style>
@endsection