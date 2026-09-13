<section class="block-section">
    <div class="container">
        <div class="section-title-wrap text-center">
            @if($block->titulo)
            <h2 class="section-title d-inline-block">{{ $block->titulo }}</h2>
            @endif
        </div>
        <img src="{{ Storage::url($block->imagem) }}" class="img-fluid rounded-4 shadow w-100" style="max-height: 420px; object-fit: cover;" alt="{{ $block->titulo }}">
        @if($block->conteudo)
        <p class="text-center text-muted mt-3 mb-0">{{ $block->conteudo }}</p>
        @endif
    </div>
</section>