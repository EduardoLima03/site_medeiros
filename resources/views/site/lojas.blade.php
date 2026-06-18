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
@endsection
