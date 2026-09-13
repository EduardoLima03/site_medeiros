@extends('layouts.dashboard')

@php
$statusLabels = [
    'candidatado' => ['Candidatado', 'secondary'],
    'analisando' => ['Em análise', 'info'],
    'selecionado_entrevista' => ['Selecionado', 'primary'],
    'recusado' => ['Recusado', 'danger'],
];
@endphp

@section('content')
<h2 class="mb-4" style="font-weight: 700;"><i class="bi bi-person-circle"></i> Minha Área</h2>

<div class="row g-4">
    {{-- Currículo --}}
    <div class="col-md-6">
        <div class="card card-dashboard h-100">
            <div class="card-body">
                <h5 class="fw-bold mb-3"><i class="bi bi-file-earmark-person text-primary"></i> Meu Currículo</h5>
                @if($curriculo)
                <div class="p-3 rounded-3" style="background: #f0fdf4;">
                    <p class="mb-1 fw-semibold">{{ $curriculo->nome }}</p>
                    <p class="text-muted small mb-0">{{ $curriculo->email }} · {{ $curriculo->telefone }}</p>
                    @if($curriculo->arquivo)
                    <div class="mt-2"><a href="#" class="small text-success"><i class="bi bi-download"></i> Ver PDF</a></div>
                    @endif
                </div>
                @else
                <p class="text-muted mb-3">Você ainda não possui currículo cadastrado.</p>
                @endif
                <a href="{{ route('site.curriculo') }}" class="btn {{ $curriculo ? 'btn-outline-primary' : 'btn-success' }} rounded-pill px-4 mt-3">
                    <i class="bi bi-pencil-square"></i> {{ $curriculo ? 'Atualizar Currículo' : 'Cadastrar Currículo' }}
                </a>
            </div>
        </div>
    </div>

    {{-- Vagas Disponíveis --}}
    <div class="col-md-6">
        <div class="card card-dashboard h-100">
            <div class="card-body">
                <h5 class="fw-bold mb-3"><i class="bi bi-briefcase text-success"></i> Vagas Disponíveis</h5>
                <a href="{{ route('site.trabalhe') }}" class="btn btn-outline-success rounded-pill px-4" target="_blank">
                    <i class="bi bi-arrow-right"></i> Ver todas as vagas
                </a>
            </div>
        </div>
    </div>

    {{-- Candidaturas --}}
    <div class="col-12">
        <div class="card card-dashboard">
            <div class="card-body">
                <h5 class="fw-bold mb-3"><i class="bi bi-clipboard2-pulse text-info"></i> Minhas Candidaturas</h5>
                @if($candidaturas->count() > 0)
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr><th>Vaga</th><th>Status</th><th>Data</th></tr>
                        </thead>
                        <tbody>
                            @foreach($candidaturas as $candidatura)
                            @php $statusInfo = $statusLabels[$candidatura->status] ?? ['Candidatado', 'secondary']; @endphp
                            <tr>
                                <td class="fw-semibold">{{ $candidatura->vaga->titulo ?? '—' }}</td>
                                <td><span class="badge bg-{{ $statusInfo[1] }}">{{ $statusInfo[0] }}</span></td>
                                <td class="text-muted small">{{ $candidatura->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted mb-0">Nenhuma candidatura realizada.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection