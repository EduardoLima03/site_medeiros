@php
    use App\Models\SiteSetting;
    $siteName = SiteSetting::where('key', 'site_name')->value('value') ?? 'Mercantil Medeiros LTDA';
    $cnpj = SiteSetting::where('key', 'cnpj')->value('value') ?? '';
    $portfolio = SiteSetting::where('key', 'portfolio_url')->value('value') ?? '#';
    $instagram = SiteSetting::where('key', 'instagram')->value('value') ?? '#';
    $facebook = SiteSetting::where('key', 'facebook')->value('value') ?? '#';
    $phoneCentral = SiteSetting::where('key', 'phone_central')->value('value') ?? '';
    $whatsapp = SiteSetting::where('key', 'whatsapp')->value('value') ?? '#';
    $cadastroUrl = SiteSetting::where('key', 'cadastro_url')->value('value') ?? '#';
@endphp
<footer style="background-color: var(--dark-green);">
    <div class="container py-5">
        <div class="row text-white" style="color: var(--gold);">
            <div class="col-md-3 coluna-footer">
                <img src="/images/logo-site.svg" alt="{{ $siteName }}" style="width: 12rem; height: auto;">
                <div class="d-flex gap-2 mt-2">
                    <a href="{{ $instagram }}" target="_blank"><ion-icon name="logo-instagram" style="font-size: 2rem; color: var(--gold);"></ion-icon></a>
                    <a href="{{ $facebook }}" target="_blank"><ion-icon name="logo-facebook" style="font-size: 2rem; color: var(--gold);"></ion-icon></a>
                </div>
            </div>
            <div class="col-md-3 coluna-footer">
                <h5 class="titulos-footer text-white">Informações</h5>
                <a href="{{ route('site.sobre') }}">Sobre nós</a>
                <a href="{{ route('site.trabalhe') }}">Trabalhe conosco</a>
                <a href="{{ $cadastroUrl }}" target="_blank">Cadastre-se</a>
                <a href="{{ route('site.lojas') }}">Nossas Lojas</a>
            </div>
            <div class="col-md-3 coluna-footer">
                <h5 class="titulos-footer text-white">Fale Conosco</h5>
                <span>{{ $phoneCentral }}</span>
                <a href="{{ $whatsapp }}" target="_blank">WhatsApp</a>
            </div>
            <div class="col-md-3 coluna-footer">
                <h5 class="titulos-footer text-white">Formas de Pagamento</h5>
                <div class="d-flex flex-wrap gap-2" style="max-width: 200px;">
                    <img src="/images/cielo.png" alt="Cielo" class="logo-bandeira">
                    <img src="/images/mastercard.png" alt="Mastercard" class="logo-bandeira">
                    <img src="/images/visa-electron.png" alt="Visa" class="logo-bandeira">
                    <img src="/images/alelo.png" alt="Alelo" class="logo-bandeira">
                    <img src="/images/sodexo.png" alt="Sodexo" class="logo-bandeira">
                    <img src="/images/ticket.png" alt="Ticket" class="logo-bandeira">
                    <img src="/images/vale-card.png" alt="Vale Card" class="logo-bandeira">
                    <img src="/images/vale-shop.png" alt="Vale Shop" class="logo-bandeira">
                    <img src="/images/ben-visa-vale.png" alt="Ben Visa Vale" class="logo-bandeira">
                    <img src="/images/bscash.png" alt="BSCash" class="logo-bandeira">
                    <img src="/images/fort-brasil.png" alt="Fort Brasil" class="logo-bandeira">
                    <img src="/images/greencard.png" alt="Green Card" class="logo-bandeira">
                    <img src="/images/libercard.png" alt="Libercard" class="logo-bandeira">
                    <img src="/images/personalcard.webp" alt="Personal Card" class="logo-bandeira">
                    <img src="/images/uze.jpeg" alt="Uze" class="logo-bandeira">
                    <img src="/images/pagseguro.png" alt="PagSeguro" class="logo-bandeira">
                </div>
            </div>
        </div>
    </div>
    <div class="py-2 text-center" style="background-color: #fff;">
        <small><strong>{{ $siteName }}</strong> - CNPJ: {{ $cnpj }}</small><br>
        <a href="https://github.com/EduardoLima03" target="_blank" rel="noopener noreferrer" style="color: #000; text-decoration: none; font-weight: 500; font-size: 0.85rem;">Desenvolvido por Carlos Lima Dev</a>
    </div>
</footer>
