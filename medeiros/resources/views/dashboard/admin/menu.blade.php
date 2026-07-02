@extends('layouts.dashboard')

@section('content')
<h2 class="fw-bold mb-4">Gerenciar Menu</h2>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card card-dashboard p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-list"></i> Itens do Menu</h5>
            @if(count($menuItems) > 0)
            <ul class="list-group" id="menuList">
                @foreach($menuItems as $i => $item)
                <li class="list-group-item d-flex align-items-center gap-3" data-index="{{ $i }}">
                    <div class="d-flex flex-column gap-1">
                        <form action="{{ route('admin.menu.mover', $i) }}" method="POST" style="line-height: 0;">
                            @csrf
                            <input type="hidden" name="direcao" value="subir">
                            <button type="submit" class="btn btn-sm p-0 border-0 text-secondary" title="Subir" {{ $i === 0 ? 'disabled' : '' }}>
                                <i class="bi bi-chevron-up"></i>
                            </button>
                        </form>
                        <form action="{{ route('admin.menu.mover', $i) }}" method="POST" style="line-height: 0;">
                            @csrf
                            <input type="hidden" name="direcao" value="descer">
                            <button type="submit" class="btn btn-sm p-0 border-0 text-secondary" title="Descer" {{ $i === count($menuItems) - 1 ? 'disabled' : '' }}>
                                <i class="bi bi-chevron-down"></i>
                            </button>
                        </form>
                    </div>
                    <span class="fw-semibold" style="min-width: 120px;">{{ $item['label'] }}</span>
                    <code class="text-muted small">{{ $item['url'] }}</code>
                    <span class="ms-auto badge bg-{{ !str_contains($item['url'], '#') ? 'success' : 'warning' }}">{{ str_contains($item['url'], '#') ? 'Placeholder' : 'Ativo' }}</span>
                    <form action="{{ route('admin.menu.remove', $i) }}" method="POST" class="d-inline" onsubmit="return confirm('Remover \'{{ $item['label'] }}\' do menu?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </li>
                @endforeach
            </ul>
            @else
            <p class="text-muted">Nenhum item no menu ainda. Adicione itens ao lado.</p>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-dashboard p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-plus-lg"></i> Adicionar Item</h5>
            <form action="{{ route('admin.menu.add') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="fw-semibold">Tipo</label>
                    <select class="form-select" id="tipoItem" onchange="toggleTipoItem()">
                        <option value="pagina">Página do site</option>
                        <option value="custom">Link personalizado</option>
                    </select>
                </div>
                <div class="mb-3" id="paginaSelectGroup">
                    <label class="fw-semibold">Página</label>
                    <select name="url_pagina" class="form-select" id="paginaSelect">
                        <option value="/">Início</option>
                        <option value="/ofertas">Ofertas</option>
                        <option value="/lojas">Lojas</option>
                        <option value="/sobre">Sobre nós</option>
                        <option value="/trabalhe_conosco">Trabalhe conosco</option>
                        @foreach($allPages as $p)
                        @php
                            $titulo = $pages->has($p) && $pages[$p]->firstWhere('section', 'titulo')
                                ? $pages[$p]->firstWhere('section', 'titulo')->content
                                : $p;
                        @endphp
                        <option value="/pagina/{{ $p }}">{{ $titulo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 d-none" id="customUrlGroup">
                    <label class="fw-semibold">URL</label>
                    <input type="text" name="url_custom" class="form-control" placeholder="https:// ou /pagina/...">
                </div>
                <div class="mb-3">
                    <label class="fw-semibold">Nome no menu</label>
                    <input type="text" name="label" class="form-control" required id="labelInput">
                </div>
                <input type="hidden" name="url" id="urlInput">
                <button type="submit" class="btn btn-success rounded-pill"><i class="bi bi-plus-lg"></i> Adicionar</button>
            </form>
        </div>
    </div>
</div>

<script>
function toggleTipoItem() {
    const tipo = document.getElementById('tipoItem').value;
    document.getElementById('paginaSelectGroup').classList.toggle('d-none', tipo !== 'pagina');
    document.getElementById('customUrlGroup').classList.toggle('d-none', tipo !== 'custom');
    atualizarUrl();
    atualizarLabel();
}

const pageLabels = {};

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('#paginaSelect option').forEach(opt => {
        pageLabels[opt.value] = opt.textContent;
    });
    document.getElementById('paginaSelect')?.addEventListener('change', function() {
        atualizarUrl();
        atualizarLabel();
    });
    document.querySelector('input[name="url_custom"]')?.addEventListener('input', function() {
        document.getElementById('urlInput').value = this.value;
    });
    atualizarUrl();
});

function atualizarUrl() {
    const tipo = document.getElementById('tipoItem').value;
    if (tipo === 'pagina') {
        document.getElementById('urlInput').value = document.getElementById('paginaSelect').value;
    } else {
        document.getElementById('urlInput').value = document.querySelector('input[name="url_custom"]').value;
    }
}

function atualizarLabel() {
    if (document.getElementById('tipoItem').value === 'pagina') {
        const pageUrl = document.getElementById('paginaSelect').value;
        const label = pageLabels[pageUrl] || pageUrl.replace('/', '').replace('-', ' ');
        document.querySelector('input[name="label"]').value = label.charAt(0).toUpperCase() + label.slice(1);
    }
}
</script>
@endsection