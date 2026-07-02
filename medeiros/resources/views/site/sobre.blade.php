@extends('layouts.app')

@section('content')
@php
    $knownSections = ['titulo', 'texto_1', 'texto_2', 'acao_social_titulo', 'acao_social_texto_1', 'acao_social_texto_2'];
@endphp

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
                <img src="{{ $contents['imagem_sobre']->content ?? '/images/cesta-frutas.png' }}" alt="Cesta de Frutas" class="img-fluid" style="max-width: 20rem;">
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
                <img src="{{ $contents['imagem_acao_social']->content ?? '/images/mascote.png' }}" alt="Mascote Medeiros" class="img-fluid" style="max-width: 12rem;">
            </div>
        </div>
    </div>
</section>

@php
    $extraGroups = [];
    foreach ($contents as $section => $content) {
        if (in_array($section, $knownSections)) continue;
        if (in_array($section, ['imagem_sobre', 'imagem_acao_social'])) continue;

        $prefix = $section;
        $type = 'texto';

        if (str_contains($section, '_titulo')) {
            $prefix = substr($section, 0, strrpos($section, '_titulo'));
            $type = 'titulo';
        } elseif (str_contains($section, '_subtitulo')) {
            $prefix = substr($section, 0, strrpos($section, '_subtitulo'));
            $type = 'subtitulo';
        } elseif (str_contains($section, '_texto')) {
            $prefix = substr($section, 0, strrpos($section, '_texto'));
            $type = 'texto';
        } elseif (str_contains($section, '_imagem')) {
            $prefix = substr($section, 0, strrpos($section, '_imagem'));
            $type = 'imagem';
        }

        $extraGroups[$prefix][$type][] = $content;
    }
@endphp

@foreach($extraGroups as $group => $types)
@php $hasImage = isset($types['imagem']); @endphp
<section class="py-5" style="background-color: {{ $loop->even ? '#f0f7f0' : '#fff' }};">
    <div class="container">
        <div class="row align-items-center">
            <div class="{{ $hasImage ? 'col-md-6' : 'col-md-6' }}">
                @if(isset($types['titulo']))
                    @foreach($types['titulo'] as $c)
                    <h2 class="mb-4" style="color: var(--text-green); font-weight: 700; font-size: 2rem;">
                        {{ strip_tags($c->content) }}
                    </h2>
                    @endforeach
                @endif
                @if(isset($types['subtitulo']))
                    @foreach($types['subtitulo'] as $c)
                    <h4 class="mb-3" style="color: var(--dark-green); font-weight: 600;">
                        {{ strip_tags($c->content) }}
                    </h4>
                    @endforeach
                @endif
                @if(isset($types['texto']))
                    @foreach($types['texto'] as $c)
                    {!! $c->content !!}
                    @endforeach
                @endif
            </div>
            @if($hasImage)
            <div class="col-md-6 text-center">
                @foreach($types['imagem'] as $c)
                <img src="{{ $c->content }}" alt="{{ $group }}" class="img-fluid" style="max-width: 20rem;">
                @endforeach
            </div>
            @endif
        </div>
    </div>
</section>
@endforeach
@endsection