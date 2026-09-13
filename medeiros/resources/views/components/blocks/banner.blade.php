<section class="hero-block" style="background-color: var(--dark-green);{{ $block->imagem ? ' background-image: url('.Storage::url($block->imagem).');' : '' }}">
    <div class="container">
        <div class="hero-content">
            @if($block->titulo)
            <span class="hero-tag">{{ $block->titulo }}</span>
            @endif
            @if($block->conteudo)
            <h1>{!! $block->conteudo !!}</h1>
            @endif
            @if($block->link)
            <a href="{{ $block->link }}" class="btn-encarte mt-3"><i class="bi bi-bag me-2"></i>Ver Ofertas</a>
            @endif
        </div>
    </div>
</section>