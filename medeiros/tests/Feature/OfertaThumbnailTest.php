<?php

namespace Tests\Feature;

use App\Models\Oferta;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OfertaThumbnailTest extends TestCase
{
    use RefreshDatabase;

    private function marketing(): User
    {
        $user = User::factory()->create(['role' => 'marketing']);
        $this->actingAs($user);

        return $user;
    }

    private function oferta(array $extra = []): Oferta
    {
        return Oferta::create(array_merge([
            'titulo' => 'Oferta PDF',
            'tipo' => 'pdf',
            'arquivo' => 'ofertas/abc123.pdf',
            'ativa' => true,
            'user_id' => auth()->id(),
        ], $extra));
    }

    public function test_cadastra_pdf_com_thumb_enviada_pelo_navegador(): void
    {
        Storage::fake('public');
        $this->marketing();

        $response = $this->post(route('marketing.ofertas.store'), [
            'titulo' => 'Oferta PDF',
            'tipo' => 'pdf',
            'arquivo' => UploadedFile::fake()->create('oferta.pdf', 100, 'application/pdf'),
            'thumb' => UploadedFile::fake()->image('thumb.jpg', 800, 600),
            'ativa' => 1,
        ]);

        $response->assertRedirect(route('marketing.ofertas'));

        $oferta = Oferta::firstOrFail();

        $this->assertSame('pdf', $oferta->tipo);
        $this->assertSame('ofertas/thumbs/'.$this->nomePdf($oferta->arquivo).'_thumb.jpg', $oferta->thumb);
        Storage::disk('public')->assertExists($oferta->thumb);
    }

    public function test_thumb_invalida_e_rejeitada(): void
    {
        Storage::fake('public');
        $this->marketing();

        $response = $this->post(route('marketing.ofertas.store'), [
            'titulo' => 'Oferta PDF',
            'tipo' => 'pdf',
            'arquivo' => UploadedFile::fake()->create('oferta.pdf', 100, 'application/pdf'),
            'thumb' => UploadedFile::fake()->create('thumb.php', 10, 'application/x-php'),
        ]);

        $response->assertSessionHasErrors('thumb');
        $this->assertSame(0, Oferta::count());
    }

    public function test_salva_offer_sem_thumb_nao_e_bloqueada(): void
    {
        Storage::fake('public');
        $this->marketing();

        $this->post(route('marketing.ofertas.store'), [
            'titulo' => 'Oferta PDF',
            'tipo' => 'pdf',
            'arquivo' => UploadedFile::fake()->create('oferta.pdf', 100, 'application/pdf'),
            'ativa' => 1,
        ])->assertRedirect(route('marketing.ofertas'));

        $oferta = Oferta::firstOrFail();
        $this->assertNull($oferta->thumb);
    }

    public function test_endpoint_de_thumb_grava_a_imagem_recebida(): void
    {
        Storage::fake('public');
        $this->marketing();

        $oferta = $this->oferta();

        $response = $this->postJson(route('marketing.ofertas.thumb', $oferta), [
            'thumb' => UploadedFile::fake()->image('thumb.jpg', 800, 600),
        ]);

        $response->assertOk()->assertJson(['ok' => true]);

        $oferta->refresh();
        $this->assertSame('ofertas/thumbs/abc123_thumb.jpg', $oferta->thumb);
        Storage::disk('public')->assertExists($oferta->thumb);
    }

    public function test_endpoint_de_thumb_exige_imagem(): void
    {
        Storage::fake('public');
        $this->marketing();

        $oferta = $this->oferta();

        $this->postJson(route('marketing.ofertas.thumb', $oferta), [])
            ->assertStatus(422)
            ->assertJsonValidationErrors('thumb');

        $this->assertNull($oferta->refresh()->thumb);
    }

    public function test_endpoint_de_thumb_protegido_por_perfil(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create(['role' => 'rh']));

        $oferta = $this->oferta();

        $this->postJson(route('marketing.ofertas.thumb', $oferta), [
            'thumb' => UploadedFile::fake()->image('thumb.jpg', 800, 600),
        ])->assertForbidden();
    }

    public function test_atualizar_pdf_apaga_a_thumb_do_arquivo_anterior(): void
    {
        Storage::fake('public');
        $this->marketing();

        $oferta = $this->oferta(['thumb' => 'ofertas/thumbs/abc123_thumb.jpg']);
        Storage::disk('public')->put('ofertas/thumbs/abc123_thumb.jpg', 'imagem antiga');

        $this->put(route('marketing.ofertas.update', $oferta), [
            'titulo' => 'Oferta PDF',
            'tipo' => 'pdf',
            'arquivo' => UploadedFile::fake()->create('nova.pdf', 100, 'application/pdf'),
            'thumb' => UploadedFile::fake()->image('thumb.jpg', 800, 600),
            'ativa' => 1,
        ])->assertRedirect(route('marketing.ofertas'));

        $oferta->refresh();
        $novoNome = pathinfo($oferta->arquivo, PATHINFO_FILENAME);

        $this->assertSame("ofertas/thumbs/{$novoNome}_thumb.jpg", $oferta->thumb);
        Storage::disk('public')->assertExists($oferta->thumb);
        Storage::disk('public')->assertMissing('ofertas/thumbs/abc123_thumb.jpg');
    }

    public function test_remover_oferta_apaga_a_thumb(): void
    {
        Storage::fake('public');
        $this->marketing();

        $oferta = $this->oferta(['thumb' => 'ofertas/thumbs/abc123_thumb.jpg']);

        Storage::disk('public')->put('ofertas/thumbs/abc123_thumb.jpg', 'imagem');

        $this->delete(route('marketing.ofertas.destroy', $oferta))->assertRedirect(route('marketing.ofertas'));

        Storage::disk('public')->assertMissing('ofertas/thumbs/abc123_thumb.jpg');
    }

    private function nomePdf(string $arquivo): string
    {
        return pathinfo($arquivo, PATHINFO_FILENAME);
    }
}
