@php
    $siteName = setting('site_name', 'Mercantil Medeiros LTDA');
    $instagram = setting('instagram', '#');
    $facebook = setting('facebook', '#');
    $whatsapp = setting('whatsapp', '#');
    $menuItems = json_decode(setting('nav_menu', '[]'), true);
@endphp

<div class="topbar">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-4">
            @if(setting('telefone'))
            <span><i class="bi bi-telephone icon"></i>{{ setting('telefone') }}</span>
            @endif
            <span><i class="bi bi-clock icon"></i>Seg a Sáb: 7h às 21h · Dom: 7h às 12h</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            @auth
            <a href="{{ route('dashboard') }}"><i class="bi bi-person icon"></i>Painel</a>
            @else
            <a href="{{ route('login') }}"><i class="bi bi-person icon"></i>Entrar</a>
            @endauth
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg main-nav sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('site.home') }}">
            <img src="/images/logo.png" alt="{{ $siteName }}" onerror="this.style.display='none'">
            @if(!file_exists(public_path('images/logo.png')))<span class="fw-black fs-4" style="color: var(--dark-green);">Medeiros</span>@endif
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navPrincipal" aria-controls="navPrincipal" aria-expanded="false" aria-label="Abrir menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navPrincipal">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-1">
                @forelse($menuItems as $item)
                <li class="nav-item"><a class="nav-link" href="{{ $item['url'] }}">{{ $item['label'] }}</a></li>
                @empty
                <li class="nav-item"><a class="nav-link" href="{{ route('site.home') }}">Início</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('site.ofertas') }}">Ofertas</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('site.achados') }}">Achados e Perdidos</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('site.lojas') }}">Lojas</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('site.sobre') }}">Sobre nós</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('site.trabalhe') }}">Trabalhe conosco</a></li>
                @endforelse
            </ul>
            <div class="d-flex align-items-center gap-2">
                <a class="nav-cta btn" href="{{ route('site.lojas') }}"><i class="bi bi-geo-alt me-1"></i>Nossas Lojas</a>
            </div>
        </div>
    </div>
</nav>