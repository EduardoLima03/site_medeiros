@extends('layouts.dashboard')

@section('content')
<h2 class="fw-bold mb-4">Minhas Candidaturas</h2>

@if($candidaturas->count() > 0)
<div class="table-responsive">
    <table class="table table-hover bg-white rounded shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Vaga</th>
                <th>Status</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            @foreach($candidaturas as $cand)
            <tr>
                <td class="fw-semibold">{{ $cand->vaga->titulo }}</td>
                <td>
                    @php
                        $statusClasses = ['candidatado' => 'secondary', 'analisando' => 'info', 'selecionado_entrevista' => 'success', 'recusado' => 'danger'];
                        $statusLabels = ['candidatado' => 'Candidatado', 'analisando' => 'Analisando', 'selecionado_entrevista' => 'Selecionado p/ Entrevista', 'recusado' => 'Recusado'];
                    @endphp
                    <span class="badge bg-{{ $statusClasses[$cand->status] ?? 'secondary' }}">{{ $statusLabels[$cand->status] ?? $cand->status }}</span>
                </td>
                <td>{{ $cand->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="text-center py-5">
    <i class="bi bi-briefcase" style="font-size: 3rem; color: #ccc;"></i>
    <p class="mt-2 text-muted">Você ainda não se candidatou a nenhuma vaga.</p>
    <a href="{{ url('/') }}#vagas" class="btn btn-primary rounded-pill">Ver vagas disponíveis</a>
</div>
@endif

@if($curriculo)
<div class="mt-4 p-4 bg-white rounded shadow-sm">
    <h5 class="fw-bold">Meu Currículo</h5>
    <p>Currículo cadastrado em {{ $curriculo->created_at->format('d/m/Y') }}</p>
    <a href="{{ route('site.curriculo') }}" class="btn btn-outline-primary rounded-pill">Editar Currículo</a>
</div>
@else
<div class="mt-4 p-4 bg-white rounded shadow-sm">
    <h5 class="fw-bold">Currículo</h5>
    <p class="text-muted">Você ainda não cadastrou seu currículo.</p>
    <a href="{{ route('site.curriculo') }}" class="btn btn-primary rounded-pill">Cadastrar Currículo</a>
</div>
@endif
@endsection
