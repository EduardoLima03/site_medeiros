@extends('layouts.app')

@section('content')
<section class="block-section" style="background: linear-gradient(120deg, var(--dark-green) 0%, var(--primary) 100%);">
    <div class="container text-center text-white py-4">
        <h1 class="fw-black" style="font-size: 2.2rem;">Cadastrar Currículo</h1>
        <p style="opacity: 0.9; font-size: 1.05rem;">Preencha seus dados e participe do nosso processo seletivo</p>
    </div>
</section>

<section class="block-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card-moderno p-4 p-md-5">
                    <form action="{{ route('site.curriculo.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h4 class="fw-bold mb-4" style="color: var(--dark-green);"><i class="bi bi-person-lines-fill me-2"></i>Dados Pessoais</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nome completo *</label>
                                <input type="text" name="nome" value="{{ old('nome', auth()->user()->name ?? '') }}" class="form-control @error('nome') is-invalid @enderror" required>
                                @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">E-mail *</label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" class="form-control @error('email') is-invalid @enderror" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Telefone *</label>
                                <input type="text" name="telefone" value="{{ old('telefone', auth()->user()->telefone ?? '') }}" class="form-control @error('telefone') is-invalid @enderror" required>
                                @error('telefone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Idade</label>
                                <input type="number" name="idade" value="{{ old('idade') }}" min="0" max="150" class="form-control @error('idade') is-invalid @enderror">
                                @error('idade') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Sexo</label>
                                <select name="sexo" class="form-select">
                                    <option value="">Selecione</option>
                                    <option value="masculino" {{ old('sexo') === 'masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="feminino" {{ old('sexo') === 'feminino' ? 'selected' : '' }}>Feminino</option>
                                    <option value="outro" {{ old('sexo') === 'outro' ? 'selected' : '' }}>Outro</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Endereço</label>
                                <input type="text" name="endereco" value="{{ old('endereco') }}" class="form-control">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-semibold">Vaga de interesse</label>
                                <select name="vaga_id" class="form-select">
                                    <option value="">Geral (envio de currículo)</option>
                                    @foreach($vagas as $vaga)
                                    <option value="{{ $vaga->id }}" {{ old('vaga_id', request('vaga_id')) == $vaga->id ? 'selected' : '' }}>{{ $vaga->titulo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <h4 class="fw-bold mb-4 mt-4" style="color: var(--dark-green);"><i class="bi bi-journal-text me-2"></i>Informações Profissionais</h4>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Objetivo</label>
                            <textarea name="objetivo" rows="3" class="form-control @error('objetivo') is-invalid @enderror">{{ old('objetivo') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Formação / Escolaridade</label>
                            <textarea name="formacao" rows="3" class="form-control">{{ old('formacao') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Experiência profissional</label>
                            <textarea name="experiencia_profissional" rows="3" class="form-control">{{ old('experiencia_profissional') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Currículo em PDF (opcional)</label>
                            <input type="file" name="arquivo" accept=".pdf" class="form-control @error('arquivo') is-invalid @enderror">
                            <small class="text-muted">Máximo 5MB. Se enviado, o texto é extraído automaticamente para completar os campos acima.</small>
                            @error('arquivo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Observações</label>
                            <textarea name="observacao" rows="2" class="form-control">{{ old('observacao') }}</textarea>
                        </div>

                        <button type="submit" class="btn-encarte w-100"><i class="bi bi-send me-2"></i>Enviar Currículo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection