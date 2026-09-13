@extends('layouts.app')

@section('content')
@if($blocks->count() > 0)
    @foreach($blocks as $block)
        @include("components.blocks.{$block->type}", ['block' => $block])
    @endforeach
@else
    @include('components.blocks.banner', ['block' => (object) ['titulo' => 'Bem-vindo', 'conteudo' => 'O supermercado da sua família', 'imagem' => null, 'link' => route('site.ofertas')]])
    @include('components.blocks.ofertas', ['block' => (object) ['titulo' => 'OFERTAS DA SEMANA']])
    @include('components.blocks.mapa', ['block' => (object) ['titulo' => 'NOSSAS LOJAS']])
    @include('components.blocks.vagas', ['block' => (object) ['titulo' => 'TRABALHE CONOSCO']])
    @include('components.blocks.cta_app', ['block' => (object) ['titulo' => 'Baixe o app do Medeiros']])
@endif

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