# 🛒 Site Medeiros Supermercado

Site institucional do Supermercado Medeiros com sistema de gestão de ofertas, vagas de emprego, candidaturas e promoções do aplicativo.

## Funcionalidades

- **Site público**: home com blocos editáveis (banner, carrossel, texto, imagem, ofertas, vagas, lojas, CTA app e promoções do app), lojas, sobre, ofertas da semana, trabalhe conosco e páginas dinâmicas
- **Painéis por role**:
  - `admin` — blocos da home (adicionar/reordenar/editar + slides do carrossel), páginas, menu, cores, configurações, mídia e usuários
  - `rh` — vagas de emprego + candidaturas com currículos
  - `marketing` — ofertas (imagem ou PDF) com vigência
  - `client` — inscrição em vagas e acompanhamento de status
- **Ofertas**: upload de imagem ou PDF; PDFs geram thumbnail automático da 1ª página
- **Promoções do App**: bloco da home que busca as promoções publicadas no app do Medeiros (Instabuy), com cache de 1h
- **Currículos**: formulário detalhado com extração de texto de PDF via `smalot/pdfparser`
- **Candidaturas**: fluxo candidatado → analisando → selecionado_entrevista / recusado

## Requisitos

- PHP 8.2+
- Composer
- MySQL (recomendado) ou SQLite
- Opcional: [Ghostscript](https://www.ghostscript.com/) ou a extensão Imagick (para gerar thumbnails de PDF no próprio servidor)

## Instalação

```bash
git clone git@github.com:EduardoLima03/site_medeiros.git
cd site_medeiros/medeiros
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

### Banco de dados (MySQL via Docker)

```bash
docker run -d --name medeiros-db \
  -e MYSQL_ROOT_PASSWORD=senha123 \
  -e MYSQL_DATABASE=st_medeiros \
  -p 3309:3306 \
  -v medeiros_mysql_data:/var/lib/mysql \
  mysql:8.0
```

## Servir

```bash
php artisan serve --port=8000
```

## Instalação em hospedagem compartilhada

O projeto já é compatível com hospedagem compartilhada: **não há build de front** (Bootstrap e ícones
via CDN, CSS inline em `resources/views/layouts/app.blade.php`), os uploads ficam em pasta física
(sem symlink) e a thumbnail de PDF é gerada no navegador.

### Estrutura de pastas

Com raiz do domínio alterada para uma pasta externa (cPanel → Domínios → Alterar raiz):

```
/home/USUARIO/laravel/        -> conteúdo de medeiros/ (app, bootstrap, config, database,
                                 resources, routes, storage, vendor, artisan, .env)
/home/USUARIO/public_html/    -> conteúdo de medeiros/public/ (index.php, .htaccess,
                                 .user.ini, images, js, favicon.ico, robots.txt, storage/)
```

### Passos

```bash
# 1. enviar o código (vendor/ e public/storage estão no .gitignore)
cd /home/USUARIO/laravel
composer install --no-dev --optimize-autoloader

# 2. .env: APP_ENV=production, APP_DEBUG=false, APP_URL=https://www.dominio.com.br,
#    dados do MySQL do cPanel e o caminho físico dos uploads
# STORAGE_PUBLIC_PATH=/home/USUARIO/public_html/storage
php artisan key:generate

# 3. permissões
chmod -R 775 storage bootstrap/cache
chmod -R 755 /home/USUARIO/public_html/storage

# 4. banco (sem os usuários de teste do seeder)
php artisan migrate --force
php artisan db:seed --class=SiteSettingsSeeder
php artisan db:seed --class=PageContentsSeeder
php artisan db:seed --class=PageBlocksSeeder
php artisan db:seed --class=VagasSeeder

# 5. admin (o seeder cria usuários com a senha 123456, não use em produção)
php artisan tinker
>>> App\Models\User::create(['name' => 'Administrador', 'email' => 'seu@email.com', 'password' => Hash::make('senhaForte123'), 'role' => 'admin']);
```

Sem Composer no servidor, rode `composer install --no-dev --optimize-autoloader` localmente e envie
a pasta `vendor/`. Sem Git/SSH, envie um zip com `medeiros/` (sem `vendor/` e sem `.env`).

Se não for possível alterar a raiz do domínio, envie `medeiros/` para `public_html/laravel/`, copie o
conteúdo de `medeiros/public/` para `public_html/` e crie em `public_html/index.php`:

```php
<?php
define('LARAVEL_START', microtime(true));
$base = __DIR__ . '/laravel';
if (file_exists($m = $base . '/storage/framework/maintenance.php')) { require $m; }
require $base . '/vendor/autoload.php';
$app = require_once $base . '/bootstrap/app.php';
$app->handleRequest(Illuminate\Http\Request::capture());
```

### Cron

As ofertas expiradas são desativadas 1x/dia pelo agendador do Laravel:

```bash
* * * * * cd /home/USUARIO/laravel && php artisan schedule:run >> /dev/null 2>&1
```

### Atualizar o site

```bash
cd /home/USUARIO/laravel
git pull
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize:clear
```

## Usuários de teste (seeder)

Senha `123456` para todos:

| Role | Email |
|------|-------|
| admin | admin@medeiros.com.br |
| rh | rh@medeiros.com.br |
| marketing | marketing@medeiros.com.br |
| client | cliente@teste.com |

## Comandos úteis

```bash
# Desativar ofertas expiradas
php artisan ofertas:atualizar-status

# Regenerar thumbnails de PDFs (apenas se o servidor tiver Imagick ou Ghostscript)
php artisan ofertas:gerar-thumbs
```

## Thumbnail de PDF

A thumbnail é a imagem da 1ª página do PDF. Ela é gerada da seguinte forma:

1. **No navegador (padrão)** — ao anexar o PDF no formulário, o `public/js/pdf-thumb.js`
   renderiza a 1ª página com [PDF.js](https://mozilla.github.io/pdf.js/) (carregado do CDN,
   sem build) e envia o JPEG junto com a oferta. Ofertas antigas sem thumbnail podem ser
   processadas no painel: **Marketing › Ofertas › Gerar thumbnails**.
2. **No servidor (opcional)** — se o PHP tiver a extensão Imagick ou `exec()` + Ghostscript
   disponíveis, o `php artisan ofertas:gerar-thumbs` gera as thumbnails que faltam.

Hospedagens compartilhadas que bloqueiam `exec()` e não têm Imagick usam apenas o caminho 1,
e não precisam de nenhuma alteração no PHP.

## Agendamento (cron do Scheduler)

O comando `ofertas:atualizar-status` roda automaticamente 1x/dia via agendador do Laravel
(veja `routes/console.php`). Adicione no crontab:

```bash
* * * * * cd /caminho/para/site_medeiros/medeiros && php artisan schedule:run >> /dev/null 2>&1
```

## Créditos

Desenvolvido por [Carlos Lima Dev](https://github.com/EduardoLima03)