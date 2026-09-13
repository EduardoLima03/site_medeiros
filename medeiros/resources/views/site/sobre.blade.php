@extends('layouts.app')

@section('content')
<section class="block-section" style="background: linear-gradient(120deg, var(--dark-green) 0%, var(--primary) 100%);">
    <div class="container text-center text-white py-4">
        <h1 class="fw-black" style="font-size: 2.6rem;">Sobre Nós</h1>
        <p style="opacity: 0.9; font-size: 1.1rem;">Conheça a história do Mercantil Medeiros</p>
    </div>
</section>

<section class="block-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h2 class="section-title">Nossa História</h2>
                <div class="texto-conteudo" style="line-height: 1.9;">
                    <p class="text-muted">O Mercantil Medeiros começou na garagem de casa, em 2016, com a ajuda de amigos e muita dedicação. O que era um pequeno mercadinho de bairro cresceu e hoje é uma rede de supermercados presente em Fortaleza e Pacatuba.</p>
                    <p class="text-muted">Nosso compromisso é oferecer produtos de qualidade pelo menor preço possível, com um atendimento que trata cada cliente como parte da família.</p>
                </div>
                <div class="d-flex gap-4 mt-4">
                    <div>
                        <h3 class="fw-black" style="color: var(--primary);">5</h3>
                        <p class="text-muted fw-semibold mb-0">Lojas</p>
                    </div>
                    <div>
                        <h3 class="fw-black" style="color: var(--primary);">+200</h3>
                        <p class="text-muted fw-semibold mb-0">Colaboradores</p>
                    </div>
                    <div>
                        <h3 class="fw-black" style="color: var(--primary);">2016</h3>
                        <p class="text-muted fw-semibold mb-0">Ano de fundação</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <i class="bi bi-shop" style="font-size: 9rem; color: var(--dark-green);"></i>
            </div>
        </div>
    </div>
</section>
@endsection