@extends('layouts.dashboard')

@section('content')
<h2 class="fw-bold mb-2">{{ $vaga->titulo }}</h2>
<p class="text-muted">Candidaturas recebidas — Gerencie o status de cada candidato</p>

@if($candidaturas->count() > 0)
<div class="table-responsive">
    <table class="table table-hover bg-white rounded shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Candidato</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Status</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($candidaturas as $cand)
            <tr>
                <td class="fw-semibold">{{ $cand->user->name }}</td>
                <td>{{ $cand->user->email }}</td>
                <td>{{ $cand->user->telefone }}</td>
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
                    <span class="badge bg-{{ $statusClasses[$cand->status] ?? 'secondary' }}">
                        {{ $statusLabels[$cand->status] ?? $cand->status }}
                    </span>
                </td>
                <td>{{ $cand->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Alterar Status
                        </button>
                        <ul class="dropdown-menu">
                            @foreach(['candidatado', 'analisando', 'selecionado_entrevista', 'recusado'] as $s)
                            @if($s !== $cand->status)
                            <li>
                                <form action="{{ route('rh.candidaturas.status', $cand) }}" method="POST" class="d-inline">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="{{ $s }}">
                                    <button type="submit" class="dropdown-item {{ $s === 'recusado' ? 'text-danger' : ($s === 'selecionado_entrevista' ? 'text-success' : '') }}">
                                        {{ $statusLabels[$s] ?? $s }}
                                    </button>
                                </form>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                    @if($cand->curriculo)
                    <a href="{{ route('rh.curriculos.download', $cand->curriculo) }}" class="btn btn-sm btn-outline-success" title="Download currículo"><i class="bi bi-download"></i></a>
                    <a href="{{ route('rh.curriculos.imprimir', $cand->curriculo) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="Imprimir"><i class="bi bi-printer"></i></a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="text-center py-5">
    <i class="bi bi-people" style="font-size: 3rem; color: #ccc;"></i>
    <p class="mt-2 text-muted">Nenhuma candidatura para esta vaga.</p>
</div>
@endif
<a href="{{ route('rh.vagas') }}" class="btn btn-outline-secondary rounded-pill mt-3"><i class="bi bi-arrow-left"></i> Voltar</a>
@endsection
