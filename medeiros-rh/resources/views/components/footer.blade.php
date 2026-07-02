<footer style="background-color: var(--dark-green);">
    <div class="container py-5">
        <div class="row text-white">
            <div class="col-md-6">
                <h5 class="fw-bold text-white">Medeiros RH</h5>
                <p>Faça parte da nossa equipe! Cadastre seu currículo e concorra às vagas disponíveis.</p>
            </div>
            <div class="col-md-3">
                <h5 class="fw-bold text-white">Links</h5>
                <a href="{{ url('/') }}" class="d-block">Início</a>
                <a href="{{ url('/') }}#vagas" class="d-block">Vagas</a>
            </div>
            <div class="col-md-3">
                <h5 class="fw-bold text-white">Site Principal</h5>
                <a href="{{ env('MAIN_SITE_URL', 'http://localhost:8000') }}" target="_blank">Medeiros Supermercado</a>
            </div>
        </div>
    </div>
    <div class="py-2 text-center" style="background-color: #fff;">
        <small><strong>Medeiros RH</strong> - Sistema de Recrutamento &copy; {{ date('Y') }}</small>
    </div>
</footer>
