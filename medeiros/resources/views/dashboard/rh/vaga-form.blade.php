@extends('layouts.dashboard')

@section('content')
<h2 class="mb-4" style="font-weight: 700;">{{ isset($vaga) ? 'Editar Vaga' : 'Nova Vaga' }}</h2>

<div class="card card-dashboard">
    <div class="card-body">
        <form action="{{ isset($vaga) ? route('rh.vagas.update', $vaga->id) : route('rh.vagas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($vaga)) @method('PUT') @endif

            <div class="mb-3">
                <label class="form-label fw-semibold">Título da vaga *</label>
                <input type="text" name="titulo" value="{{ old('titulo', $vaga->titulo ?? '') }}" class="form-control @error('titulo') is-invalid @enderror" required>
                @error('titulo') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Descrição *</label>
                <textarea name="descricao" rows="6" class="form-control @error('descricao') is-invalid @enderror" required>{{ old('descricao', $vaga->descricao ?? '') }}</textarea>
                @error('descricao') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Imagem (opcional)</label>
                    <input type="file" name="imagem" accept="image/*" class="form-control @error('imagem') is-invalid @enderror">
                    @error('imagem') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    @if(isset($vaga) && $vaga->imagem)
                    <img src="{{ asset('storage/' . $vaga->imagem) }}" alt="Imagem da vaga" class="mt-2 rounded" style="height: 80px; object-fit: cover;">
                    @endif
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Status *</label>
                    <select name="status" class="form-select" required>
                        <option value="aberta" {{ old('status', $vaga->status ?? '') === 'aberta' ? 'selected' : '' }}>Aberta</option>
                        <option value="fechada" {{ old('status', $vaga->status ?? '') === 'fechada' ? 'selected' : '' }}>Fechada</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-success rounded-pill px-4"><i class="bi bi-save"></i> Salvar</button>
            <a href="{{ route('rh.vagas') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancelar</a>
        </form>
    </div>
</div>
@endsection