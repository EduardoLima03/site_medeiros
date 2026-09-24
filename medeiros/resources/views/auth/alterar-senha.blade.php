@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0" style="font-weight: 700;"><i class="bi bi-key"></i> Alterar Senha</h2>
</div>

<div class="card card-dashboard">
    <div class="card-body">
        <form action="{{ route('dashboard.senha.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3 col-md-6">
                <label class="form-label fw-semibold">Senha atual</label>
                <input type="password" name="current_password" class="form-control" required autocomplete="current-password">
                @error('current_password')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label fw-semibold">Nova senha</label>
                <input type="password" name="password" class="form-control" required minlength="8" autocomplete="new-password">
                <div class="form-text">Mínimo de 8 caracteres.</div>
                @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4 col-md-6">
                <label class="form-label fw-semibold">Confirmar nova senha</label>
                <input type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn-success rounded-pill px-4"><i class="bi bi-check-lg"></i> Alterar Senha</button>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancelar</a>
        </form>
    </div>
</div>
@endsection