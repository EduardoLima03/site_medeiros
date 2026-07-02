@extends('layouts.app')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-center gap-3 mb-5">
            <h2 class="mb-0" style="color: var(--text-green); font-weight: 700; font-size: 2.2rem;">
                {{ $contents['titulo']->content ?? 'OFERTAS DA SEMANA' }}
            </h2>
            @if(($contents['badge']->content ?? '') === 'GRÁTIS')
            <span class="badge" style="background-color: #ce1f1f; font-size: 1.2rem; padding: 0.5rem 1rem;">GRÁTIS</span>
            @endif
        </div>
        @if($ofertas->count() > 0)
        <div class="row g-4">
            @foreach($ofertas as $oferta)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="oferta-card">
                    @if($oferta->tipo === 'imagem')
                    <img src="{{ Storage::url($oferta->arquivo) }}" alt="{{ $oferta->titulo }}" style="cursor: pointer;" onclick="abrirImagem('{{ Storage::url($oferta->arquivo) }}', '{{ $oferta->titulo }}')">
                    @else
                    <a href="{{ Storage::url($oferta->arquivo) }}" target="_blank" style="text-decoration: none; color: inherit;">
                        <img src="{{ $oferta->thumb ? Storage::url($oferta->thumb) : '/images/default-oferta.jpg' }}" alt="{{ $oferta->titulo }}" style="width: 100%; height: 200px; object-fit: cover;">
                    </a>
                    @endif
                    <div class="p-3 text-center">
                        <p class="fw-semibold mb-0">{{ $oferta->titulo }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <p style="color: #999; font-size: 1.2rem;">Nenhuma oferta disponível no momento.</p>
        </div>
        @endif
    </div>
</section>

@php
    $knownOfertas = ['titulo', 'badge'];
    $extraGroups = [];
    foreach ($contents as $section => $content) {
        if (in_array($section, $knownOfertas)) continue;
        $prefix = $section; $type = 'texto';
        if (str_contains($section, '_titulo')) { $prefix = substr($section, 0, strrpos($section, '_titulo')); $type = 'titulo'; }
        elseif (str_contains($section, '_subtitulo')) { $prefix = substr($section, 0, strrpos($section, '_subtitulo')); $type = 'subtitulo'; }
        elseif (str_contains($section, '_texto')) { $prefix = substr($section, 0, strrpos($section, '_texto')); $type = 'texto'; }
        elseif (str_contains($section, '_imagem')) { $prefix = substr($section, 0, strrpos($section, '_imagem')); $type = 'imagem'; }
        $extraGroups[$prefix][$type][] = $content;
    }
@endphp
@foreach($extraGroups as $types)
@php $hasImage = isset($types['imagem']); @endphp
<section class="py-5" style="background-color: #f0f7f0;">
    <div class="container"><div class="row align-items-center">
        <div class="{{ $hasImage ? 'col-md-6' : 'col-md-6' }}">
        @if(isset($types['titulo']))
            @foreach($types['titulo'] as $c) <h2 class="mb-4" style="color: var(--text-green); font-weight: 700; font-size: 2rem;">{{ strip_tags($c->content) }}</h2> @endforeach
        @endif
        @if(isset($types['subtitulo']))
            @foreach($types['subtitulo'] as $c) <h4 class="mb-3" style="color: var(--dark-green); font-weight: 600;">{{ strip_tags($c->content) }}</h4> @endforeach
        @endif
        @if(isset($types['texto']))
            @foreach($types['texto'] as $c) {!! $c->content !!} @endforeach
        @endif
        </div>
        @if($hasImage)
        <div class="col-md-6 text-center">
            @foreach($types['imagem'] as $c) <img src="{{ $c->content }}" class="img-fluid" style="max-width: 20rem;"> @endforeach
        </div>
        @endif
    </div></div>
</section>
@endforeach

<!-- Lightbox Modal -->
<div id="lightboxModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); align-items: center; justify-content: center; cursor: pointer;" onclick="fecharImagem()">
    <span style="position: absolute; top: 20px; right: 35px; color: #fff; font-size: 40px; font-weight: bold; cursor: pointer;">&times;</span>
    <img id="lightboxImg" src="" style="max-width: 90%; max-height: 90%; object-fit: contain; border-radius: 8px;">
    <p id="lightboxCaption" style="position: absolute; bottom: 20px; color: #fff; font-size: 1.2rem; text-align: center; width: 100%; padding: 0 1rem;"></p>
</div>

<script>
function abrirImagem(src, titulo) {
    document.getElementById('lightboxImg').src = src;
    document.getElementById('lightboxCaption').textContent = titulo;
    document.getElementById('lightboxModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function fecharImagem() {
    document.getElementById('lightboxModal').style.display = 'none';
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') fecharImagem();
});
</script>
@endsection