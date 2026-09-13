@extends('layouts.dashboard')

@php
$statusLabels = [
    'candidatado' => ['Candidatado', 'secondary'],
    'analisando' => ['Em análise', 'info'],
    'selecionado_entrevista' => ['Selecionado p/ entrevista', 'primary'],
    'recusado' => ['Recusado', 'danger'],
];
@endphp

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0" style="font-weight: 700;"><i class="bi bi-people"></i> Candidaturas</h2>
        <a href="{{ route('rh.vagas') }}" class="small text-muted text-decoration-none"><i class="bi bi-arrow-left"></i> Voltar às vagas</a>
    </div>
    <span class="badge bg-light border text-dark fs-6">{{ $vaga->titulo }}</span>
</div>

<div class="card card-dashboard">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Candidato</th>
                        <th>Currículo</th>
                        <th>Status</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($candidaturas as $candidatura)
                    @php
                        $statusInfo = $statusLabels[$candidatura->status] ?? ['Candidatado', 'secondary'];
                        $fullName = $candidatura->user->name ?? $candidatura->curriculo->nome ?? '—';
                        $email = $candidatura->user->email ?? $candidatura->curriculo->email ?? '—';
                    @endphp
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $fullName }}</div>
                            <small class="text-muted">{{ $email }}</small>
                        </td>
                        <td>
                            @if($candidatura->curriculo)
                            <a href="{{ route('rh.curriculos.imprimir', $candidatura->curriculo->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-printer"></i> Ver curriculo</a>
                            @else
                            <span class="text-muted small">—</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('rh.candidaturas.status', $candidatura->id) }}" method="POST" class="d-flex gap-2">
                                @csrf @method('PUT')
                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    @foreach($statusLabels as $value => $label)
                                    <option value="{{ $value }}" {{ $candidatura->status === $value ? 'selected' : '' }}>{{ $label[0] }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="text-end">
                            <span class="badge bg-{{ $statusInfo[1] }}">{{ $statusInfo[0] }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Nenhuma candidatura para esta vaga.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection