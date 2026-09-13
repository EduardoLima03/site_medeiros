@extends('layouts.dashboard')

@section('content')
<h2 class="mb-4" style="font-weight: 700;"><i class="bi bi-people"></i> Painel RH</h2>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card card-dashboard border-start border-success border-4">
            <div class="card-body">
                <h6 class="card-title text-muted">Vagas Abertas</h6>
                <h2 class="fw-bold text-success">{{ $vagasAbertas }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-dashboard border-start border-info border-4">
            <div class="card-body">
                <h6 class="card-title text-muted">Candidaturas</h6>
                <h2 class="fw-bold text-info">{{ $totalCandidaturas }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-dashboard border-start border-warning border-4">
            <div class="card-body">
                <h6 class="card-title text-muted">Currículos Cadastrados</h6>
                <h2 class="fw-bold text-warning">{{ $totalCurriculos }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="d-flex flex-wrap gap-2">
    <a href="{{ route('rh.vagas') }}" class="btn btn-primary rounded-pill px-4"><i class="bi bi-briefcase"></i> Gerenciar Vagas</a>
    <a href="{{ route('rh.curriculos') }}" class="btn btn-outline-primary rounded-pill px-4"><i class="bi bi-file-earmark-person"></i> Ver Currículos</a>
</div>
@endsection