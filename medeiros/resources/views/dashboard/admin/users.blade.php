@extends('layouts.dashboard')

@section('content')
<h2 class="fw-bold mb-4"><i class="bi bi-people"></i> Gerenciar Usuários</h2>

{{-- Criar usuário --}}
<div class="card card-dashboard mb-4">
    <div class="card-body">
        <h6 class="fw-bold mb-3"><i class="bi bi-person-plus"></i> Criar Usuário</h6>
        <form action="{{ route('admin.users.store') }}" method="POST" class="row g-3 align-items-end">
            @csrf
            <div class="col-md-3">
                <label class="form-label small text-muted">Nome *</label>
                <input type="text" name="name" class="form-control form-control-sm" value="{{ old('name') }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">E-mail *</label>
                <input type="email" name="email" class="form-control form-control-sm" value="{{ old('email') }}" required>
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Telefone</label>
                <input type="text" name="telefone" class="form-control form-control-sm" value="{{ old('telefone') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Função *</label>
                <select name="role" class="form-select form-select-sm">
                    <option value="client" {{ old('role') === 'client' ? 'selected' : '' }}>Cliente</option>
                    <option value="rh" {{ old('role') === 'rh' ? 'selected' : '' }}>RH</option>
                    <option value="marketing" {{ old('role') === 'marketing' ? 'selected' : '' }}>Marketing</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">Senha *</label>
                <input type="password" name="password" class="form-control form-control-sm" required minlength="8">
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">Confirmar senha *</label>
                <input type="password" name="password_confirmation" class="form-control form-control-sm" required minlength="8">
            </div>
            <div class="col-md-2">
                <button class="btn btn-success btn-sm rounded-pill px-4 w-100"><i class="bi bi-person-plus"></i> Criar</button>
            </div>
        </form>
        @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
</div>

{{-- Lista de usuários --}}
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
                    <div class="d-flex gap-1 align-items-center">
                        <form action="{{ route('admin.users.role', $user) }}" method="POST" class="d-flex gap-1 align-items-center">
                            @csrf @method('PUT')
                            <select name="role" class="form-select form-select-sm" style="width: auto;">
                                <option value="client" {{ $user->role === 'client' ? 'selected' : '' }}>Cliente</option>
                                <option value="rh" {{ $user->role === 'rh' ? 'selected' : '' }}>RH</option>
                                <option value="marketing" {{ $user->role === 'marketing' ? 'selected' : '' }}>Marketing</option>
                            </select>
                            <button class="btn btn-sm btn-outline-primary" title="Salvar função"><i class="bi bi-check-lg"></i></button>
                        </form>

                        <button type="button"
                                class="btn btn-sm btn-outline-secondary"
                                title="Alterar senha"
                                data-bs-toggle="modal"
                                data-bs-target="#senhaModal"
                                data-url-put="{{ route('admin.users.senha', $user->id) }}"
                                data-name="{{ $user->name }}">
                            <i class="bi bi-key"></i>
                        </button>

                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Excluir o usuário {{ $user->name }}? A ação não pode ser desfeita.')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Excluir"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Modal alterar senha --}}
<div class="modal fade" id="senhaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="POST" id="senhaForm">
            @csrf @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-key"></i> Alterar Senha</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small" id="senhaUser"></p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nova senha</label>
                        <input type="password" name="password" class="form-control" required minlength="8" autocomplete="new-password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Confirmar nova senha</label>
                        <input type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4"><i class="bi bi-check-lg"></i> Salvar senha</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('senhaModal');
    const form = document.getElementById('senhaForm');
    const userLabel = document.getElementById('senhaUser');

    modal.addEventListener('show.bs.modal', function(event) {
        const btn = event.relatedTarget;
        form.action = btn.dataset.urlPut;
        userLabel.textContent = 'Definir nova senha para ' + btn.dataset.name + '.';
    });
});
</script>
@endpush
@endsection