@extends('layouts.dashboard')

@section('content')
<h2 class="fw-bold mb-4"><i class="bi bi-images"></i> Biblioteca de Mídia</h2>

<div class="row g-4">
    <div class="col-md-3">
        <div class="card card-dashboard p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-upload"></i> Enviar Imagem</h5>
            <form action="{{ route('admin.media.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Arquivo</label>
                    <input type="file" name="file" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp" required>
                    <small class="text-muted">JPEG, PNG, GIF, WebP. Máx 10MB.</small>
                </div>
                <button type="submit" class="btn btn-primary rounded-pill w-100">
                    <i class="bi bi-cloud-upload"></i> Enviar
                </button>
            </form>
            <hr>
            <div class="upload-zone border border-dashed rounded p-4 text-center" id="dropzone"
                style="border-style: dashed; cursor: pointer;">
                <i class="bi bi-cloud-arrow-up fs-1 text-muted"></i>
                <p class="text-muted small mb-0">Arraste imagens aqui</p>
            </div>
            <form id="dropzoneForm" action="{{ route('admin.media.upload') }}" method="POST" enctype="multipart/form-data" class="d-none">
                @csrf
                <input type="file" name="file" id="dropzoneInput" accept="image/jpeg,image/png,image/gif,image/webp">
            </form>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card card-dashboard p-4">
            <h5 class="fw-bold mb-3">Todas as Imagens</h5>
            @if($media->count() > 0)
            <div class="row g-3" id="mediaGrid">
                @foreach($media as $item)
                <div class="col-md-4 col-lg-3">
                    <div class="card border">
                        <div class="position-relative" style="height: 160px; overflow: hidden; background: #f0f0f0;">
                            <img src="{{ $item->url }}" alt="{{ $item->original_name }}"
                                class="w-100 h-100" style="object-fit: cover; cursor: pointer;"
                                onclick="copiarUrl('{{ $item->url }}')"
                                title="Clique para copiar URL">
                        </div>
                        <div class="card-body p-2">
                            <p class="small text-truncate mb-1" title="{{ $item->original_name }}">{{ $item->original_name }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ round($item->size / 1024) }} KB</small>
                                <form action="{{ route('admin.media.destroy', $item) }}" method="POST"
                                    onsubmit="return confirm('Remover esta imagem?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-muted text-center py-5">Nenhuma imagem enviada ainda.</p>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('dropzone')?.addEventListener('click', function() {
    document.getElementById('dropzoneInput').click();
});
document.getElementById('dropzoneInput')?.addEventListener('change', function() {
    if (this.files.length) document.getElementById('dropzoneForm').submit();
});
document.getElementById('dropzone')?.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.style.borderColor = '#0d6efd';
    this.style.background = '#e7f1ff';
});
document.getElementById('dropzone')?.addEventListener('dragleave', function() {
    this.style.borderColor = '';
    this.style.background = '';
});
document.getElementById('dropzone')?.addEventListener('drop', function(e) {
    e.preventDefault();
    this.style.borderColor = '';
    this.style.background = '';
    const dt = e.dataTransfer;
    if (dt.files.length) {
        document.getElementById('dropzoneInput').files = dt.files;
        document.getElementById('dropzoneForm').submit();
    }
});

function copiarUrl(url) {
    navigator.clipboard.writeText(url).then(() => {
        alert('URL copiada: ' + url);
    }).catch(() => {
        prompt('Copie a URL:', url);
    });
}
</script>
@endpush
@endsection