<section class="block-section light-bg">
    <div class="container">
        <div class="section-title-wrap">
            <h2 class="section-title">{{ $block->titulo ?: 'NOSSAS LOJAS' }}</h2>
            <p class="section-subtitle">{{ $block->conteudo ?: 'Venha nos visitar' }}</p>
        </div>
        <div class="row g-4">
            @foreach($lojas as $loja)
                @include('components.loja-card', ['loja' => $loja])
            @endforeach
        </div>
    </div>
</section>