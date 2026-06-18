<?php

namespace App\Http\Controllers;

use App\Models\Oferta;
use Illuminate\Http\Request;

class OfertaController extends Controller
{
    public function index()
    {
        Oferta::where('data_fim', '<', now()->format('Y-m-d'))
            ->where('ativa', true)
            ->update(['ativa' => false]);

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
            'ativa' => 'boolean',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
        ]);

        $data['arquivo'] = $request->file('arquivo')->store('ofertas', 'public');
        $data['ativa'] = $request->boolean('ativa');
        $data['user_id'] = auth()->id();

        if ($data['data_fim'] ?? false) {
            $fim = \Carbon\Carbon::parse($data['data_fim']);
            if ($fim->isPast()) {
                $data['ativa'] = false;
            }
        }

        $oferta = Oferta::create($data);

        if ($data['tipo'] === 'pdf') {
            $this->gerarThumbnailPdf($oferta);
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
            'ativa' => 'boolean',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
        ]);

        $novoArquivo = $request->hasFile('arquivo');
        if ($novoArquivo) {
            $data['arquivo'] = $request->file('arquivo')->store('ofertas', 'public');
        }
        $data['ativa'] = $request->boolean('ativa');

        $oferta->update($data);

        if ($data['tipo'] === 'pdf' && $novoArquivo) {
            $this->gerarThumbnailPdf($oferta);
        }

        return redirect()->route('marketing.ofertas')->with('success', 'Oferta atualizada!');
    }

    private function gerarThumbnailPdf(Oferta $oferta)
    {
        $pdfPath = storage_path('app/public/' . $oferta->arquivo);
        if (!file_exists($pdfPath)) return;

        $thumbDir = storage_path('app/public/ofertas/thumbs');
        if (!is_dir($thumbDir)) {
            mkdir($thumbDir, 0755, true);
        }

        $thumbName = pathinfo($oferta->arquivo, PATHINFO_FILENAME) . '_thumb.jpg';
        $thumbPath = $thumbDir . '/' . $thumbName;

        $cmd = sprintf(
            'gs -dNOPAUSE -dBATCH -sDEVICE=jpeg -r72 -dFirstPage=1 -dLastPage=1 -dTextAlphaBits=4 -dGraphicsAlphaBits=4 -sOutputFile=%s %s 2>/dev/null',
            escapeshellarg($thumbPath),
            escapeshellarg($pdfPath)
        );
        exec($cmd, $output, $exitCode);

        if ($exitCode === 0 && file_exists($thumbPath)) {
            $oferta->update(['thumb' => 'ofertas/thumbs/' . $thumbName]);
        }
    }

    public function destroy(Oferta $oferta)
    {
        $oferta->delete();
        return redirect()->route('marketing.ofertas')->with('success', 'Oferta removida!');
    }
}
