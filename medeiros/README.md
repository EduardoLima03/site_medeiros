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