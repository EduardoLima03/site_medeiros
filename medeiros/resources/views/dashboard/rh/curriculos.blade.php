@extends('layouts.dashboard')

@section('content')
<h2 class="mb-4" style="font-weight: 700;"><i class="bi bi-file-earmark-person"></i> Currículos Recebidos</h2>

<div class="card card-dashboard">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Candidato</th>
                        <th>Contato</th>
                        <th>Objetivo</th>
                        <th>Recebido em</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($curriculos as $curriculo)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $curriculo->nome }}</div>
                            <small class="text-muted">{{ $curriculo->idade ? $curriculo->idade . ' anos' : '' }}</small>
                        </td>
                        <td>
                            <div class="small">{{ $curriculo->email }}</div>
                            <small class="text-muted">{{ $curriculo->telefone }}</small>
                        </td>
                        <td class="text-muted small">{{ Str::limit($curriculo->objetivo ?? '-', 70) }}</td>
                        <td><span class="small">{{ $curriculo->created_at->format('d/m/Y') }}</span></td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('rh.curriculos.imprimir', $curriculo->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-printer"></i></a>
                            @if($curriculo->arquivo)
                            <a href="{{ route('rh.curriculos.download', $curriculo->id) }}" class="btn btn-sm btn-outline-success"><i class="bi bi-file-earmark-pdf"></i></a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Nenhum currículo cadastrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection