@php
    $slides = $block->slides ?? collect();
@endphp

@if($slides->count() > 0)
<section class="carrossel-block">
    <div id="carrossel{{ $block->id }}" class="carousel slide carousel-fade" data-bs-ride="carousel">
        @if($slides->count() > 1)
        <div class="carousel-indicators">
            @foreach($slides as $i => $slide)
            <button type="button" data-bs-target="#carrossel{{ $block->id }}" data-bs-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}" aria-current="{{ $i === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $i + 1 }}"></button>
            @endforeach
        </div>
        @endif

        <div class="carousel-inner">
            @foreach($slides as $i => $slide)
            <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                @if($slide->link)
                <a href="{{ $slide->link }}" @if(!str_starts_with($slide->link, '/') && !str_starts_with($slide->link, url(''))) target="_blank" rel="noopener" @endif>
                @endif
                    <img src="{{ Storage::url($slide->imagem) }}" class="d-block w-100 carrossel-img" alt="{{ $slide->titulo ?: $block->titulo }}">
                    @if($slide->titulo)
                    <div class="carousel-caption d-none d-md-block">
                        <h3 class="fw-bold mb-0">{{ $slide->titulo }}</h3>
                    </div>
                    @endif
                @if($slide->link)
                </a>
                @endif
            </div>
            @endforeach
        </div>

        @if($slides->count() > 1)
        <button class="carousel-control-prev" type="button" data-bs-target="#carrossel{{ $block->id }}" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carrossel{{ $block->id }}" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Próximo</span>
        </button>
        @endif
    </div>
</section>
@endif