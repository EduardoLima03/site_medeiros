<?php

namespace App\Http\Controllers;

use App\Models\Oferta;
use App\Services\PdfThumbnail;
use Illuminate\Http\Request;

class OfertaController extends Controller
{
    public function index()
    {
        Oferta::vencidas()->update(['ativa' => false]);

        $ofertas = Oferta::latest()->get();
        return view('dashboard.marketing.ofertas', compact('ofertas'));
    }

    public function create()
    {
        return view('dashboard.marketing.oferta-form');
    }

    public function store(Request $request)
    {
        // LOG DE DEBUG - upload de arquivo
        $log = [
            'ini_upload_max_filesize' => ini_get('upload_max_filesize'),
            'ini_post_max_size' => ini_get('post_max_size'),
            'ini_upload_tmp_dir' => ini_get('upload_tmp_dir') ?: 'default (sys_get_temp_dir: ' . sys_get_temp_dir() . ')',
            'ini_max_file_uploads' => ini_get('max_file_uploads'),
            'disk_free_temp' => function_exists('disk_free_space') ? disk_free_space(sys_get_temp_dir()) . ' bytes' : 'N/A',
            'content_length' => $_SERVER['CONTENT_LENGTH'] ?? 'N/A',
            'request_method' => $_SERVER['REQUEST_METHOD'] ?? 'N/A',
            'files' => [],
        ];
        foreach ($_FILES as $key => $file) {
            $log['files'][$key] = [
                'name' => $file['name'],
                'size' => $file['size'],
                'error' => $file['error'],
                'error_msg' => match ($file['error']) {
                    0 => 'UPLOAD_ERR_OK',
                    1 => 'UPLOAD_ERR_INI_SIZE (arquivo excede upload_max_filesize)',
                    2 => 'UPLOAD_ERR_FORM_SIZE',
                    3 => 'UPLOAD_ERR_PARTIAL',
                    4 => 'UPLOAD_ERR_NO_FILE',
                    6 => 'UPLOAD_ERR_NO_TMP_DIR',
                    7 => 'UPLOAD_ERR_CANT_WRITE',
                    8 => 'UPLOAD_ERR_EXTENSION',
                    default => 'Desconhecido: ' . $file['error'],
                },
                'tmp_name' => $file['tmp_name'] ?? 'none',
                'type' => $file['type'] ?? 'none',
            ];
        }
        logger()->warning('=== DEBUG UPLOAD OFERTA ===', $log);

        if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] !== 0) {
            logger()->error('FALHA NO UPLOAD - erro PHP: ' . $log['files']['arquivo']['error_msg']);
        }

        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'tipo' => 'required|in:imagem,pdf',
            'arquivo' => 'required|file|mimetypes:image/jpeg,image/png,application/pdf|max:102400',
            'thumb' => 'nullable|file|mimetypes:image/jpeg,image/png|max:10240',
            'ativa' => 'boolean',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
        ]);

        $data['arquivo'] = $request->file('arquivo')->store('ofertas', 'public');
        $data['ativa'] = $request->boolean('ativa');
        $data['user_id'] = auth()->id();
        unset($data['thumb']);

        if ($data['data_fim'] ?? false) {
            $fim = \Carbon\Carbon::parse($data['data_fim']);
            if ($fim->isPast()) {
                $data['ativa'] = false;
            }
        }

        $oferta = Oferta::create($data);

        if ($data['tipo'] === 'pdf') {
            $this->resolverThumbnail($request, $oferta);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Oferta cadastrada!',
                'redirect' => route('marketing.ofertas'),
            ]);
        }

        return redirect()->route('marketing.ofertas')->with('success', 'Oferta cadastrada!');
    }

    public function edit(Oferta $oferta)
    {
        return view('dashboard.marketing.oferta-form', compact('oferta'));
    }

    public function update(Request $request, Oferta $oferta)
    {
        $log = [
            'ini_upload_max_filesize' => ini_get('upload_max_filesize'),
            'ini_post_max_size' => ini_get('post_max_size'),
            'has_file' => $request->hasFile('arquivo'),
        ];
        if ($request->hasFile('arquivo')) {
            $file = $request->file('arquivo');
            $log['file_name'] = $file->getClientOriginalName();
            $log['file_size'] = $file->getSize();
            $log['file_mime'] = $file->getMimeType();
            $log['file_valid'] = $file->isValid();
            $log['file_error'] = $file->getError();
        }
        logger()->warning('=== DEBUG UPDATE OFERTA ===', $log);

        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'tipo' => 'required|in:imagem,pdf',
            'arquivo' => 'nullable|file|mimetypes:image/jpeg,image/png,application/pdf|max:102400',
            'thumb' => 'nullable|file|mimetypes:image/jpeg,image/png|max:10240',
            'ativa' => 'boolean',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
        ]);

        $novoArquivo = $request->hasFile('arquivo');
        if ($novoArquivo) {
            $data['arquivo'] = $request->file('arquivo')->store('ofertas', 'public');
        }
        $data['ativa'] = $request->boolean('ativa');
        unset($data['thumb']);

        $arquivoTrocado = $novoArquivo && ($data['arquivo'] ?? null) !== $oferta->arquivo;

        if ($arquivoTrocado) {
            // A thumbnail antiga pertence ao PDF anterior: apaga o arquivo e o campo.
            app(PdfThumbnail::class)->apagar($oferta);
            $oferta->thumb = null;
        }

        $oferta->update($data);

        if ($data['tipo'] === 'pdf' && $novoArquivo) {
            $this->resolverThumbnail($request, $oferta);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Oferta atualizada!',
                'redirect' => route('marketing.ofertas'),
            ]);
        }

        return redirect()->route('marketing.ofertas')->with('success', 'Oferta atualizada!');
    }

    /**
     * Recebe a thumbnail da 1ª página renderizada no navegador pelo PDF.js.
     */
    public function thumb(Request $request, Oferta $oferta)
    {
        $request->validate([
            'thumb' => 'required|file|mimetypes:image/jpeg,image/png|max:10240',
        ]);

        app(PdfThumbnail::class)->salvarEnviado($request->file('thumb'), $oferta);

        return response()->json(['ok' => true]);
    }

    private function resolverThumbnail(Request $request, Oferta $oferta): void
    {
        try {
            $thumbnails = app(PdfThumbnail::class);

            if ($request->hasFile('thumb')) {
                $thumbnails->salvarEnviado($request->file('thumb'), $oferta);

                return;
            }

            $thumbnails->gerar($oferta);
        } catch (\Throwable $e) {
            logger()->error('Thumb PDF nao gerado (nao bloqueia o save): '.$e->getMessage());
        }
    }

    public function destroy(Oferta $oferta)
    {
        app(PdfThumbnail::class)->apagar($oferta);
        $oferta->delete();
        return redirect()->route('marketing.ofertas')->with('success', 'Oferta removida!');
    }
}
