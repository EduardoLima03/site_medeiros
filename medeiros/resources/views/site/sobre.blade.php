@extends('layouts.app')

@push('styles')
<style>
    .timeline { position: relative; padding-left: 4.5rem; }
    .timeline::before {
        content: ''; position: absolute; left: 1.25rem; top: 0.75rem; bottom: 0.75rem;
        width: 4px;
        background: linear-gradient(180deg, var(--gold), var(--primary));
        border-radius: 1rem;
    }
    .timeline-item { position: relative; margin-bottom: 2rem; }
    .timeline-mark {
        display: inline-block; background: var(--dark-green); color: #fff; font-weight: 800;
        text-align: center; padding: 0.45rem 1.2rem; border-radius: 2rem;
        box-shadow: 0 6px 18px rgba(45,80,22,0.28); margin-bottom: 0.6rem;
    }
    .timeline-item:nth-child(odd) .timeline-mark { background: var(--primary); }
    .timeline-item:nth-child(even) .timeline-mark { background: var(--dark-green); }
    .timeline-body {
        background: var(--light-green); border-left: 4px solid var(--gold);
        border-radius: var(--radius); padding: 1.2rem 1.5rem;
        color: #4a4a4a; line-height: 1.8; box-shadow: var(--shadow);
    }

    .cultura-icon {
        display: inline-flex; align-items: center; justify-content: center;
        width: 3.2rem; height: 3.2rem; border-radius: 1rem;
        background: var(--dark-green); color: #fff; font-size: 1.5rem;
        box-shadow: 0 6px 18px rgba(45,80,22,0.25);
    }
    .valor-badge {
        display: inline-flex; align-items: center; gap: 0.4rem;
        background: #fff; color: var(--dark-green); font-weight: 700;
        padding: 0.7rem 1.4rem; border-radius: 2rem; font-size: 0.95rem;
        box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    }
</style>
@endpush

@section('content')
<section class="block-section" style="background: linear-gradient(120deg, var(--dark-green) 0%, var(--primary) 100%);">
    <div class="container text-center text-white py-4">
        <h1 class="fw-black" style="font-size: 2.6rem;">Sobre Nós</h1>
        <p style="opacity: 0.9; font-size: 1.1rem;">A nossa história começa em 1976</p>
    </div>
</section>

