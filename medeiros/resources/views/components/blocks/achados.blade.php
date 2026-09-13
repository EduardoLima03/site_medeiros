<section class="block-section light-bg">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end section-title-wrap">
            <div>
                <h2 class="section-title">{{ $block->titulo ?: 'ACHADOS E PERDIDOS' }}</h2>
                <p class="section-subtitle mb-0">Perdeu algo em nossas lojas? Confira se encontramos.</p>
            </div>
            <a href="{{ route('site.achados') }}" class="btn-outline-green">Ver todos <i class="bi bi-arrow-right"></i></a>
        </div>

        @if(isset($achados) && $achados->count() > 0)
        <div class="row g-4">
            @foreach($achados->take(3) as $achado)
            <div class="col-md-4">
                <div class="card-moderno">
                    @if($achado->imagem)
                    <img src="{{ Storage::url($achado->imagem) }}" alt="{{ $achado->titulo }}" style="height: 190px; cursor:pointer;" onclick="abrirImagem('{{ Storage::url($achado->imagem) }}', '{{ $achado->titulo }}')">
                    @else
                    <div class="achado-imagem-vazia"><i class="bi bi-box-seam"></i></div>
                    @endif
                    <div class="card-body">
                        <h6 class="fw-bold" style="color: var(--dark-green);">{{ $achado->titulo }}</h6>
                        <p class="text-muted small mb-2">{{ Str::limit($achado->descricao, 80) }}</p>
                        @if($achado->local_encontrado)
                        <div class="small text-muted"><i class="bi bi-geo-alt"></i> {{ $achado->local_encontrado }}</div>
                        @endif
                        @if($achado->data_encontrado)
                        <div class="small text-muted"><i class="bi bi-calendar"></i> {{ $achado->data_encontrado->format('d/m/Y') }}</div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <p class="text-muted fs-5">Nenhum item encontrado no momento.</p>
        </div>
        @endif
    </div>
</section>