@extends('layouts.dashboard')

@section('content')
<h2 class="fw-bold mb-4"><i class="bi bi-people"></i> Gerenciar Usuários</h2>

<div class="table-responsive">
    <table class="table table-hover bg-white rounded shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Função</th>
                <th>Cadastro</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td class="fw-semibold">{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->telefone ?? '-' }}</td>
                <td>
                    <span class="badge bg-{{ $user->role === 'rh' ? 'primary' : ($user->role === 'marketing' ? 'success' : 'secondary') }}">{{ $user->role }}</span>
                </td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                <td>
                    <form action="{{ route('admin.users.role', $user) }}" method="POST" class="d-flex gap-1 align-items-center">
                        @csrf @method('PUT')
                        <select name="role" class="form-select form-select-sm" style="width: auto;">
                            <option value="client" {{ $user->role === 'client' ? 'selected' : '' }}>Cliente</option>
                            <option value="rh" {{ $user->role === 'rh' ? 'selected' : '' }}>RH</option>
                            <option value="marketing" {{ $user->role === 'marketing' ? 'selected' : '' }}>Marketing</option>
                        </select>
                        <button class="btn btn-sm btn-outline-primary"><i class="bi bi-check-lg"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
