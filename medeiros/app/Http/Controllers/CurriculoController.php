<?php

namespace App\Http\Controllers;

use App\Models\Candidatura;
use App\Models\Curriculo;
use App\Models\Vaga;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;

class CurriculoController extends Controller
{
    public function create()
    {
        $vagas = Vaga::where('status', 'aberta')->get();
        $curriculo = Curriculo::where('user_id', auth()->id())->latest()->first();
        $vagasCandidatadas = auth()->user()->candidaturas()->pluck('vaga_id')->all();

        return view('site.cadastrar-curriculo', compact('vagas', 'curriculo', 'vagasCandidatadas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefone' => 'required|string|max:20',
            'endereco' => 'nullable|string|max:255',
            'familia' => 'nullable|string|max:255',
            'idade' => 'nullable|integer|min:0|max:150',
            'sexo' => 'nullable|string|max:20',
            'objetivo' => 'nullable|string',
            'formacao' => 'nullable|string',
            'experiencia_profissional' => 'nullable|string',
            'arquivo' => 'nullable|file|mimes:pdf|max:5120',
            'observacao' => 'nullable|string',
            'vaga_id' => 'nullable|exists:vagas,id',
        ]);

        $dados = Arr::except($data, ['vaga_id', 'arquivo']);

        // O candidato tem um unico curriculo: reaproveitado e atualizado a cada candidatura.
        $curriculo = Curriculo::where('user_id', auth()->id())->latest()->first();
        $arquivoAnterior = $curriculo?->arquivo;

        if ($request->hasFile('arquivo')) {
            $dados['arquivo'] = $request->file('arquivo')->store('curriculos', 'public');

            $pdfText = $this->extrairTextoPdf($request->file('arquivo')->getPathname());
            if ($pdfText) {
                foreach (['objetivo', 'formacao', 'experiencia_profissional'] as $campo) {
                    if (empty($dados[$campo])) {
                        $dados[$campo] = $this->extrairSecao($pdfText, $campo);
                    }
                }
                if (empty($dados['objetivo'])) {
                    $dados['objetivo'] = $pdfText;
                }
            }
        }

        $curriculo = $curriculo ?? new Curriculo;
        $curriculo->fill($dados);
        $curriculo->user_id = auth()->id();
        $curriculo->save();

        if ($arquivoAnterior && $arquivoAnterior !== $curriculo->arquivo) {
            Storage::disk('public')->delete($arquivoAnterior);
        }

        if (! $request->filled('vaga_id')) {
            return redirect()->route('dashboard')->with('success', 'Currículo salvo com sucesso!');
        }

        $candidatura = Candidatura::firstOrCreate([
            'vaga_id' => $request->vaga_id,
            'user_id' => auth()->id(),
        ], ['status' => 'candidatado']);

        if (! $candidatura->wasRecentlyCreated) {
            return redirect()->route('dashboard')->with('info', 'Você já possui candidatura para esta vaga.');
        }

        return redirect()->route('dashboard')->with('success', 'Candidatura registrada com sucesso!');
    }

    private function extrairTextoPdf($caminho): ?string
    {
        try {
            $parser = new Parser;
            $pdf = $parser->parseFile($caminho);

            return $pdf->getText();
        } catch (\Exception $e) {
            return null;
        }
    }

    private function extrairSecao(string $texto, string $secao): string
    {
        $mapa = [
            'objetivo' => ['objetivo', 'objective', 'objetivos'],
            'formacao' => ['formacao', 'formação', 'educação', 'educacao', 'escolaridade', 'formacão', 'education'],
            'experiencia_profissional' => ['experiencia', 'experiência', 'experiência profissional', 'experiencia profissional', 'professional experience', 'work experience', 'employment'],
        ];

        $palavras = $mapa[$secao] ?? [$secao];
        $linhas = explode("\n", $texto);
        $achou = false;
        $resultado = [];

        foreach ($linhas as $linha) {
            $linha = trim($linha);
            if (empty($linha)) {
                continue;
            }

            foreach ($palavras as $palavra) {
                if (stripos($linha, $palavra) !== false && ! $achou) {
                    $achou = true;

                    continue 2;
                }
            }

            if ($achou) {
                $novaSecao = false;
                foreach ($mapa as $outraSecao => $outrasPalavras) {
                    if ($outraSecao === $secao) {
                        continue;
                    }
                    foreach ($outrasPalavras as $p) {
                        if (stripos($linha, $p) !== false) {
                            $novaSecao = true;
                            break 2;
                        }
                    }
                }
                if ($novaSecao) {
                    break;
                }
                $resultado[] = $linha;
            }
        }

        return implode("\n", $resultado);
    }

    // RH
    public function listar()
    {
        $curriculos = Curriculo::with('user')->latest()->get();

        return view('dashboard.rh.curriculos', compact('curriculos'));
    }

    public function download(Curriculo $curriculo)
    {
        if (! $curriculo->arquivo) {
            return redirect()->back()->with('error', 'Este currículo não possui anexo PDF.');
        }

        return response()->download(\Illuminate\Support\Facades\Storage::disk('public')->path($curriculo->arquivo));
    }

    public function imprimir(Curriculo $curriculo)
    {
        return view('dashboard.rh.curriculo-print', compact('curriculo'));
    }

    public function updateStatus(Request $request, Candidatura $candidatura)
    {
        $data = $request->validate([
            'status' => 'required|in:candidatado,analisando,selecionado_entrevista,recusado',
        ]);

        $candidatura->update($data);

        return redirect()->back()->with('success', 'Status da candidatura atualizado!');
    }
}
