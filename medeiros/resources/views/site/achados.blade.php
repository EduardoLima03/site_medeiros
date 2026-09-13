@extends('layouts.app')

@section('content')
<section class="block-section" style="background: linear-gradient(120deg, var(--dark-green) 0%, var(--primary) 100%);">
    <div class="container text-center text-white py-4">
        <h1 class="fw-black" style="font-size: 2.6rem;">ACHADOS E PERDIDOS</h1>
        <p style="opacity: 0.9; font-size: 1.1rem;">Perdeu algo em nossas lojas? Confira se encontramos.</p>
    </div>
</section>

<section class="block-section">
    <div class="container">
        @if($achados->count() > 0)
        <div class="row g-4 justify-content-center">
            @foreach($achados as $achado)
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card-moderno">
                    @if($achado->imagem)
                    <img src="{{ Storage::url($achado->imagem) }}" alt="{{ $achado->titulo }}" style="height: 200px; cursor: pointer;" onclick="abrirImagem('{{ Storage::url($achado->imagem) }}', '{{ $achado->titulo }}')">
                    @else
                    <div class="achado-imagem-vazia"><i class="bi bi-box-seam"></i></div>
                    @endif
                    <div class="card-body">
                        <h5 class="fw-bold" style="color: var(--dark-green);">{{ $achado->titulo }}</h5>
                        <p class="text-muted mb-2" style="font-size: 0.95rem;">{{ $achado->descricao }}</p>
                        <div class="d-flex flex-wrap gap-3 small text-muted">
                            @if($achado->local_encontrado)
                            <span><i class="bi bi-geo-alt"></i> {{ $achado->local_encontrado }}</span>
                            @endif
                            @if($achado->data_encontrado)
                            <span><i class="bi bi-calendar"></i> {{ $achado->data_encontrado->format('d/m/Y') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-search" style="font-size: 3rem; color: #ccc;"></i>
            <p class="mt-2 text-muted fs-5">Nenhum item encontrado no momento. Continue acompanhando!</p>
        </div>
        @endif

        @if(setting('whatsapp') && setting('whatsapp') != '#')
        <div class="text-center mt-5">
            <p class="text-muted">Encontrou seu item? Fale com nossa equipe:</p>
            <a href="{{ setting('whatsapp') }}" target="_blank" class="btn-green"><i class="bi bi-whatsapp me-2"></i> Falar no WhatsApp</a>
        </div>
        @endif
    </div>
</section>

{{-- Lightbox --}}
<div id="lightboxModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); align-items: center; justify-content: center; cursor: pointer;" onclick="fecharImagem()">
    <span style="position: absolute; top: 20px; right: 35px; color: #fff; font-size: 40px; font-weight: bold; cursor: pointer;">&times;</span>
    <img id="lightboxImg" src="" style="max-width: 90%; max-height: 90%; object-fit: contain; border-radius: 8px;">
    <p id="lightboxCaption" style="position: absolute; bottom: 20px; color: #fff; font-size: 1.2rem; text-align: center; width: 100%; padding: 0 1rem;"></p>
</div>
@endsection

@push('scripts')
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
@endpush