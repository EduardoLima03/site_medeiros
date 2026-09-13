<section class="block-section">
    <div class="container">
        <div class="cta-app">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h2 class="fw-black mb-2">{{ $block->titulo ?: 'Baixe o app do Medeiros' }}</h2>
                    <p style="opacity: 0.9; max-width: 30rem;">{{ $block->conteudo ?: 'Tenha as ofertas na palma da mão, crie sua lista de compras e economize todos os dias.' }}</p>
                    <div class="app-links mt-3">
                        @if(setting('app_play_store'))
                        <a href="{{ setting('app_play_store') }}" target="_blank" rel="noopener"><i class="bi bi-google-play"></i> Google Play</a>
                        @endif
                        @if(setting('app_app_store'))
                        <a href="{{ setting('app_app_store') }}" target="_blank" rel="noopener"><i class="bi bi-apple"></i> App Store</a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-5 text-center d-none d-lg-block">
                    <i class="bi bi-phone" style="font-size: 7rem; color: var(--gold);"></i>
                </div>
            </div>
        </div>
    </div>
</section>