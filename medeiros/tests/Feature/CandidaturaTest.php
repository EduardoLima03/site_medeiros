<?php

namespace Tests\Feature;

use App\Models\Candidatura;
use App\Models\Curriculo;
use App\Models\User;
use App\Models\Vaga;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CandidaturaTest extends TestCase
{
    use RefreshDatabase;

    private function vaga(string $titulo = 'Vaga Teste'): Vaga
    {
        return Vaga::create([
            'titulo' => $titulo,
            'descricao' => 'Descricao da vaga',
            'status' => 'aberta',
            'user_id' => User::factory()->create(['role' => 'rh'])->id,
        ]);
    }

    private function cliente(array $extra = []): User
    {
        return User::factory()->create(array_merge(['role' => 'client'], $extra));
    }

    private function dados(array $extra = []): array
    {
        return array_merge([
            'nome' => 'Maria Souza',
            'email' => 'maria@email.com',
            'telefone' => '(85) 99999-0000',
            'objetivo' => 'Vaga de caixa',
        ], $extra);
    }

    public function test_lista_do_rh_mostra_a_quantidade_de_candidaturas(): void
    {
        $rh = User::factory()->create(['role' => 'rh']);
        $vaga = $this->vaga();
        Candidatura::create(['vaga_id' => $vaga->id, 'user_id' => $this->cliente()->id, 'status' => 'candidatado']);
        Candidatura::create(['vaga_id' => $vaga->id, 'user_id' => $this->cliente()->id, 'status' => 'candidatado']);

        $response = $this->actingAs($rh)->get(route('rh.vagas'));

        $response->assertOk();
        $response->assertViewHas('vagas', function ($vagas) use ($vaga) {
            $listada = $vagas->firstWhere('id', $vaga->id);

            return $listada !== null && $listada->candidaturas_count === 2;
        });
    }

    public function test_contagem_de_candidaturas_atualiza_quando_o_cliente_remove(): void
    {
        $rh = User::factory()->create(['role' => 'rh']);
        $vaga = $this->vaga();
        $candidatura = Candidatura::create([
            'vaga_id' => $vaga->id,
            'user_id' => $this->cliente()->id,
            'status' => 'candidatado',
        ]);

        $this->actingAs($rh)->get(route('rh.vagas'))->assertOk();

        $this->actingAs(User::find($candidatura->user_id))
            ->delete(route('dashboard.candidaturas.destroy', $candidatura))
            ->assertRedirect();

        $this->assertSame(0, $vaga->fresh()->candidaturas()->count());
    }

    public function test_curriculo_e_reaproveitado_quando_o_candidato_se_inscreve_em_outra_vaga(): void
    {
        $cliente = $this->cliente();
        $primeira = $this->vaga('Vaga 1');
        $segunda = $this->vaga('Vaga 2');

        $this->actingAs($cliente)
            ->post(route('site.curriculo.store'), $this->dados(['vaga_id' => $primeira->id]))
            ->assertRedirect(route('dashboard'));

        $this->actingAs($cliente)
            ->post(route('site.curriculo.store'), $this->dados(['vaga_id' => $segunda->id, 'telefone' => '(85) 98888-1111']))
            ->assertRedirect(route('dashboard'));

        // Um unico curriculo para o candidato, atualizado com o novo telefone.
        $this->assertSame(1, Curriculo::where('user_id', $cliente->id)->count());
        $this->assertSame('(85) 98888-1111', Curriculo::where('user_id', $cliente->id)->value('telefone'));

        // Candidatura criada nas duas vagas, sem duplicar.
        $this->assertSame(2, Candidatura::where('user_id', $cliente->id)->count());

        // A listagem do RH mostra o candidato uma unica vez.
        $rh = User::factory()->create(['role' => 'rh']);
        $this->actingAs($rh)->get(route('rh.curriculos'))->assertOk();
        $this->assertSame(1, Curriculo::count());
    }

    public function test_pdf_antigo_e_mantido_quando_o_candidato_nao_envia_um_novo(): void
    {
        Storage::fake('public');
        $cliente = $this->cliente();
        $primeira = $this->vaga('Vaga 1');
        $segunda = $this->vaga('Vaga 2');

        $this->actingAs($cliente)->post(route('site.curriculo.store'), $this->dados([
            'vaga_id' => $primeira->id,
            'arquivo' => UploadedFile::fake()->create('curriculo.pdf', 100, 'application/pdf'),
        ]));

        $arquivo = Curriculo::where('user_id', $cliente->id)->value('arquivo');
        $this->assertNotNull($arquivo);
        Storage::disk('public')->assertExists($arquivo);

        // Nova candidatura sem reenviar o arquivo: o PDF cadastrado continua no mesmo curriculo.
        $this->actingAs($cliente)->post(route('site.curriculo.store'), $this->dados(['vaga_id' => $segunda->id]));

        $this->assertSame(1, Curriculo::where('user_id', $cliente->id)->count());
        $this->assertSame($arquivo, Curriculo::where('user_id', $cliente->id)->value('arquivo'));
        Storage::disk('public')->assertExists($arquivo);
    }

    public function test_candidatar_se_novamente_na_mesma_vaga_nao_duplica_nem_quebra(): void
    {
        $cliente = $this->cliente();
        $vaga = $this->vaga();

        $this->actingAs($cliente)->post(route('site.curriculo.store'), $this->dados(['vaga_id' => $vaga->id]));
        $response = $this->actingAs($cliente)->post(route('site.curriculo.store'), $this->dados(['vaga_id' => $vaga->id]));

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('info');
        $this->assertSame(1, Candidatura::where('vaga_id', $vaga->id)->where('user_id', $cliente->id)->count());
        $this->assertSame(1, Curriculo::where('user_id', $cliente->id)->count());
    }

    public function test_cliente_nao_pode_remover_candidatura_de_outro(): void
    {
        $dono = $this->cliente();
        $outro = $this->cliente();
        $candidatura = Candidatura::create([
            'vaga_id' => $this->vaga()->id,
            'user_id' => $dono->id,
            'status' => 'candidatado',
        ]);

        $this->actingAs($outro)
            ->delete(route('dashboard.candidaturas.destroy', $candidatura))
            ->assertForbidden();

        $this->assertSame(1, Candidatura::where('id', $candidatura->id)->count());
    }

    public function test_cliente_remove_a_propria_candidatura_e_o_curriculo_permanece(): void
    {
        $cliente = $this->cliente();
        $vaga = $this->vaga();
        $this->actingAs($cliente)->post(route('site.curriculo.store'), $this->dados(['vaga_id' => $vaga->id]));

        $candidatura = Candidatura::where('user_id', $cliente->id)->firstOrFail();

        // Antes de remover: a vaga aparece na area do cliente com a acao de remover.
        $this->actingAs($cliente)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee($vaga->titulo)
            ->assertSee(route('dashboard.candidaturas.destroy', $candidatura->id), false);

        $this->actingAs($cliente)
            ->delete(route('dashboard.candidaturas.destroy', $candidatura))
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertSame(0, Candidatura::where('user_id', $cliente->id)->count());
        $this->assertSame(1, Curriculo::where('user_id', $cliente->id)->count());
        // Depois: a vaga some da area do cliente, mas o curriculo continua no banco do RH.
        $this->actingAs($cliente)->get(route('dashboard'))->assertOk()->assertDontSee($vaga->titulo);
    }

    public function test_formulario_avisa_que_o_curriculo_sera_reaproveitado(): void
    {
        $cliente = $this->cliente();
        $vaga = $this->vaga();

        $this->actingAs($cliente)->get(route('site.curriculo'))->assertOk()->assertDontSee('reaproveitado');

        $this->actingAs($cliente)->post(route('site.curriculo.store'), $this->dados(['vaga_id' => $vaga->id]));

        $this->actingAs($cliente)
            ->get(route('site.curriculo', ['vaga_id' => $vaga->id]))
            ->assertOk()
            ->assertSee('reutilizado nesta candidatura')
            ->assertSee('já candidatou-se');
    }

    public function test_vaga_ja_candidatar_aparece_marcada_no_site(): void
    {
        $cliente = $this->cliente();
        $vaga = $this->vaga('Vaga Marcada');
        $outra = $this->vaga('Vaga Livre');

        $this->actingAs($cliente)->post(route('site.curriculo.store'), $this->dados(['vaga_id' => $vaga->id]));

        $this->actingAs($cliente)
            ->get(route('site.trabalhe'))
            ->assertOk()
            ->assertSee('Você já se candidatou')
            ->assertSee('Vaga Marcada')
            ->assertSee('Vaga Livre')
            ->assertSee('Candidatar-se');

        // Anonimo nao ve a marcacao.
        auth()->logout();
        $this->get(route('site.trabalhe'))->assertOk()->assertDontSee('Você já seandidatou');
    }
}
