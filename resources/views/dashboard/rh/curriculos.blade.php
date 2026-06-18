@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Currículos Cadastrados</h2>
</div>

@if($curriculos->count() > 0)
<div class="table-responsive">
    <table class="table table-hover bg-white rounded shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Idade</th>
                <th>Sexo</th>
                <th>Objetivo</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($curriculos as $curriculo)
            <tr>
                <td class="fw-semibold">{{ $curriculo->nome }}</td>
                <td>{{ $curriculo->email }}</td>
                <td>{{ $curriculo->telefone }}</td>
                <td>{{ $curriculo->idade ?? '-' }}</td>
                <td>{{ $curriculo->sexo ?? '-' }}</td>
                <td>{{ Str::limit($curriculo->objetivo, 60) ?? '-' }}</td>
                <td>{{ $curriculo->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('rh.curriculos.download', $curriculo) }}" class="btn btn-sm btn-outline-success" title="Download PDF"><i class="bi bi-download"></i></a>
                    <a href="{{ route('rh.curriculos.imprimir', $curriculo) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="Imprimir"><i class="bi bi-printer"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="text-center py-5">
    <i class="bi bi-file-earmark-person" style="font-size: 3rem; color: #ccc;"></i>
    <p class="mt-2 text-muted">Nenhum currículo cadastrado.</p>
</div>
@endif
@endsection
