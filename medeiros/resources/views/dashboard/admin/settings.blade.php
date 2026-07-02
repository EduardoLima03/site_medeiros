@extends('layouts.dashboard')

@section('content')
<h2 class="fw-bold mb-4"><i class="bi bi-gear"></i> Configurações Gerais</h2>

<div class="card card-dashboard p-4">
    <form action="{{ route('admin.settings') }}" method="POST">
        @csrf

        <h5 class="fw-bold mb-3"><i class="bi bi-info-circle"></i> Identidade do Site</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold small">Nome do Site</label>
                <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold small">Descrição</label>
                <input type="text" name="site_description" class="form-control" value="{{ $settings['site_description'] ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold small">CNPJ</label>
                <input type="text" name="cnpj" class="form-control" value="{{ $settings['cnpj'] ?? '' }}">
            </div>
        </div>

        <hr class="my-4">
        <h5 class="fw-bold mb-3"><i class="bi bi-telephone"></i> Contato</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label fw-semibold small">Telefone Central</label>
                <input type="text" name="phone_central" class="form-control" value="{{ $settings['phone_central'] ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold small">Link WhatsApp</label>
                <input type="text" name="whatsapp" class="form-control" value="{{ $settings['whatsapp'] ?? '' }}">
            </div>
        </div>

        <hr class="my-4">
        <h5 class="fw-bold mb-3"><i class="bi bi-share"></i> Redes Sociais</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label fw-semibold small">Instagram</label>
                <input type="text" name="instagram" class="form-control" value="{{ $settings['instagram'] ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold small">Facebook</label>
                <input type="text" name="facebook" class="form-control" value="{{ $settings['facebook'] ?? '' }}">
            </div>
        </div>

        <hr class="my-4">
        <h5 class="fw-bold mb-3"><i class="bi bi-phone"></i> Aplicativos</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold small">Google Play URL</label>
                <input type="text" name="app_play_store" class="form-control" value="{{ $settings['app_play_store'] ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold small">App Store URL</label>
                <input type="text" name="app_app_store" class="form-control" value="{{ $settings['app_app_store'] ?? '' }}">
            </div>
        </div>

        <hr class="my-4">
        <h5 class="fw-bold mb-3"><i class="bi bi-link-45deg"></i> Links Úteis</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label fw-semibold small">URL Portfólio</label>
                <input type="text" name="portfolio_url" class="form-control" value="{{ $settings['portfolio_url'] ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold small">URL Cadastro</label>
                <input type="text" name="cadastro_url" class="form-control" value="{{ $settings['cadastro_url'] ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold small">URL Currículo Drive</label>
                <input type="text" name="curriculo_drive" class="form-control" value="{{ $settings['curriculo_drive'] ?? '' }}">
            </div>
        </div>

        <button type="submit" class="btn btn-primary rounded-pill px-5">
            <i class="bi bi-save"></i> Salvar Configurações
        </button>
    </form>
</div>
@endsection