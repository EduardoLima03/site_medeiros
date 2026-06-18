@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Meu Painel</h2>
    @if(!$curriculo)
    <a href="{{ route('site.curriculo') }}" class="btn btn-primary rounded-pill"><i class="bi bi-file-earmark-person"></i> Cadastrar Currículo</a>
    @endif
</div>

@if($curriculo)
<div class="card card-dashboard p-4 mb-4">
    <div class="d-flex align-items-start gap-3">
        <i class="bi bi-file-earmark-check text-success" style="font-size: 2.5rem;"></i>
        <div class="w-100">
            <h5 class="fw-bold mb-1">Meu Currículo</h5>
            <p class="text-muted mb-2">Enviado em {{ $curriculo->created_at->format('d/m/Y') }}</p>
            <div class="row g-2 small">
                <div class="col-md-4"><strong>Nome:</strong> {{ $curriculo->nome }}</div>
                <div class="col-md-4"><strong>E-mail:</strong> {{ $curriculo->email }}</div>
                <div class="col-md-4"><strong>Telefone:</strong> {{ $curriculo->telefone }}</div>
                @if($curriculo->endereco)<div class="col-md-4"><strong>Endereço:</strong> {{ $curriculo->endereco }}</div>@endif
                @if($curriculo->idade)<div class="col-md-4"><strong>Idade:</strong> {{ $curriculo->idade }}</div>@endif
                @if($curriculo->sexo)<div class="col-md-4"><strong>Sexo:</strong> {{ $curriculo->sexo }}</div>@endif
                @if($curriculo->familia)<div class="col-md-4"><strong>Família:</strong> {{ $curriculo->familia }}</div>@endif
            </div>
            <a href="{{ route('site.curriculo') }}" class="btn btn-sm btn-outline-primary rounded-pill mt-2">Atualizar Currículo</a>
        </div>
    </div>
</div>
@endif

@if($candidaturas->count() > 0)
<div class="card card-dashboard p-4">
    <h5 class="fw-bold mb-3"><i class="bi bi-briefcase"></i> Minhas Candidaturas</h5>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Vaga</th>
                    <th>Data</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($candidaturas as $cand)
                <tr>
                    <td class="fw-semibold">{{ $cand->vaga->titulo ?? 'Vaga removida' }}</td>
                    <td>{{ $cand->created_at->format('d/m/Y') }}</td>
                    <td>
                        @php
                            $statusClasses = [
                                'candidatado' => 'secondary',
                                'analisando' => 'info',
                                'selecionado_entrevista' => 'success',
                                'recusado' => 'danger',
                            ];
                            $statusLabels = [
                                'candidatado' => 'Candidatado',
                                'analisando' => 'Analisando',
                                'selecionado_entrevista' => 'Selecionado p/ Entrevista',
                                'recusado' => 'Recusado',
                            ];
                        @endphp
                        <span class="badge rounded-pill bg-{{ $statusClasses[$cand->status] ?? 'secondary' }}">
                            {{ $statusLabels[$cand->status] ?? $cand->status }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div class="card card-dashboard p-4 text-center">
    <i class="bi bi-briefcase" style="font-size: 3rem; color: #ccc;"></i>
    <h5 class="mt-2 text-muted">Você ainda não se candidatou a nenhuma vaga</h5>
    <a href="{{ route('site.trabalhe') }}" class="btn btn-primary rounded-pill mt-2">Ver vagas disponíveis</a>
</div>
@endif
@endsection
