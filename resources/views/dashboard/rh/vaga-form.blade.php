@extends('layouts.dashboard')

@section('content')
<h2 class="fw-bold mb-4">{{ isset($vaga) ? 'Editar Vaga' : 'Nova Vaga' }}</h2>

<form action="{{ isset($vaga) ? route('rh.vagas.update', $vaga) : route('rh.vagas.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($vaga)) @method('PUT') @endif

    <div class="card card-dashboard p-4">
        <div class="mb-3">
            <label class="form-label fw-semibold">Título da Vaga *</label>
            <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror" value="{{ old('titulo', $vaga->titulo ?? '') }}" required>
            @error('titulo') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Descrição *</label>
            <textarea name="descricao" class="form-control @error('descricao') is-invalid @enderror" rows="6" required>{{ old('descricao', $vaga->descricao ?? '') }}</textarea>
            @error('descricao') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Imagem da Vaga</label>
            <input type="file" name="imagem" class="form-control @error('imagem') is-invalid @enderror" accept="image/*">
            <small class="text-muted">Caso não envie, será usada uma imagem padrão. Formatos: JPEG, PNG, JPG, GIF, WebP. Máx: 2MB</small>
            @error('imagem') <div class="invalid-feedback">{{ $message }}</div> @enderror
            @if(isset($vaga) && $vaga->imagem)
            <div class="mt-2">
                <img src="{{ asset('storage/' . $vaga->imagem) }}" alt="Imagem da vaga" style="max-height: 100px; border-radius: 8px;">
                <small class="d-block text-muted">Imagem atual</small>
            </div>
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Status</label>
            <select name="status" class="form-select">
                <option value="aberta" {{ (old('status', $vaga->status ?? '') === 'aberta') ? 'selected' : '' }}>Aberta</option>
                <option value="fechada" {{ (old('status', $vaga->status ?? '') === 'fechada') ? 'selected' : '' }}>Fechada</option>
            </select>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary rounded-pill px-4">Salvar</button>
            <a href="{{ route('rh.vagas') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancelar</a>
        </div>
    </div>
</form>
@endsection
