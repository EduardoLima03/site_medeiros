@php
    $telefoneLoja = preg_replace('/\D/', '', $loja['telefone']);
    $whatsappLoja = preg_replace('/\D/', '', $loja['whatsapp']);
@endphp
<div class="col-md-6 col-lg-4">
    <div class="card-loja">
        <div class="d-flex align-items-center gap-3 mb-2">
            <i class="bi bi-shop loja-icon"></i>
            <h5 class="mb-0">{{ $loja['nome'] }}</h5>
        </div>
        <p><i class="bi bi-geo-alt me-1"></i>{{ $loja['endereco'] }}</p>
        <div class="loja-contatos">
            <a href="tel:{{ $telefoneLoja }}" class="btn-card-store" title="Ligar para {{ $loja['telefone'] }}"><i class="bi bi-telephone"></i> {{ $loja['telefone'] }}</a>
            <a href="https://wa.me/55{{ $whatsappLoja }}?text={{ rawurlencode('Olá! Vim pelo site do ' . setting('site_name', 'Mercantil Medeiros') . '.') }}" target="_blank" rel="noopener" class="btn-card-store" style="background: #25d366;" title="Falar no WhatsApp"><i class="bi bi-whatsapp"></i> {{ $loja['whatsapp'] }}</a>
        </div>
        <a href="{{ $loja['maps'] }}" target="_blank" rel="noopener" class="btn-card-store"><i class="bi bi-geo"></i> Como chegar</a>
        @if(!empty($loja['compra']))
        <a href="{{ $loja['compra'] }}" target="_blank" rel="noopener" class="btn-card-store mt-2" style="background: var(--primary);"><i class="bi bi-bag"></i> Comprar online</a>
        @endif
    </div>
</div>
