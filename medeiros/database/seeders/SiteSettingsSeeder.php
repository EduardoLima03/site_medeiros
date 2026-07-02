<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'primary_color', 'value' => '#6ec1e4'],
            ['key' => 'secondary_color', 'value' => '#8db04a'],
            ['key' => 'text_color', 'value' => '#228b22'],
            ['key' => 'dark_green', 'value' => '#387543'],
            ['key' => 'gold', 'value' => '#e5a000'],
            ['key' => 'site_name', 'value' => 'Mercantil Medeiros LTDA'],
            ['key' => 'site_description', 'value' => 'O supermercado da sua família'],
            ['key' => 'phone_central', 'value' => '(85) 3291-2233'],
            ['key' => 'whatsapp', 'value' => 'https://whats.idsolucoesweb.com.br/v2/bot/medeiros/pagina'],
            ['key' => 'instagram', 'value' => 'https://www.instagram.com/medeirossupermercados/'],
            ['key' => 'facebook', 'value' => 'https://www.facebook.com/medeirossupermercados/'],
            ['key' => 'app_play_store', 'value' => 'https://play.google.com/store/apps/details?id=mercadapp.fgl.com.medeiros&hl=pt_BR'],
            ['key' => 'app_app_store', 'value' => 'https://apps.apple.com/br/app/medeiros/id1383747653'],
            ['key' => 'cnpj', 'value' => '63.589.726/0001-07'],
            ['key' => 'portfolio_url', 'value' => 'https://franciscojose96.github.io/MyPortfolio/'],
            ['key' => 'cadastro_url', 'value' => 'https://cadastramento-medeiros.mercafacil.com/home'],
            ['key' => 'curriculo_drive', 'value' => 'https://drive.google.com/drive/folders/1AlLyojjIG41AMrJc-_-aCtztK5tEKoYZ'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::create($setting);
        }
    }
}
