@extends('layouts.dashboard')

@section('content')
<h2 class="fw-bold mb-4"><i class="bi bi-speedometer2"></i> Painel Administrativo</h2>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card card-dashboard border-start border-4 border-primary">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="fs-1 text-primary"><i class="bi bi-file-earmark-text"></i></div>
                <div>
                    <div class="fw-bold fs-3">{{ $totalPaginas }}</div>
                    <small class="text-muted">Páginas</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-dashboard border-start border-4 border-info">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="fs-1 text-info"><i class="bi bi-layers"></i></div>
                <div>
                    <div class="fw-bold fs-3">{{ $totalSecoes }}</div>
                    <small class="text-muted">Seções</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-dashboard border-start border-4 border-success">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="fs-1 text-success"><i class="bi bi-gear"></i></div>
                <div>
                    <div class="fw-bold fs-3">{{ $totalSettings }}</div>
                    <small class="text-muted">Configurações</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-dashboard border-start border-4 border-warning">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="fs-1 text-warning"><i class="bi bi-people"></i></div>
                <div>
                    <div class="fw-bold fs-3">{{ $totalUsers }}</div>
                    <small class="text-muted">Usuários</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <a href="{{ route('admin.pages') }}" class="text-decoration-none">
            <div class="card card-dashboard p-4 text-center h-100">
                <div class="fs-1 text-primary mb-2"><i class="bi bi-file-earmark-richtext"></i></div>
                <h5 class="fw-bold">Gerenciar Páginas</h5>
                <p class="text-muted small">Edite o conteúdo de todas as páginas do site com editor WYSIWYG</p>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.appearance') }}" class="text-decoration-none">
            <div class="card card-dashboard p-4 text-center h-100">
                <div class="fs-1 text-success mb-2"><i class="bi bi-palette"></i></div>
                <h5 class="fw-bold">Aparência</h5>
                <p class="text-muted small">Personalize as cores do tema e a identidade visual do site</p>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.settings') }}" class="text-decoration-none">
            <div class="card card-dashboard p-4 text-center h-100">
                <div class="fs-1 text-secondary mb-2"><i class="bi bi-gear"></i></div>
                <h5 class="fw-bold">Configurações</h5>
                <p class="text-muted small">Gerencie contato, redes sociais, apps e links do site</p>
            </div>
        </a>
    </div>
</div>
@endsection