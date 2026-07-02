@extends('layouts.app')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mb-4 text-center" style="color: var(--text-green); font-weight: 700;">Cadastre-se</h2>

                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="p-4 rounded" style="background: #f8f9fa;">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nome completo *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">E-mail *</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Telefone</label>
                            <input type="text" name="telefone" class="form-control" value="{{ old('telefone') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">CPF</label>
                            <input type="text" name="cpf" class="form-control" value="{{ old('cpf') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Senha *</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Confirmar Senha *</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn-encarte w-100">Cadastrar</button>
                    <p class="text-center mt-3 mb-0">
                        Já tem conta? <a href="{{ route('login') }}">Entrar</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
