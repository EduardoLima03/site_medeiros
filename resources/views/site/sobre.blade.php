@extends('layouts.app')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="mb-4" style="color: var(--text-green); font-weight: 700; font-size: 2rem;">
                    {{ $contents['titulo']->content ?? 'Sobre nós' }}
                </h2>
                <p style="font-size: 1.1rem; line-height: 1.8; color: #333;">
                    {!! $contents['texto_1']->content ?? 'O <strong>Mercantil Medeiros LTDA</strong> é uma rede de supermercados comprometida em oferecer produtos de qualidade com preços justos para a população de Fortaleza e região metropolitana.' !!}
                </p>
                <p style="font-size: 1.1rem; line-height: 1.8; color: #333;">
                    {!! $contents['texto_2']->content ?? '' !!}
                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="/images/cesta-frutas.png" alt="Cesta de Frutas" class="img-fluid" style="max-width: 20rem;">
            </div>
        </div>
    </div>
</section>

<section class="py-5" style="background-color: #f0f7f0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="mb-4" style="color: var(--text-green); font-weight: 700; font-size: 2rem;">
                    {{ $contents['acao_social_titulo']->content ?? 'Ação Social' }}
                </h2>
                <p style="font-size: 1.1rem; line-height: 1.8; color: #333;">
                    {!! $contents['acao_social_texto_1']->content ?? '' !!}
                </p>
                <p style="font-size: 1.1rem; line-height: 1.8; color: #333;">
                    {!! $contents['acao_social_texto_2']->content ?? '' !!}
                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="/images/mascote.png" alt="Mascote Medeiros" class="img-fluid" style="max-width: 12rem;">
            </div>
        </div>
    </div>
</section>
@endsection
