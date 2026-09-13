@extends('layouts.app')

@section('content')
@php
    $categorias = [
        ['nome' => 'Hortifrúti', 'icon' => 'bi-egg-fried'],
        ['nome' => 'Açougue', 'icon' => 'bi-tag'],
        ['nome' => 'Padaria', 'icon' => 'bi-wheat'],
    ];
@endphp
<section class="block-section" style="background: linear-gradient(120deg, var(--dark-green) 0%, var(--primary) 100%);">
    <div class="container text-center text-white py-4">
        <h1 class="fw-black" style="font-size: 2.6rem;">Nossas Lojas</h1>
        <p style="opacity: 0.9; font-size: 1.1rem;">Encontre o Mercantil Medeiros mais perto de você</p>
    </div>
</section>

<section class="block-section">
    <div class="container">
        <div class="row g-4">
            @foreach($lojas as $loja)
            <div class="col-md-6 col-lg-4">
                <div class="card-loja">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <i class="bi bi-shop loja-icon"></i>
                        <h5 class="mb-0">{{ $loja['nome'] }}</h5>
                    </div>
                    <p><i class="bi bi-geo-alt me-1"></i>{{ $loja['endereco'] }}</p>
                    <p><i class="bi bi-telephone me-1"></i>{{ $loja['telefone'] }}</p>
                    <a href="{{ $loja['maps'] }}" target="_blank" rel="noopener" class="btn-card-store"><i class="bi bi-geo"></i> Como chegar</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="block-section light-bg">
    <div class="container text-center">
        <h2 class="section-title d-inline-block mb-4">Departamentos</h2>
        <div class="row g-4 justify-content-center mt-2">
            @foreach($categorias as $cat)
            <div class="col-6 col-md-3">
                <div class="card-moderno p-4 text-center">
                    <i class="bi {{ $cat['icon'] }}" style="font-size: 2.6rem; color: var(--primary);"></i>
                    <p class="fw-bold mt-3 mb-0" style="color: var(--dark-green);">{{ $cat['nome'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection