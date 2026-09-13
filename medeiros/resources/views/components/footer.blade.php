@php
    $siteName = setting('site_name', 'Mercantil Medeiros LTDA');
    $instagram = setting('instagram', '#');
    $facebook = setting('facebook', '#');
    $whatsapp = setting('whatsapp', '#');
@endphp

<footer class="pt-5">
    <div class="container">
        <div class="row g-4 pb-4">
            <div class="col-lg-4 footer-col">
                <img src="/images/logo.png" alt="{{ $siteName }}" height="45" class="mb-3" onerror="this.style.display='none'">
                <p style="font-size: 0.92rem; max-width: 20rem;">Um supermercado que começou na garagem de casa e hoje é referência em preço justo e bom atendimento. Mercantil Medeiros, desde sempre ao seu lado.</p>
                <div class="social">
                    @if($facebook != '#')<a href="{{ $facebook }}" target="_blank" rel="noopener"><i class="bi bi-facebook"></i></a>@endif
                    @if($instagram != '#')<a href="{{ $instagram }}" target="_blank" rel="noopener"><i class="bi bi-instagram"></i></a>@endif
                    @if($whatsapp != '#')<a href="{{ $whatsapp }}" target="_blank" rel="noopener"><i class="bi bi-whatsapp"></i></a>@endif
                </div>
            </div>
            <div class="col-lg-4 footer-col">
                <h5>Navegação</h5>
                <a href="{{ route('site.home') }}">Início</a><br>
                <a href="{{ route('site.ofertas') }}">Ofertas</a><br>
                <a href="{{ route('site.achados') }}">Achados e Perdidos</a><br>
                <a href="{{ route('site.lojas') }}">Nossas Lojas</a><br>
                <a href="{{ route('site.sobre') }}">Sobre nós</a><br>
                <a href="{{ route('site.trabalhe') }}">Trabalhe conosco</a>
            </div>
            <div class="col-lg-4 footer-col">
                <h5>Contato</h5>
                @if(setting('telefone'))<a href="tel:{{ preg_replace('/\D/', '', setting('telefone')) }}"><i class="bi bi-telephone me-2"></i>{{ setting('telefone') }}</a><br>@endif
                @if($whatsapp != '#')<a href="{{ $whatsapp }}" target="_blank"><i class="bi bi-whatsapp me-2"></i>WhatsApp</a><br>@endif
                <a href="{{ route('site.lojas') }}"><i class="bi bi-geo-alt me-2"></i>Fortaleza - CE</a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container d-flex flex-wrap justify-content-between align-items-center">
            <span>&copy; {{ date('Y') }} {{ $siteName }}. Todos os direitos reservados.</span>
            <span>Desenvolvido com <i class="bi bi-heart-fill" style="color: var(--gold);"></i></span>
        </div>
    </div>
</footer>