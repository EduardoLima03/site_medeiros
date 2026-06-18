@extends('layouts.app')

@section('content')
<!-- Carrossel -->
<div id="carouselHome" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselHome" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#carouselHome" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#carouselHome" data-bs-slide-to="2"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="/images/slider0.jpeg" class="d-block w-100" alt="Ofertas" style="max-height: 500px; object-fit: cover;">
        </div>
        <div class="carousel-item">
            <img src="/images/slider1.png" class="d-block w-100" alt="Promoções" style="max-height: 500px; object-fit: cover;">
        </div>
        <div class="carousel-item">
            <img src="/images/slider2.png" class="d-block w-100" alt="Medeiros" style="max-height: 500px; object-fit: cover;">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselHome" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselHome" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Próximo</span>
    </button>
</div>

<!-- Baixe nosso App -->
<section class="secao-baixe-app">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-4 text-center">
                <p class="paragrafo-app mb-0">{{ $contents['banner_titulo']->content ?? 'FAÇA SUAS COMPRAS NO MEDEIROS SUPERMERCADO SEM SAIR DE CASA' }}</p>
            </div>
            <div class="col-md-4 text-center">
                <a href="{{ $settings['app_play_store'] ?? '#' }}" target="_blank" rel="noopener noreferrer">
                    <img src="/images/play-store.png" alt="Google Play" style="width: 6rem;" class="me-3">
                </a>
                <a href="{{ $settings['app_app_store'] ?? '#' }}" target="_blank" rel="noopener noreferrer">
                    <img src="/images/app-store.png" alt="App Store" style="width: 6rem;">
                </a>
            </div>
            <div class="col-md-4 text-center">
                <img src="/images/mascote.png" alt="Mascote" style="width: 6rem;">
            </div>
        </div>
    </div>
</section>

<!-- Encartes -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="titulo-encarte mb-0">{{ $contents['encarte_titulo']->content ?? 'BAIXE NOSSO ENCARTE' }}</p>
                <h2 class="subtitulo-encartes">{{ $contents['encarte_subtitulo']->content ?? 'Confira os nossos encartes de oferta!' }}</h2>
                <a href="{{ route('site.ofertas') }}" class="btn-encarte mt-3 d-inline-flex">VER ENCARTE</a>
            </div>
            <div class="col-md-6 text-center">
                <img src="/images/mascote-encarte.png" alt="Mascote Encarte" class="img-fluid" style="max-width: 22rem;">
            </div>
        </div>
    </div>
</section>

<!-- Ofertas da Semana -->
<section class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="d-flex align-items-center gap-3 mb-4">
            <h2 class="mb-0" style="color: var(--text-green); font-weight: 700; font-size: 2rem;">
                {{ $contents['ofertas_titulo']->content ?? 'OFERTAS DA SEMANA' }}
            </h2>
            @if(($contents['ofertas_badge']->content ?? '') === 'GRÁTIS')
            <span class="badge" style="background-color: #ce1f1f; font-size: 1rem;">GRÁTIS</span>
            @endif
        </div>
        @if($ofertas->count() > 0)
        <div class="row g-3">
            @foreach($ofertas as $oferta)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="oferta-card">
                    @if($oferta->tipo === 'imagem')
                    <img src="{{ Storage::url($oferta->arquivo) }}" alt="{{ $oferta->titulo }}">
                    @else
                    <div class="p-4 text-center bg-light" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                        <a href="{{ Storage::url($oferta->arquivo) }}" target="_blank" class="fw-bold" style="color: var(--dark-green);">
                            <i class="bi bi-filetype-pdf" style="font-size: 3rem; display: block;"></i>
                            {{ $oferta->titulo }}
                        </a>
                    </div>
                    @endif
                    <div class="oferta-card-body p-3 text-center">
                        <p class="fw-semibold mb-0">{{ $oferta->titulo }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-4">
            <p style="color: #999; font-size: 1.1rem;">Nenhuma oferta disponível no momento.</p>
        </div>
        @endif
    </div>
</section>
@endsection
