@php use Illuminate\Support\Str; @endphp
@extends('layouts.dashboard')

@section('content')
<h2 class="fw-bold mb-4"><i class="bi bi-file-earmark-text"></i> Páginas</h2>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card card-dashboard p-0">
            <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Todas as Páginas</h5>
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#novaPaginaModal">
                    <i class="bi bi-plus-lg"></i> Nova Página
                </button>
            </div>
            <div class="card-body p-0">
                @forelse($pages as $pageName => $sections)
                <div class="border-bottom">
                    <div class="d-flex align-items-center justify-content-between px-4 py-3 bg-light bg-opacity-50">
                        <div>
                            <strong class="fs-6">{{ Str::title(str_replace('_', ' ', $pageName)) }}</strong>
                            <span class="badge bg-secondary ms-2">{{ $sections->count() }} seções</span>
                            <code class="ms-2 text-muted small">/{{ $pageName }}</code>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary" onclick="editarPagina('{{ $pageName }}')">
                                <i class="bi bi-pencil"></i> Editar
                            </button>
                            <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#novaSecaoModal"
                                onclick="document.getElementById('secaoPage').value='{{ $pageName }}'">
                                <i class="bi bi-plus-circle"></i> Seção
                            </button>
                        </div>
                    </div>
                    <div class="px-4 py-2 d-flex flex-wrap gap-2">
                        @foreach($sections as $sec)
                        <span class="badge bg-white text-dark border d-flex align-items-center gap-2 py-2 px-3">
                            {{ $sec->section }}
                            <form action="{{ route('admin.section.delete', $sec) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Remover seção \'{{ $sec->section }}\'?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-xs p-0 text-danger" style="background: none; border: none; line-height: 1;">&times;</button>
                            </form>
                        </span>
                        @endforeach
                    </div>
                </div>
                @empty
                <div class="p-4 text-muted text-center">Nenhuma página cadastrada.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-dashboard p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-pencil-square"></i> Editar Conteúdo</h5>
            <form action="{{ route('admin.content') }}" method="POST" id="contentForm">
                @csrf
                <div class="mb-3">
                    <label class="fw-semibold">Página</label>
                    <select name="page" class="form-select" id="pageSelect">
                        @foreach($allPages as $p)
                        <option value="{{ $p }}">{{ Str::title(str_replace('_', ' ', $p)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="fw-semibold">Seção</label>
                    <select name="section" class="form-select" id="sectionSelect"></select>
                </div>
                <div class="mb-3">
                    <label class="fw-semibold">Conteúdo</label>
                    <div id="quillEditor" style="height: 300px;"></div>
                    <textarea name="content" id="contentTextarea" class="d-none"></textarea>
                    <small class="text-muted">Use o botão <i class="bi bi-image"></i> para inserir imagens da biblioteca de mídia.</small>
                </div>
                <button type="submit" class="btn btn-primary rounded-pill w-100">
                    <i class="bi bi-save"></i> Salvar Conteúdo
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Nova Página -->
<div class="modal fade" id="novaPaginaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.page.create') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Nova Página</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Slug (ex: politicas-de-privacidade)</label>
                        <input type="text" name="page" class="form-control" required pattern="[a-z0-9_-]+" title="Apenas letras minúsculas, números, hífen e underscore">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Título da Página</label>
                        <input type="text" name="titulo" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Criar Página</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Nova Seção -->
<div class="modal fade" id="novaSecaoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.section.create') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Nova Seção</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Página</label>
                        <select name="page" class="form-select" id="secaoPage" required>
                            @foreach($allPages as $p)
                            <option value="{{ $p }}">{{ Str::title(str_replace('_', ' ', $p)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nome da Seção</label>
                        <input type="text" name="section" class="form-control" required pattern="[a-z0-9_-]+" title="Apenas letras minúsculas, números, hífen e underscore">
                        <small class="text-muted">Ex: titulo, texto_1, banner, conteudo_principal</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info">Criar Seção</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Biblioteca de Mídia -->
<div class="modal fade" id="mediaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-images"></i> Biblioteca de Mídia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs mb-3" id="mediaTabs">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#bibliotecaTab">
                            <i class="bi bi-collection"></i> Biblioteca
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#uploadTab">
                            <i class="bi bi-cloud-upload"></i> Enviar Nova
                        </button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="bibliotecaTab">
                        <div class="row g-2" id="mediaLibraryGrid" style="max-height: 400px; overflow-y: auto;">
                            <div class="col-12 text-center text-muted py-4">Carregando...</div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="uploadTab">
                        <div class="upload-zone border border-dashed rounded p-5 text-center" id="mediaUploadZone"
                            style="border-style: dashed; cursor: pointer;">
                            <i class="bi bi-cloud-arrow-up fs-1 text-muted"></i>
                            <p class="text-muted mb-2">Arraste uma imagem ou clique para selecionar</p>
                            <small class="text-muted">JPEG, PNG, GIF, WebP. Máx 10MB.</small>
                        </div>
                        <div class="mt-3 text-center">
                            <div id="uploadPreview" class="d-none">
                                <img id="previewImg" src="" class="img-thumbnail mb-2" style="max-height: 200px;">
                                <div class="progress mb-2 d-none" id="uploadProgress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%"></div>
                                </div>
                                <p class="text-success" id="uploadSuccess" class="d-none">Imagem enviada! Selecione-a na aba "Biblioteca".</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
<style>
.media-item { cursor: pointer; border: 2px solid transparent; border-radius: 6px; overflow: hidden; }
.media-item:hover { border-color: #0d6efd; }
.media-item.selected { border-color: #0d6efd; background: #e7f1ff; }
.media-item img { width: 100%; height: 120px; object-fit: cover; }
.media-item .name { font-size: 0.75rem; padding: 4px 6px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.min.js"></script>
<script>
const sectionsByPage = @json($pages->map(fn($s) => $s->pluck('section')));

function insertImageToEditor(url) {
    const range = quill.getSelection();
    quill.insertEmbed(range ? range.index : 0, 'image', url);
}

let quill = new Quill('#quillEditor', {
    theme: 'snow',
    modules: {
        toolbar: {
            container: [
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'size': ['small', false, 'large', 'huge'] }],
                [{ 'header': [1, 2, 3, false] }],
                ['link', 'image', 'clean']
            ],
            handlers: {
                image: function() {
                    const modal = new bootstrap.Modal(document.getElementById('mediaModal'));
                    carregarBiblioteca();
                    modal.show();
                }
            }
        }
    }
});

function carregarBiblioteca() {
    const grid = document.getElementById('mediaLibraryGrid');
    grid.innerHTML = '<div class="col-12 text-center text-muted py-4">Carregando...</div>';
    fetch('{{ route('admin.media.list-json') }}')
        .then(r => r.json())
        .then(images => {
            if (!images.length) {
                grid.innerHTML = '<div class="col-12 text-center text-muted py-4">Nenhuma imagem na biblioteca.</div>';
                return;
            }
            grid.innerHTML = images.map(img => `
                <div class="col-4 col-md-3">
                    <div class="media-item" onclick="selecionarImagem('${img.url}', this)">
                        <img src="${img.url}" alt="${img.original_name}" loading="lazy">
                        <div class="name text-muted">${img.original_name}</div>
                    </div>
                </div>
            `).join('');
        });
}

function selecionarImagem(url, el) {
    document.querySelectorAll('.media-item').forEach(i => i.classList.remove('selected'));
    el.classList.add('selected');
    const modal = bootstrap.Modal.getInstance(document.getElementById('mediaModal'));
    modal.hide();
    insertImageToEditor(url);
}

// Upload via drag & drop
const uploadZone = document.getElementById('mediaUploadZone');
const fileInput = document.createElement('input');
fileInput.type = 'file';
fileInput.accept = 'image/jpeg,image/png,image/gif,image/webp';
fileInput.style.display = 'none';
uploadZone.parentNode.appendChild(fileInput);

uploadZone.addEventListener('click', () => fileInput.click());

fileInput.addEventListener('change', function() {
    if (this.files.length) uploadMediaFile(this.files[0]);
});

uploadZone.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.style.borderColor = '#0d6efd';
    this.style.background = '#e7f1ff';
});
uploadZone.addEventListener('dragleave', function() {
    this.style.borderColor = '';
    this.style.background = '';
});
uploadZone.addEventListener('drop', function(e) {
    e.preventDefault();
    this.style.borderColor = '';
    this.style.background = '';
    if (e.dataTransfer.files.length) uploadMediaFile(e.dataTransfer.files[0]);
});

function uploadMediaFile(file) {
    const preview = document.getElementById('uploadPreview');
    const previewImg = document.getElementById('previewImg');
    const progress = document.getElementById('uploadProgress');
    const success = document.getElementById('uploadSuccess');

    preview.classList.remove('d-none');
    progress.classList.remove('d-none');
    success.classList.add('d-none');
    previewImg.src = URL.createObjectURL(file);

    const formData = new FormData();
    formData.append('file', file);

    fetch('{{ route('admin.media.upload-json') }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        progress.classList.add('d-none');
        success.classList.remove('d-none');
        setTimeout(() => {
            carregarBiblioteca();
            const tab = new bootstrap.Tab(document.querySelector('#mediaTabs [data-bs-target="#bibliotecaTab"]'));
            tab.show();
            success.classList.add('d-none');
        }, 1500);
    })
    .catch(() => {
        progress.classList.add('d-none');
        alert('Erro ao enviar imagem.');
    });
}

document.getElementById('pageSelect')?.addEventListener('change', function() {
    const page = this.value;
    const select = document.getElementById('sectionSelect');
    select.innerHTML = '';
    (sectionsByPage[page] || []).forEach(sec => {
        const opt = document.createElement('option');
        opt.value = sec;
        opt.textContent = sec;
        select.appendChild(opt);
    });
    select.dispatchEvent(new Event('change'));
});

document.getElementById('sectionSelect')?.addEventListener('change', function() {
    const page = document.getElementById('pageSelect').value;
    const section = this.value;
    if (!section) return;
    fetch(`/dashboard/admin/content-json?page=${page}&section=${section}`)
        .then(r => r.json())
        .then(data => {
            quill.root.innerHTML = data.content || '';
        })
        .catch(() => {});
});

document.getElementById('contentForm')?.addEventListener('submit', function() {
    document.getElementById('contentTextarea').value = quill.root.innerHTML;
});

document.getElementById('pageSelect')?.dispatchEvent(new Event('change'));

function editarPagina(page) {
    document.getElementById('pageSelect').value = page;
    document.getElementById('pageSelect').dispatchEvent(new Event('change'));
    document.querySelector('.col-md-4').scrollIntoView({ behavior: 'smooth' });
}
</script>
@endpush
@endsection