<section class="block-section">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end section-title-wrap">
            <div>
                <h2 class="section-title">{{ $block->titulo ?: 'OFERTAS DA SEMANA' }}</h2>
                <p class="section-subtitle mb-0">Confira as melhores ofertas das nossas lojas</p>
            </div>
            <a href="{{ route('site.ofertas') }}" class="btn-outline-green">Ver todas <i class="bi bi-arrow-right"></i></a>
        </div>

        @if(isset($ofertas) && $ofertas->count() > 0)
        <div class="row g-4">
            @foreach($ofertas->take(8) as $oferta)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card-moderno position-relative">
                    <span class="badge-oferta">Oferta</span>
                    @if($oferta->tipo === 'imagem')
                    <img src="{{ Storage::url($oferta->arquivo) }}" alt="{{ $oferta->titulo }}" style="cursor:pointer;" onclick="abrirImagem('{{ Storage::url($oferta->arquivo) }}', '{{ $oferta->titulo }}')">
                    @else
                    <a href="{{ Storage::url($oferta->arquivo) }}" target="_blank" class="text-decoration-none" style="color:inherit;">
                        <img src="{{ $oferta->thumb ? Storage::url($oferta->thumb) : '/images/default-oferta.jpg' }}" alt="{{ $oferta->titulo }}">
                    </a>
                    @endif
                    <div class="card-body text-center">
                        <p class="fw-bold mb-0" style="color: var(--dark-green);">{{ $oferta->titulo }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <p class="text-muted fs-5">Nenhuma oferta disponível no momento.</p>
        </div>
        @endif
    </div>
</section>