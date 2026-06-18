@extends('layouts.dashboard')

@section('content')
<h2 class="mb-4" style="font-weight: 700;">Painel RH</h2>
<div class="row g-4">
    <div class="col-md-4">
        <div class="card card-dashboard border-start border-primary border-4">
            <div class="card-body">
                <h5 class="card-title text-muted">Vagas Abertas</h5>
                <h2 class="fw-bold text-primary">{{ $vagasAbertas }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-dashboard border-start border-success border-4">
            <div class="card-body">
                <h5 class="card-title text-muted">Candidaturas</h5>
                <h2 class="fw-bold text-success">{{ $totalCandidaturas }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-dashboard border-start border-info border-4">
            <div class="card-body">
                <h5 class="card-title text-muted">Currículos</h5>
                <h2 class="fw-bold text-info">{{ $totalCurriculos }}</h2>
            </div>
        </div>
    </div>
</div>
<div class="mt-4 d-flex gap-3">
    <a href="{{ route('rh.vagas') }}" class="btn btn-primary rounded-pill px-4"><i class="bi bi-briefcase"></i> Gerenciar Vagas</a>
    <a href="{{ route('rh.curriculos') }}" class="btn btn-info rounded-pill px-4 text-white"><i class="bi bi-file-earmark-person"></i> Ver Currículos</a>
</div>
@endsection
