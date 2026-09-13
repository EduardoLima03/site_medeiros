<section class="block-section green-bg">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end section-title-wrap">
            <div>
                <h2 class="section-title">{{ $block->titulo ?: 'TRABALHE CONOSCO' }}</h2>
                <p class="section-subtitle mb-0">Venha fazer parte do nosso time</p>
            </div>
            <a href="{{ route('site.trabalhe') }}" class="btn-green">Ver vagas <i class="bi bi-arrow-right"></i></a>
        </div>

        @if(isset($vagas) && $vagas->count() > 0)
        <div class="row g-4">
            @foreach($vagas->take(3) as $vaga)
            <div class="col-md-4">
                <div class="card-vaga">
                    <span class="vaga-badge mb-2">Aberta</span>
                    <h4 class="mb-2">{{ $vaga->titulo }}</h4>
                    <p>{{ Str::limit($vaga->descricao, 120) }}</p>
                    <a href="{{ route('site.curriculo', ['vaga_id' => $vaga->id]) }}" class="btn-encarte mt-auto align-self-start">Candidatar-se</a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <p class="text-muted fs-5">Sem vagas abertas no momento.</p>
        </div>
        @endif
    </div>
</section>