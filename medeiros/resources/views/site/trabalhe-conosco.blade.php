@extends('layouts.app')

@section('content')
<section class="block-section" style="background: linear-gradient(120deg, var(--dark-green) 0%, var(--primary) 100%);">
    <div class="container text-center text-white py-4">
        <h1 class="fw-black" style="font-size: 2.6rem;">Trabalhe Conosco</h1>
        <p style="opacity: 0.9; font-size: 1.1rem;">Venha fazer parte do time Medeiros</p>
    </div>
</section>

<section class="block-section">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div>
                <h2 class="section-title">Vagas Abertas</h2>
                <p class="section-subtitle mb-0">Veja as oportunidades disponíveis</p>
            </div>
            <a href="{{ route('site.curriculo') }}" class="btn-green"><i class="bi bi-file-earmark-person me-2"></i>Cadastrar Currículo</a>
        </div>

        @if($vagas->count() > 0)
        <div class="row g-4">
            @foreach($vagas as $vaga)
            <div class="col-md-6 col-lg-4">
                <div class="card-vaga">
                    <span class="vaga-badge mb-2">Aberta</span>
                    @if($vaga->imagem)
                    <img src="{{ asset('storage/' . $vaga->imagem) }}" alt="{{ $vaga->titulo }}" style="height: 140px; width: 100%; object-fit: cover; border-radius: 0.75rem; margin-bottom: 1rem;">
                    @endif
                    <h4 class="mb-2">{{ $vaga->titulo }}</h4>
                    <p>{{ Str::limit($vaga->descricao, 150) }}</p>
@if(isset($vagasCandidatadas[$vaga->id]))
                    <div class="mt-auto d-flex align-items-center gap-2 flex-wrap">
                        <span class="vaga-marcada"><i class="bi bi-check-circle me-1"></i> Você já se candidatou</span>
                        <form action="{{ route('dashboard.candidaturas.destroy', $vagasCandidatadas[$vaga->id]) }}" method="POST" onsubmit="return confirm('Remover sua candidatura para esta vaga?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-remover-vaga"><i class="bi bi-x-circle"></i> remover candidatura</button>
                        </form>
                    </div>
                    @else
                    <a href="{{ route('site.curriculo', ['vaga_id' => $vaga->id]) }}" class="btn-encarte mt-auto align-self-start">Candidatar-se</a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-person-x" style="font-size: 3rem; color: #ccc;"></i>
            <p class="mt-2 text-muted fs-5">Sem vagas abertas no momento. Cadastre seu currículo para ficar disponível!</p>
        </div>
        @endif
    </div>
</section>
@endsection