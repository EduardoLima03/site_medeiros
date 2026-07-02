@php
    use App\Models\SiteSetting;
    $siteName = SiteSetting::where('key', 'site_name')->value('value') ?? 'Mercantil Medeiros LTDA';
    $instagram = SiteSetting::where('key', 'instagram')->value('value') ?? '#';
    $facebook = SiteSetting::where('key', 'facebook')->value('value') ?? '#';
    $whatsapp = SiteSetting::where('key', 'whatsapp')->value('value') ?? '#';
    $menuItems = json_decode(SiteSetting::where('key', 'nav_menu')->value('value') ?? '[]', true);
@endphp
<nav class="navbar navbar-expand-lg" style="background-color: var(--dark-green);">
    <div class="container">
        <a class="navbar-brand" href="{{ route('site.home') }}">
            <img src="/images/logo.png" alt="{{ $siteName }}" height="60">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="border-color: var(--gold);">
            <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-2">
                @forelse($menuItems as $item)
                <li class="nav-item"><a class="nav-link px-3 py-2 text-white fw-semibold rounded-pill" href="{{ $item['url'] }}">{{ $item['label'] }}</a></li>
                @empty
                <li class="nav-item"><a class="nav-link px-3 py-2 text-white fw-semibold rounded-pill" href="{{ route('site.home') }}">Início</a></li>
                <li class="nav-item"><a class="nav-link px-3 py-2 text-white fw-semibold rounded-pill" href="{{ route('site.ofertas') }}">Ofertas</a></li>
                <li class="nav-item"><a class="nav-link px-3 py-2 text-white fw-semibold rounded-pill" href="{{ route('site.lojas') }}">Lojas</a></li>
                <li class="nav-item"><a class="nav-link px-3 py-2 text-white fw-semibold rounded-pill" href="{{ route('site.sobre') }}">Sobre nós</a></li>
                <li class="nav-item"><a class="nav-link px-3 py-2 text-white fw-semibold rounded-pill" href="{{ env('RH_SITE_URL', 'http://localhost:8001') }}" target="_blank">Trabalhe conosco</a></li>
                @endforelse
            </ul>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer" class="text-white" style="font-size: 1.5rem;"><ion-icon name="logo-instagram"></ion-icon></a>
                <a href="{{ $facebook }}" target="_blank" rel="noopener noreferrer" class="text-white" style="font-size: 1.5rem;"><ion-icon name="logo-facebook"></ion-icon></a>
                <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="text-white" style="font-size: 1.5rem;"><ion-icon name="logo-whatsapp"></ion-icon></a>
                @auth
                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-light rounded-pill">Painel</a>
                @else
                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light rounded-pill">Entrar</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
