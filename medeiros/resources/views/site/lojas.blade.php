@extends('layouts.app')

@section('content')
<section class="py-5" style="background-color: var(--dark-green);">
    <div class="container">
        <h2 class="section-title mb-5">
            <span style="font-weight: 300;">{{ str_replace('Nossas ', '', $contents['titulo']->content ?? 'Lojas') }} </span>
            @if(str_starts_with($contents['titulo']->content ?? 'Nossas Lojas', 'Nossas '))Nossas Lojas @else {{ $contents['titulo']->content ?? 'Lojas' }} @endif
        </h2>
        <div class="row g-4 justify-content-center">
            @foreach($lojas as $loja)
            <div class="col-md-6 col-lg-4 d-flex justify-content-center">
                <div class="card-loja">
                    <img src="{{ $loja['imagem'] }}" alt="{{ $loja['nome'] }}" style="width: 100%; height: 15rem; border-radius: 1.6rem; object-fit: cover;">
                    <div class="text-white text-center" style="line-height: 1.6; font-size: 1.2rem;">
                        <h5 class="fw-bold">{{ $loja['nome'] }}</h5>
                        <p class="mb-1">{{ $loja['endereco'] }}</p>
                        <p class="mb-0">{{ $loja['telefone'] }}</p>
                    </div>
                    <a href="{{ $loja['maps'] }}" target="_blank" rel="noopener noreferrer" class="btn-card-store">Como chegar</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@php
    $knownLojas = ['titulo'];
    $extraGroups = [];
    foreach ($contents as $section => $content) {
        if (in_array($section, $knownLojas)) continue;
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
@endsection
