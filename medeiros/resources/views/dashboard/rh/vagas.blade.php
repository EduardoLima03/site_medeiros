@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0" style="font-weight: 700;"><i class="bi bi-briefcase"></i> Vagas</h2>
    <a href="{{ route('rh.vagas.create') }}" class="btn btn-success rounded-pill px-4"><i class="bi bi-plus-lg"></i> Nova Vaga</a>
</div>

<div class="card card-dashboard">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Vaga</th>
                        <th>Status</th>
                        <th>Candidaturas</th>
                        <th>Criada por</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vagas as $vaga)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $vaga->titulo }}</div>
                            <small class="text-muted">{{ Str::limit($vaga->descricao, 60) }}</small>
                        </td>
                        <td>
                            @if($vaga->status === 'aberta')
                            <span class="badge bg-success">Aberta</span>
                            @else
                            <span class="badge bg-secondary">Fechada</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('rh.vagas.candidaturas', $vaga->id) }}" class="fw-semibold text-decoration-none">{{ $vaga->candidaturas_count ?? 0 }}</a>
                        </td>
                        <td class="text-muted small">{{ $vaga->user->name ?? '-' }}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('rh.vagas.edit', $vaga->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('rh.vagas.destroy', $vaga->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Remover esta vaga?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Nenhuma vaga cadastrada.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection