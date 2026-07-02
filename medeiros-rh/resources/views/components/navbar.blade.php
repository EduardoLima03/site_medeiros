<nav class="navbar navbar-expand-lg" style="background-color: var(--dark-green);">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="/images/logo.png" alt="Medeiros RH" height="60" onerror="this.style.display='none'; this.parentElement.innerHTML='Medeiros RH'" style="color:#fff;font-weight:700;font-size:1.5rem;text-decoration:none;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="border-color: var(--gold);">
            <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-2">
                <li class="nav-item"><a class="nav-link px-3 py-2 text-white fw-semibold rounded-pill" href="{{ url('/') }}">Início</a></li>
                <li class="nav-item"><a class="nav-link px-3 py-2 text-white fw-semibold rounded-pill" href="{{ url('/') }}#vagas">Vagas</a></li>
            </ul>
            <div class="d-flex align-items-center gap-3">
                @auth
                <a href="{{ route('rh.home') }}" class="btn btn-sm btn-outline-light rounded-pill">Painel</a>
                @else
                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light rounded-pill">Entrar</a>
                <a href="{{ route('register') }}" class="btn btn-sm btn-outline-light rounded-pill">Cadastre-se</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
