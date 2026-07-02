<?php

namespace App\Http\Controllers;

use App\Models\Curriculo;
use App\Models\Candidatura;
use App\Models\Vaga;
use Illuminate\Http\Request;

class CurriculoController extends Controller
{
    public function create()
    {
        $vagas = Vaga::where('status', 'aberta')->get();
        return view('site.cadastrar-curriculo', compact('vagas'));
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

        $data['user_id'] = auth()->id();

        if ($request->hasFile('arquivo')) {
            $data['arquivo'] = $request->file('arquivo')->store('curriculos', 'public');

            // Tentar extrair texto do PDF para auto-preenchimento
            $pdfText = $this->extrairTextoPdf($request->file('arquivo')->getPathname());
            if ($pdfText) {
                foreach (['objetivo', 'formacao', 'experiencia_profissional'] as $campo) {
                    if (empty($data[$campo])) {
                        $data[$campo] = $this->extrairSecao($pdfText, $campo);
                    }
                }
                if (empty($data['objetivo'])) {
                    $data['objetivo'] = $pdfText;
                }
            }
        }

        $curriculo = Curriculo::create($data);

        if ($request->filled('vaga_id')) {
            Candidatura::create([
                'vaga_id' => $request->vaga_id,
                'user_id' => auth()->id(),
                'status' => 'candidatado',
            ]);
        }

        return redirect()->route('rh.home')->with('success', 'Currículo cadastrado com sucesso!');
    }

    private function extrairTextoPdf($caminho): ?string
    {
        try {
            $parser = new \Smalot\PdfParser\Parser();
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
            if (empty($linha)) continue;

            foreach ($palavras as $palavra) {
                if (stripos($linha, $palavra) !== false && !$achou) {
                    $achou = true;
                    continue 2;
                }
            }

            if ($achou) {
                // Verificar se esta linha inicia uma nova seção
                $novaSecao = false;
                foreach ($mapa as $outraSecao => $outrasPalavras) {
                    if ($outraSecao === $secao) continue;
                    foreach ($outrasPalavras as $p) {
                        if (stripos($linha, $p) !== false) {
                            $novaSecao = true;
                            break 2;
                        }
                    }
                }
                if ($novaSecao) break;
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
        return response()->download(storage_path('app/public/' . $curriculo->arquivo));
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
