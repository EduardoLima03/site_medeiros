@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4" style="color: var(--text-green); font-weight: 700;">Cadastre-se</h3>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">@foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach</ul>
                        </div>
                    @endif

                    <form action="{{ route('register.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nome completo</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">E-mail</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Telefone</label>
                            <input type="text" name="telefone" class="form-control" value="{{ old('telefone') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">CPF</label>
                            <input type="text" name="cpf" class="form-control" value="{{ old('cpf') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Senha</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Confirmar senha</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <button type="submit" class="btn w-100 text-white fw-bold py-2 rounded-pill" style="background-color: var(--dark-green);">Cadastrar</button>
                    </form>

                    <div class="text-center mt-3">
                        <small>Já tem conta? <a href="{{ route('login') }}" style="color: var(--text-green);">Entre</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
