@extends('layouts.app')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <h2 style="color: var(--text-green); font-weight: 700; font-size: 2rem;" class="mb-4">Cadastrar Currículo</h2>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('site.curriculo.store') }}" method="POST" enctype="multipart/form-data" class="p-4 rounded" style="background: #f8f9fa;">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nome completo *</label>
                            <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome', auth()->user()->name) }}" required>
                            @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">E-mail *</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Telefone *</label>
                            <input type="text" name="telefone" class="form-control @error('telefone') is-invalid @enderror" value="{{ old('telefone', auth()->user()->telefone) }}" required>
                            @error('telefone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Idade</label>
                            <input type="number" name="idade" class="form-control @error('idade') is-invalid @enderror" value="{{ old('idade') }}" min="0" max="150">
                            @error('idade') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Sexo</label>
                            <select name="sexo" class="form-select @error('sexo') is-invalid @enderror">
                                <option value="">Selecione</option>
                                <option value="masculino" {{ old('sexo') === 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="feminino" {{ old('sexo') === 'feminino' ? 'selected' : '' }}>Feminino</option>
                                <option value="outro" {{ old('sexo') === 'outro' ? 'selected' : '' }}>Outro</option>
                            </select>
                            @error('sexo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Endereço</label>
                            <input type="text" name="endereco" class="form-control @error('endereco') is-invalid @enderror" value="{{ old('endereco') }}" placeholder="Rua, número, bairro, cidade">
                            @error('endereco') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Família (filhos, dependentes)</label>
                            <input type="text" name="familia" class="form-control @error('familia') is-invalid @enderror" value="{{ old('familia') }}" placeholder="Ex: 2 filhos, casado(a)">
                            @error('familia') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Objetivo Profissional</label>
                        <textarea name="objetivo" class="form-control @error('objetivo') is-invalid @enderror" rows="3" placeholder="Conte um pouco sobre seus objetivos profissionais">{{ old('objetivo') }}</textarea>
                        @error('objetivo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Formação Acadêmica</label>
                        <textarea name="formacao" class="form-control @error('formacao') is-invalid @enderror" rows="3" placeholder="Escolaridade, cursos, certificações...">{{ old('formacao') }}</textarea>
                        @error('formacao') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Experiência Profissional</label>
                        <textarea name="experiencia_profissional" class="form-control @error('experiencia_profissional') is-invalid @enderror" rows="4" placeholder="Empresas, cargos, período, principais atividades...">{{ old('experiencia_profissional') }}</textarea>
                        @error('experiencia_profissional') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Currículo (PDF)</label>
                        <input type="file" name="arquivo" class="form-control @error('arquivo') is-invalid @enderror" accept=".pdf">
                        <small class="text-muted">Apenas PDF, máximo 5MB. Se enviar, tentaremos preencher automaticamente os campos acima.</small>
                        @error('arquivo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Vaga de interesse (opcional)</label>
                        <select name="vaga_id" class="form-select">
                            <option value="">Selecione uma vaga</option>
                            @foreach($vagas as $vaga)
                            <option value="{{ $vaga->id }}" {{ request('vaga_id') == $vaga->id ? 'selected' : '' }}>{{ $vaga->titulo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Observação</label>
                        <textarea name="observacao" class="form-control" rows="2">{{ old('observacao') }}</textarea>
                    </div>

                    <button type="submit" class="btn-encarte" style="width: auto; padding: 0.6rem 2.5rem; font-size: 1rem;">Enviar Currículo</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
