@extends('layouts.dashboard')

@section('content')
<h2 class="fw-bold mb-4">{{ isset($achado) ? 'Editar Item' : 'Novo Item' }}</h2>

<form action="{{ isset($achado) ? route('marketing.achados.update', $achado) : route('marketing.achados.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($achado)) @method('PUT') @endif

    <div class="card card-dashboard p-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Título do Item *</label>
                <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror" value="{{ old('titulo', $achado->titulo ?? '') }}" required>
                <small class="text-muted">Ex.: Chaveiro, Carteira, Óculos...</small>
                @error('titulo') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Local Encontrado</label>
                <input type="text" name="local_encontrado" class="form-control @error('local_encontrado') is-invalid @enderror" value="{{ old('local_encontrado', $achado->local_encontrado ?? '') }}">
                <small class="text-muted">Ex.: Loja 2 - Presidente José Walter</small>
                @error('local_encontrado') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Descrição *</label>
            <textarea name="descricao" class="form-control @error('descricao') is-invalid @enderror" rows="4" required>{{ old('descricao', $achado->descricao ?? '') }}</textarea>
            <small class="text-muted">Descreva características do item. Evite dados que permitam identificação imediata pelo público.</small>
            @error('descricao') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Data Encontrada</label>
                <input type="date" name="data_encontrado" class="form-control @error('data_encontrado') is-invalid @enderror" value="{{ old('data_encontrado', isset($achado) && $achado->data_encontrado ? $achado->data_encontrado->format('Y-m-d') : '') }}">
                @error('data_encontrado') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Foto do Item</label>
                <input type="file" name="imagem" class="form-control @error('imagem') is-invalid @enderror" accept=".jpg,.jpeg,.png">
                <small class="text-muted">Máximo 10MB. Formatos: JPG, PNG</small>
                @error('imagem') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        @if(isset($achado) && $achado->imagem)
        <div class="mb-3">
            <img src="{{ Storage::url($achado->imagem) }}" alt="Foto atual" width="120" class="rounded">
            <small class="text-muted d-block">Foto atual. Envie outra para substituir.</small>
        </div>
        @endif
        <div class="mb-3 form-check form-switch">
            <input type="checkbox" name="entregue" class="form-check-input" id="entregue" value="1" {{ old('entregue', $achado->entregue ?? false) ? 'checked' : '' }}>
            <label class="form-check-label fw-semibold" for="entregue">Item devolvido ao dono</label>
            <br><small class="text-muted">Quando marcado, o item some da página pública.</small>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success rounded-pill px-4">Salvar</button>
            <a href="{{ route('marketing.achados') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancelar</a>
        </div>
    </div>
</form>
@endsection