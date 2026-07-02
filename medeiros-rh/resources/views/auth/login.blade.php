@extends('layouts.app')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <h2 class="mb-4 text-center" style="color: var(--text-green); font-weight: 700;">Entrar</h2>

                @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="p-4 rounded" style="background: #f8f9fa;">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">E-mail</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Senha</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Lembrar-me</label>
                    </div>
                    <button type="submit" class="btn-encarte w-100">Entrar</button>
                    <p class="text-center mt-3 mb-0">
                        Não tem conta? <a href="{{ route('register') }}">Cadastre-se</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
