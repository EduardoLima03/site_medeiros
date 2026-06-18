@extends('layouts.app')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-md-6">
                <h2 style="color: var(--text-green); font-weight: 700; font-size: 2.2rem;" class="mb-3">
                    {{ $contents['titulo']->content ?? 'Trabalhe conosco' }}
                </h2>
                <p style="font-size: 1.1rem; line-height: 1.8; color: #333;">
                    {!! $contents['texto_1']->content ?? '' !!}
                </p>
                <p>{!! $contents['texto_2']->content ?? '' !!}</p>
                @auth
                    @if(auth()->user()->role === 'client')
                    <a href="{{ route('site.curriculo') }}" class="btn-encarte d-inline-flex" style="width: auto; padding: 0.5rem 2rem; font-size: 1rem;">
                        Cadastrar Currículo
                    </a>
                    @endif
                @else
                <a href="{{ route('register') }}" class="btn-encarte d-inline-flex" style="width: auto; padding: 0.5rem 2rem; font-size: 1rem;">
                    Cadastre-se agora
                </a>
                @endauth
            </div>
            <div class="col-md-6 text-center">
                <img src="/images/trabalhe-conosco.jpg" alt="Trabalhe Conosco" class="img-fluid" style="border-radius: 1rem; max-width: 25rem;">
            </div>
        </div>

        @if($vagas->count() > 0)
        <h3 class="mb-4" style="color: var(--dark-green); font-weight: 600;">Vagas disponíveis</h3>
        <div class="row g-4 justify-content-center">
            @foreach($vagas as $vaga)
            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
                <div class="card-vaga">
                    <img src="{{ $vaga->imagem ? asset('storage/' . $vaga->imagem) : '/images/default-vaga.jpg' }}" alt="{{ $vaga->titulo }}" style="width: 100%; height: 140px; object-fit: cover; border-radius: 10px;">
                    <h4>{{ $vaga->titulo }}</h4>
                    <p class="text-white small flex-grow-1">{{ Str::limit($vaga->descricao, 150) }}</p>
                    <div class="text-center mt-auto">
                        @auth
                            @if(auth()->user()->role === 'client')
                            <a href="{{ route('site.curriculo') }}?vaga_id={{ $vaga->id }}" class="btn btn-sm rounded-pill px-3" style="background-color: var(--gold); color: #fff; border: none;">Candidatar-se</a>
                            @endif
                        @else
                        <a href="{{ route('register') }}" class="btn btn-sm rounded-pill px-3" style="background-color: var(--gold); color: #fff; border: none;">Candidatar-se</a>
                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <h4 style="color: #666;">{{ $contents['sem_vagas']->content ?? 'Sem vagas abertas no momento.' }}</h4>
            <p style="color: #999;">{{ $contents['sem_vagas_sub']->content ?? '' }}</p>
        </div>
        @endif
    </div>
</section>
@endsection
