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

## Comandos úteis

```bash
# Desativar ofertas expiradas
php artisan ofertas:atualizar-status

# Regenerar thumbnails de PDFs
php artisan ofertas:gerar-thumbs
```

## Créditos

Desenvolvido por [Carlos Lima Dev](https://github.com/EduardoLima03)