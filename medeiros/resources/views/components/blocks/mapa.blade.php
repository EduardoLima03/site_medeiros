<section class="block-section light-bg">
    <div class="container">
        <div class="section-title-wrap">
            <h2 class="section-title">{{ $block->titulo ?: 'NOSSAS LOJAS' }}</h2>
            <p class="section-subtitle">{{ $block->conteudo ?: 'Venha nos visitar' }}</p>
        </div>
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