@extends('layouts.dashboard')

@section('content')
<h2 class="fw-bold mb-4"><i class="bi bi-palette"></i> Aparência</h2>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card card-dashboard p-4">
            <h5 class="fw-bold mb-3">Cores do Tema</h5>
            <form action="{{ route('admin.settings') }}" method="POST">
                @csrf
                @foreach([
                    'primary_color' => 'Cor Primária',
                    'secondary_color' => 'Cor Secundária',
                    'text_color' => 'Cor do Texto',
                    'dark_green' => 'Verde Escuro',
                    'gold' => 'Dourado',
                ] as $key => $label)
                <div class="mb-3 d-flex align-items-center gap-3">
                    <label class="fw-semibold" style="min-width: 120px;">{{ $label }}</label>
                    <input type="color" name="{{ $key }}" value="{{ $settings[$key] ?? '#6ec1e4' }}" class="form-control form-control-color w-auto">
                    <input type="text" name="{{ $key }}" value="{{ $settings[$key] ?? '#6ec1e4' }}" class="form-control form-control-sm" style="width: 100px; font-size: 0.8rem;">
                </div>
                @endforeach
                <button type="submit" class="btn btn-primary rounded-pill mt-3">
                    <i class="bi bi-save"></i> Salvar Cores
                </button>
            </form>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-dashboard p-4">
            <h5 class="fw-bold mb-3">Pré-visualização</h5>
            <div class="border rounded p-4 text-center" style="background: var(--dark-green, #387543);">
                <span class="badge mb-2" style="background: var(--gold, #e5a000); color: #fff;">Exemplo de Badge</span>
                <p class="text-white mb-2" style="color: var(--text-color, #228b22);">Texto com a cor definida</p>
                <div class="d-flex gap-2 justify-content-center">
                    <span class="btn btn-sm rounded-pill" style="background: var(--primary-color, #6ec1e4); color: #fff;">Primária</span>
                    <span class="btn btn-sm rounded-pill" style="background: var(--secondary-color, #8db04a); color: #fff;">Secundária</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection