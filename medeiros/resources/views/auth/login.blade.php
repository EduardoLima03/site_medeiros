@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4" style="color: var(--text-green); font-weight: 700;">Entrar</h3>

                    @if($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">E-mail</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Senha</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn w-100 text-white fw-bold py-2 rounded-pill" style="background-color: var(--dark-green);">Entrar</button>
                    </form>

                    <div class="text-center mt-3">
                        <small>Não tem conta? <a href="{{ route('register') }}" style="color: var(--text-green);">Cadastre-se</a></small>
                    </div>
                </div>
            </div>

            <div class="mt-4 p-3 rounded-4" style="background: #f0f7f0;">
                <p class="mb-2 small fw-semibold">Credenciais de teste:</p>
                <ul class="small mb-0">
                    <li><strong>Admin:</strong> admin@medeiros.com.br / 123456</li>
                    <li><strong>RH:</strong> rh@medeiros.com.br / 123456</li>
                    <li><strong>Marketing:</strong> marketing@medeiros.com.br / 123456</li>
                    <li><strong>Cliente:</strong> cliente@teste.com / 123456</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
