@extends('layouts.dashboard')

@section('content')
<h2 class="fw-bold mb-4">Configurações do Site</h2>

<div class="row g-4">
    <!-- Cores -->
    <div class="col-md-6">
        <div class="card card-dashboard p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-palette"></i> Cores do Tema</h5>
            <form action="{{ route('admin.settings') }}" method="POST">
                @csrf
                @foreach(['primary_color' => 'Cor Primária', 'secondary_color' => 'Cor Secundária', 'text_color' => 'Cor do Texto', 'dark_green' => 'Verde Escuro', 'gold' => 'Dourado'] as $key => $label)
                <div class="mb-2 d-flex align-items-center gap-3">
                    <label class="fw-semibold" style="min-width: 120px;">{{ $label }}</label>
                    <input type="color" name="{{ $key }}" value="{{ $settings[$key] ?? '#6ec1e4' }}" class="form-control form-control-color w-auto">
                    <input type="text" name="{{ $key }}" value="{{ $settings[$key] ?? '#6ec1e4' }}" class="form-control form-control-sm" style="width: 100px; font-size: 0.8rem;">
                </div>
                @endforeach
                <button type="submit" class="btn btn-primary rounded-pill mt-3"><i class="bi bi-save"></i> Salvar Cores</button>
            </form>
        </div>
    </div>

    <!-- Textos -->
    <div class="col-md-6">
        <div class="card card-dashboard p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-text-paragraph"></i> Conteúdo das Páginas</h5>
            <form action="{{ route('admin.content') }}" method="POST">
                @csrf
                <input type="hidden" name="section" value="editar">
                <div class="mb-2">
                    <label class="fw-semibold">Página</label>
                    <select name="page" class="form-select" id="pageSelect">
                        <option value="home">Home</option>
                        <option value="sobre">Sobre</option>
                        <option value="ofertas">Ofertas</option>
                        <option value="trabalhe_conosco">Trabalhe Conosco</option>
                        <option value="global">Global (Footer)</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label class="fw-semibold">Seção</label>
                    <select name="section" class="form-select" id="sectionSelect">
                        @php
                            $sections = [
                                'home' => ['banner_titulo', 'encarte_titulo', 'encarte_subtitulo', 'ofertas_titulo', 'ofertas_badge'],
                                'sobre' => ['titulo', 'texto_1', 'texto_2', 'acao_social_titulo', 'acao_social_texto_1', 'acao_social_texto_2'],
                                'ofertas' => ['titulo', 'badge'],
                                'trabalhe_conosco' => ['titulo', 'texto_1', 'texto_2', 'sem_vagas', 'sem_vagas_sub'],
                                'global' => ['footer_info_titulo', 'footer_contato_titulo', 'footer_pagamento_titulo', 'footer_copyright', 'footer_dev'],
                            ];
                        @endphp
                        @foreach($sections as $page => $secs)
                            @foreach($secs as $sec)
                            <option value="{{ $sec }}" data-page="{{ $page }}">{{ $sec }}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                    <label class="fw-semibold">Conteúdo</label>
                    <textarea name="content" class="form-control" rows="4" id="contentTextarea"></textarea>
                    <small class="text-muted">Você pode usar HTML básico (&lt;strong&gt;, &lt;p&gt;, etc)</small>
                </div>
                <button type="submit" class="btn btn-primary rounded-pill mt-2"><i class="bi bi-save"></i> Salvar Conteúdo</button>
            </form>
        </div>
    </div>

    <!-- Configurações Gerais -->
    <div class="col-md-12">
        <div class="card card-dashboard p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-gear"></i> Configurações Gerais</h5>
            <form action="{{ route('admin.settings') }}" method="POST">
                @csrf
                <div class="row g-3">
                    @foreach(['site_name' => 'Nome do Site', 'site_description' => 'Descrição', 'phone_central' => 'Telefone Central', 'whatsapp' => 'Link WhatsApp', 'instagram' => 'Link Instagram', 'facebook' => 'Link Facebook', 'app_play_store' => 'Google Play URL', 'app_app_store' => 'App Store URL', 'cnpj' => 'CNPJ', 'portfolio_url' => 'URL Portfólio', 'cadastro_url' => 'URL Cadastro', 'curriculo_drive' => 'URL Currículo Drive'] as $key => $label)
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">{{ $label }}</label>
                        <input type="text" name="{{ $key }}" class="form-control form-control-sm" value="{{ $settings[$key] ?? '' }}">
                    </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary rounded-pill mt-3"><i class="bi bi-save"></i> Salvar Configurações</button>
            </form>
        </div>
    </div>
</div>

<script>
const sections = @json($sections);
document.getElementById('pageSelect')?.addEventListener('change', function() {
    const page = this.value;
    const select = document.getElementById('sectionSelect');
    select.innerHTML = '';
    (sections[page] || []).forEach(sec => {
        const opt = document.createElement('option');
        opt.value = sec;
        opt.textContent = sec;
        select.appendChild(opt);
    });
    select.dispatchEvent(new Event('change'));
});
document.getElementById('sectionSelect')?.addEventListener('change', function() {
    const page = document.getElementById('pageSelect').value;
    const section = this.value;
    fetch(`/dashboard/admin/content-json?page=${page}&section=${section}`)
        .then(r => r.json())
        .then(data => {
            document.getElementById('contentTextarea').value = data.content || '';
        })
        .catch(() => {});
});
document.getElementById('pageSelect')?.dispatchEvent(new Event('change'));
</script>
@endsection