<section class="block-section">
    <div class="container">
        <div class="section-title-wrap text-center">
            <h2 class="section-title">Nossa História</h2>
            <p class="section-subtitle">A trajetória da pequena mercearia ao supermercado que conhecemos hoje.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-mark">1976</div>
                        <div class="timeline-body">
                            <p class="mb-0">A pequena mercearia do Zezinho é inaugurada na Rua 26, Nº 120, José Walter. As vendas eram feitas em um ponto alugado, com variedades de produtos vendidos a granel, embalados em pacotes de papel e anotados em cadernetas.</p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-mark">1978</div>
                        <div class="timeline-body">
                            <p class="mb-0">Com a melhora das vendas, o proprietário, na época ainda solteiro, decidiu comprar uma casa e transferir a mercearia, substituindo a caderneta pelo caixa a manivela. Com o passar de alguns anos, contratou três funcionários e acrescentou o serviço de entrega com dois caixas registradores.</p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-mark">1980 a 1982</div>
                        <div class="timeline-body">
                            <p class="mb-0">A mercearia foi se desenvolvendo, ocupando, assim, espaço de duas casas. O proprietário casou-se e sua esposa, Rosemary, que trabalhava na Sapataria Belém, tornou-se fundamental para o desenvolvimento da mercearia, dando início ao serviço.</p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-mark">1991</div>
                        <div class="timeline-body">
                            <p class="mb-0">Passa a ser <strong>Mercantil Medeiros LTDA</strong>, na Av. J, Nº 130, J. Walter, filiada a associações como a <strong>Rede Uni Compras</strong> e <strong>Rede Sul</strong>.</p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-mark">1999</div>
                        <div class="timeline-body">
                            <p class="mb-0">Por necessidade de crescimento e visão de seu filho mais velho, <strong>Tharles Medeiros</strong>, perceberam que teriam que ampliar e passar mais comodidade e variedade de produtos aos seus clientes.</p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-mark">2007</div>
                        <div class="timeline-body">
                            <p class="mb-0">Passa a ser <strong>Medeiros Supermercado</strong>, filiado à associação de supermercados.</p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-mark">2012</div>
                        <div class="timeline-body">
                            <p class="mb-0">Abertura do <strong>Centro de Distribuição</strong> com 1.000m², situado na R. Roque Medeiros, Nº 1151, Mondubim.</p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-mark">2014</div>
                        <div class="timeline-body">
                            <p class="mb-0">O Medeiros Supermercado passa a ser mais amplo e mais moderno, com <strong>1.250m²</strong>. Com mais espaço, qualidade, maior variedade de produtos e serviços, comodidade e atendimento cada vez mais personalizado.</p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-mark">2018</div>
                        <div class="timeline-body">
                            <p class="mb-0">Abertura da <strong>Loja 02</strong> - Filial com 900m², situada na Av. I, Nº 1313, José Walter.</p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-mark">2019</div>
                        <div class="timeline-body">
                            <p class="mb-0">A <strong>Loja 01</strong> (Matriz) recebe mais uma nova fachada. Situada na Av. J, Nº 130, José Walter.</p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-mark">2019</div>
                        <div class="timeline-body">
                            <p class="mb-0">Abertura da <strong>Loja 03</strong> - Filial com 1.100m², situada na Av. XX, Nº 230, Jereissati II.</p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-mark">2022</div>
                        <div class="timeline-body">
                            <p class="mb-0">Abertura da <strong>Loja 04</strong> - Filial com 682m², situada na R. General Rabelo, Nº 447, Siqueira.</p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-mark">2025</div>
                        <div class="timeline-body">
                            <p class="mb-0">Abertura da <strong>Loja 05</strong>, situada na R. Evaldo Braga, Nº 821, Conjunto Palmeiras.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="block-section" style="background: linear-gradient(120deg, var(--dark-green) 0%, var(--primary) 100%);">
    <div class="container">
        <div class="section-title-wrap text-center">
            <h2 class="section-title" style="color: #fff;">Cultura Organizacional</h2>
            <p class="section-subtitle" style="color: rgba(255,255,255,0.85);">Os pilares que guiam o nosso trabalho todos os dias</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card-moderno h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="cultura-icon"><i class="bi bi-bullseye"></i></span>
                            <h3 class="fw-black mb-0" style="color: var(--dark-green);">Nossa Missão</h3>
                        </div>
                        <p class="mb-0" style="line-height: 1.8; color: #4a4a4a;">Oferecer aos clientes um atendimento diferenciado, um mix assertivo de produtos de qualidade a preço justo.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-moderno h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="cultura-icon"><i class="bi bi-eye"></i></span>
                            <h3 class="fw-black mb-0" style="color: var(--dark-green);">Nossa Visão</h3>
                        </div>
                        <p class="mb-0" style="line-height: 1.8; color: #4a4a4a;">Ser reconhecida no estado cearense como supermercado que possui um diferencial em atendimento, com produtos diferenciados e preço justo.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-1">
            <div class="col-12">
                <div class="card-moderno h-100" style="background: rgba(255,255,255,0.12); box-shadow: none; border: 1px solid rgba(255,255,255,0.25);">
                    <div class="card-body p-4 text-center">
                        <h3 class="fw-black mb-4" style="color: #fff;">Nossos Valores</h3>
                        <div class="d-flex flex-wrap justify-content-center gap-3">
                            <span class="valor-badge"><i class="bi bi-check-circle me-1"></i>Simplicidade</span>
                            <span class="valor-badge"><i class="bi bi-heart me-1"></i>Foco em Servir</span>
                            <span class="valor-badge"><i class="bi bi-lightning-charge me-1"></i>Proatividade</span>
                            <span class="valor-badge"><i class="bi bi-people me-1"></i>Colaboração</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection