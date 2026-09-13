@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Achados e Perdidos</h2>
    <a href="{{ route('marketing.achados.create') }}" class="btn btn-success rounded-pill"><i class="bi bi-plus-lg"></i> Novo Item</a>
</div>

@if($achados->count() > 0)
<div class="row g-3">
    @foreach($achados as $achado)
    <div class="col-md-4">
        <div class="card card-dashboard">
            @if($achado->imagem)
            <img src="{{ Storage::url($achado->imagem) }}" alt="{{ $achado->titulo }}" style="height: 180px; object-fit: cover; border-radius: 10px 10px 0 0;">
            @else
            <div class="d-flex align-items-center justify-content-center bg-light" style="height: 180px; border-radius: 10px 10px 0 0;">
                <i class="bi bi-box-seam" style="font-size: 3rem; color: #ccc;"></i>
            </div>
            @endif
            <div class="card-body">
                <h5 class="fw-semibold">{{ $achado->titulo }}</h5>
                <span class="badge bg-{{ $achado->entregue ? 'success' : 'warning' }}">{{ $achado->entregue ? 'Entregue' : 'Disponível' }}</span>
                @if($achado->local_encontrado)
                <div class="mt-1 small text-muted"><i class="bi bi-geo-alt"></i> {{ $achado->local_encontrado }}</div>
                @endif
                @if($achado->data_encontrado)
                <div class="small text-muted"><i class="bi bi-calendar"></i> Encontrado em {{ $achado->data_encontrado->format('d/m/Y') }}</div>
                @endif
                <div class="mt-1 small text-muted">Cadastrada em {{ $achado->created_at->format('d/m/Y') }}</div>
                <div class="mt-2 d-flex gap-1">
                    <a href="{{ route('marketing.achados.edit', $achado) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('marketing.achados.destroy', $achado) }}" method="POST" class="d-inline" onsubmit="return confirm('Remover item?')">
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
    <i class="bi bi-box-seam" style="font-size: 3rem; color: #ccc;"></i>
    <p class="mt-2 text-muted">Nenhum item cadastrado.</p>
    <a href="{{ route('marketing.achados.create') }}" class="btn btn-success rounded-pill">Cadastrar primeiro item</a>
</div>
@endif
@endsection