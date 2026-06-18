@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Vagas</h2>
    <a href="{{ route('rh.vagas.create') }}" class="btn btn-primary rounded-pill"><i class="bi bi-plus-lg"></i> Nova Vaga</a>
</div>

@if($vagas->count() > 0)
<div class="table-responsive">
    <table class="table table-hover bg-white rounded shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Imagem</th>
                <th>Título</th>
                <th>Status</th>
                <th>Candidaturas</th>
                <th>Criada em</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vagas as $vaga)
            <tr>
                <td>
                    <img src="{{ $vaga->imagem ? asset('storage/' . $vaga->imagem) : '/images/default-vaga.jpg' }}" alt="Vaga" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                </td>
                <td class="fw-semibold">{{ $vaga->titulo }}</td>
                <td>
                    <span class="badge bg-{{ $vaga->status === 'aberta' ? 'success' : 'secondary' }}">{{ $vaga->status }}</span>
                </td>
                <td>
                    <a href="{{ route('rh.vagas.candidaturas', $vaga) }}" class="text-decoration-none">
                        {{ $vaga->candidaturas->count() }} candidato(s)
                    </a>
                </td>
                <td>{{ $vaga->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('rh.vagas.edit', $vaga) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('rh.vagas.destroy', $vaga) }}" method="POST" class="d-inline" onsubmit="return confirm('Remover vaga?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="text-center py-5">
    <i class="bi bi-briefcase" style="font-size: 3rem; color: #ccc;"></i>
    <p class="mt-2 text-muted">Nenhuma vaga cadastrada.</p>
    <a href="{{ route('rh.vagas.create') }}" class="btn btn-primary rounded-pill">Criar primeira vaga</a>
</div>
@endif
@endsection
