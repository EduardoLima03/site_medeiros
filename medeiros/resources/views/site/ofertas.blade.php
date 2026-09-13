@extends('layouts.app')

@section('content')
<section class="block-section" style="background: linear-gradient(120deg, var(--dark-green) 0%, var(--primary) 100%);">
    <div class="container text-center text-white py-4">
        <h1 class="fw-black" style="font-size: 2.6rem;">OFERTAS</h1>
        <p style="opacity: 0.9; font-size: 1.1rem;">Confira as ofertas da semana e economize</p>
    </div>
</section>

<section class="block-section">
    <div class="container">
        @if($ofertas->count() > 0)
        <div class="row g-4">
            @foreach($ofertas as $oferta)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card-moderno position-relative">
                    <span class="badge-oferta">Oferta</span>
                    @if($oferta->tipo === 'imagem')
                    <img src="{{ Storage::url($oferta->arquivo) }}" alt="{{ $oferta->titulo }}" style="cursor:pointer;" onclick="abrirImagem('{{ Storage::url($oferta->arquivo) }}', '{{ $oferta->titulo }}')">
                    @else
                    <a href="{{ Storage::url($oferta->arquivo) }}" target="_blank" class="text-decoration-none" style="color: inherit;">
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
            <i class="bi bi-bag-x" style="font-size: 3rem; color: #ccc;"></i>
            <p class="mt-2 text-muted fs-5">Nenhuma oferta disponível no momento.</p>
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