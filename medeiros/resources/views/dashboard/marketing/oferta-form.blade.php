@extends('layouts.dashboard')

@section('content')
<h2 class="fw-bold mb-4">{{ isset($oferta) ? 'Editar Oferta' : 'Nova Oferta' }}</h2>

<form action="{{ isset($oferta) ? route('marketing.ofertas.update', $oferta) : route('marketing.ofertas.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($oferta)) @method('PUT') @endif

    <div class="card card-dashboard p-4">
        <div class="mb-3">
            <label class="form-label fw-semibold">Título da Oferta *</label>
            <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror" value="{{ old('titulo', $oferta->titulo ?? '') }}" required>
            @error('titulo') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Tipo *</label>
            <select name="tipo" class="form-select" id="tipoOferta">
                <option value="imagem" {{ (old('tipo', $oferta->tipo ?? '') === 'imagem') ? 'selected' : '' }}>Imagem</option>
                <option value="pdf" {{ (old('tipo', $oferta->tipo ?? '') === 'pdf') ? 'selected' : '' }}>PDF</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Arquivo *</label>
            <input type="file" name="arquivo" class="form-control @error('arquivo') is-invalid @enderror" accept=".jpg,.jpeg,.png,.pdf">
            <small class="text-muted">Máximo 100MB. Formatos: JPG, PNG, PDF</small>
            @if(isset($oferta))
            <br><small class="text-info">Deixe em branco para manter o arquivo atual.</small>
            @endif
            @error('arquivo') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Data de Início</label>
                <input type="date" name="data_inicio" class="form-control @error('data_inicio') is-invalid @enderror" value="{{ old('data_inicio', isset($oferta) && $oferta->data_inicio ? $oferta->data_inicio->format('Y-m-d') : '') }}">
                @error('data_inicio') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Data de Fim</label>
                <input type="date" name="data_fim" class="form-control @error('data_fim') is-invalid @enderror" value="{{ old('data_fim', isset($oferta) && $oferta->data_fim ? $oferta->data_fim->format('Y-m-d') : '') }}">
                <small class="text-muted">Após esta data a oferta será desativada automaticamente.</small>
                @error('data_fim') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="mb-3 form-check form-switch">
            <input type="checkbox" name="ativa" class="form-check-input" id="ativa" value="1" {{ old('ativa', $oferta->ativa ?? true) ? 'checked' : '' }}>
            <label class="form-check-label fw-semibold" for="ativa">Oferta ativa</label>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success rounded-pill px-4">Salvar</button>
            <a href="{{ route('marketing.ofertas') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancelar</a>
        </div>
    </div>
</form>
@endsection
