<section class="block-section texto-block">
    <div class="container">
        <div class="row align-items-center {{ $block->imagem ? '' : 'justify-content-center' }}">
            <div class="{{ $block->imagem ? 'col-lg-7' : 'col-lg-8 text-center' }}">
                <div class="section-title-wrap">
                    @if($block->titulo)
                    <h2 class="section-title">{{ $block->titulo }}</h2>
                    @endif
                </div>
                @if($block->conteudo)
                <div class="texto-conteudo">{!! $block->conteudo !!}</div>
                @endif
                @if($block->link)
                <a href="{{ $block->link }}" class="btn-outline-green mt-3">{{ $block->link ? 'Saiba mais' : '' }}</a>
                @endif
            </div>
            @if($block->imagem)
            <div class="col-lg-5 text-center">
                <img src="{{ Storage::url($block->imagem) }}" class="img-fluid rounded-4 shadow" style="max-height: 320px; object-fit: cover;" alt="{{ $block->titulo }}">
            </div>
            @endif
        </div>
    </div>
</section>