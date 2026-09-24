<section class="block-section light-bg">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end section-title-wrap">
            <div>
                <h2 class="section-title">{{ $block->titulo ?: 'PROMOÇÕES DO APP' }}</h2>
                <p class="section-subtitle mb-0">{{ $block->conteudo ?: 'As melhores ofertas direto do nosso aplicativo.' }}</p>
            </div>
            <a href="https://www.app.medeirossupermercado.cloud/promocoes?page=4" target="_blank" rel="noopener" class="btn-outline-green">Ver todas no app <i class="bi bi-arrow-right"></i></a>
        </div>

        @if(!empty($promocoes))
        <div class="row g-4">
            @foreach($promocoes as $produto)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card-moderno position-relative">
                    <span class="badge-oferta">Promo</span>
                    <a href="{{ $produto['link'] }}" target="_blank" rel="noopener" class="text-decoration-none" style="color: inherit;">
                        @if($produto['imagem'])
                        <img src="{{ $produto['imagem'] }}" alt="{{ $produto['nome'] }}" loading="lazy">
                        @else
                        <img src="/images/logo.png" alt="{{ $produto['nome'] }}" loading="lazy" style="object-fit: contain; background: #f4f7f3;">
                        @endif
                        <div class="card-body text-center">
                            <p class="fw-bold mb-1" style="color: var(--dark-green);">{{ $produto['nome'] }}</p>
                            @if($produto['preco'])
                            <p class="mb-0 fw-black" style="color: var(--gold);">{{ $produto['preco'] }}</p>
                            @endif
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <p class="text-muted fs-5 mb-3">Sem promoções disponíveis agora — confira as ofertas no nosso app.</p>
            <a href="https://www.app.medeirossupermercado.cloud/promocoes?page=4" target="_blank" rel="noopener" class="btn-outline-green">Ver promoções no app <i class="bi bi-arrow-right"></i></a>
        </div>
        @endif
    </div>
</section>