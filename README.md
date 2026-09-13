# 🛒 Site Medeiros Supermercado

Aplicação Laravel unificada do site institucional do Supermercado Medeiros: site público + módulo de RH + painéis administrativos em um único sistema.

```
site_medeiros/
└── medeiros/        # Laravel — Site público + Ofertas + Achados + RH + Admin
```

## Funcionalidades

- **Site público**: home com blocos editáveis (hero, texto, imagem, ofertas, achados, vagas, lojas, CTA app), páginas de lojas, sobre, ofertas da semana, achados e perdidos, trabalhe conosco e páginas dinâmicas
- **Painéis**:
  - `admin` — gerenciar blocos da home (adicionar/reordenar/editar), cores e textos, configurações, mídia e usuários
  - `rh` / `admin` — CRUD de vagas, gerenciamento de candidaturas e visualização/impressão de currículos
  - `marketing` / `admin` — gerenciar ofertas (imagem ou PDF) com vigência e itens de achados e perdidos
  - `client` — inscrição em vagas e cadastro de currículo (minha área com status das candidaturas)
- **Ofertas**: upload de imagem ou PDF; PDFs geram thumbnail automático da 1ª página
- **Achados e Perdidos**: cadastro pelo marketing/admin com foto, local e data; itens entregues somem do portal
- **Currículos**: formulário detalhado com upload de PDF e extração de texto via `smalot/pdfparser`
- **Candidaturas**: fluxo candidatado → analisando → selecionado_entrevista / recusado

## Requisitos

- PHP 8.2+
- [Ghostscript](https://www.ghostscript.com/) (para thumbnails de PDF)
- Composer
- MySQL (recomendado) ou SQLite

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

Dados já configurados no `.env`: `DB_HOST=127.0.0.1`, `DB_PORT=3309`, `DB_DATABASE=st_medeiros`, `DB_USERNAME=root`, `DB_PASSWORD=senha123`.

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

## Tutorial: como criar e editar páginas

Existem **3 formas** de criar/editar conteúdo, conforme o tipo de página:

### 1. Página inicial (home) → Blocos editáveis

Painel → **Administração → Blocos (Home)** (`/dashboard/admin/blocos`)

- **Adicionar bloco**: escolha o tipo (Banner/Hero, Texto, Imagem, Grid de Ofertas,
  Achados e Perdidos, Vagas, CTA App, Mapa de Lojas) e um título opcional
- **Editar**: clique no lápis para mudar título, conteúdo, imagem, link e ativar/desativar
- **Reordenar**: arraste os blocos e clique em "Salvar nova ordem"

É a forma mais visual — a ordem listada é exatamente a ordem exibida na home.

### 2. Páginas dinâmicas → Gerenciador de Páginas

Painel → **Administração → Páginas** (`/dashboard/admin/pages`)

- **Criar página**: informe um `slug` (ex: `promocoes`) e um título → ela fica disponível
  em `/pagina/promocoes`
- **Adicionar seção**: cada página pode ter várias seções; cada seção tem conteúdo editável
  com editor WYSIWYG
- **Editar/remover seções**: altere o texto ou exclua seções individualmente
- **Menu**: para exibir a página no menu, vá em **Administração → Menu** e adicione um item
  apontando para `/pagina/slug`

### 3. Páginas fixas (estruturais) → código

As páginas **Lojas**, **Sobre**, **Ofertas**, **Achados e Perdidos**, **Trabalhe conosco**
e **Currículo** são views Blade em `resources/views/site/*.blade.php` e **não são editáveis
pelo painel**. Para alterar o conteúdo é preciso editar o arquivo (ou usar "Aparência" para
as cores e "Configurações" para telefone/redes sociais/apps).

### Regra prática

| Quero editar...                  | Onde fazer                             |
|----------------------------------|----------------------------------------|
| Seções da home                   | Painel → Blocos (Home)                 |
| Página extra (ex: promocoes)     | Painel → Páginas + Menu                |
| Cores e textos globais           | Painel → Aparência / Configurações     |
| Conteúdo das páginas estruturais | Código (`resources/views/site/`)       |

## Comandos úteis

```bash
# Desativar ofertas expiradas
php artisan ofertas:atualizar-status

# Regenerar thumbnails de PDFs
php artisan ofertas:gerar-thumbs
```

## Agendamento (cron do Scheduler)

O comando `ofertas:atualizar-status` roda automaticamente 1x/dia via agendador do Laravel
(veja `routes/console.php`), desativando ofertas cuja `data_fim` já passou.

Adicione no crontab do usuário do servidor (`crontab -e`):

```bash
* * * * * cd /caminho/para/site_medeiros/medeiros && php artisan schedule:run >> /dev/null 2>&1
```

O agendador do Laravel é chamado a cada minuto e dispara as tarefas programadas (o `daily` executa 1x/dia).

Para validar sem esperar o horário agendado:

```bash
php artisan schedule:run
```

## Créditos

Desenvolvido por [Carlos Lima Dev](https://github.com/EduardoLima03)