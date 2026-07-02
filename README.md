# 🛒 Site Medeiros Supermercado

Monorepo do site institucional do Supermercado Medeiros, dividido em duas aplicações Laravel:

- [`medeiros/`](./medeiros) — Site principal com páginas institucionais, ofertas e painel admin/marketing
- [`medeiros-rh/`](./medeiros-rh) — Módulo de RH com vagas e candidaturas

---

## 📦 Estrutura

```
site_medeiros/
├── medeiros/           # Laravel — Site público + Ofertas + Admin
└── medeiros-rh/        # Laravel — Vagas + Currículos + Candidaturas
```

### medeiros (site principal)

- **Site público**: home, lojas, ofertas da semana, sobre, páginas dinâmicas
- **Painéis**:
  - `admin` — gerenciar cores, textos do site, páginas, menu e usuários
  - `marketing` — gerenciar ofertas (imagem ou PDF) com vigência
- **Ofertas**: upload de imagem ou PDF; PDFs geram thumbnail automático da 1ª página
- Redireciona `/trabalhe_conosco` para o `medeiros-rh`

### medeiros-rh (módulo RH)

- **Site público**: home com listagem de vagas
- **Painéis**:
  - `rh` / `admin` — CRUD de vagas, gerenciamento de candidaturas e currículos
  - `client` — inscrição em vagas e cadastro de currículo
- **Currículos**: formulário detalhado com upload de PDF e extração de texto via `smalot/pdfparser`
- **Candidaturas**: fluxo candidatado → analisando → selecionado_entrevista / recusado

## Requisitos

- PHP 8.2+
- [Ghostscript](https://www.ghostscript.com/) (para thumbnails de PDF no `medeiros`)
- Composer
- SQLite (padrão) ou MySQL

## Instalação

```bash
git clone git@github.com:EduardoLima03/site_medeiros.git
cd site_medeiros

# Configurar medeiros (site principal)
cd medeiros
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
cd ..

# Configurar medeiros-rh (módulo RH)
cd medeiros-rh
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
cd ..
```

## Servir

```bash
# Terminal 1 — Site principal
cd medeiros && php artisan serve --port=8000

# Terminal 2 — Módulo RH
cd medeiros-rh && php artisan serve --port=8001
```

Ambos usam o `ServeCommand` personalizado com limites de upload (`upload_max_filesize=100M`, `post_max_size=105M`).

Configure a variável `RH_SITE_URL` no `.env` do `medeiros` apontando para a URL do `medeiros-rh` (ex: `http://localhost:8001`).

## Usuários de teste (seeder)

Disponíveis em ambas as aplicações:

| Role | Email | Senha |
|------|-------|-------|
| admin | admin@medeiros.com | 123456 |
| rh | rh@medeiros.com | 123456 |
| marketing | marketing@medeiros.com | 123456 |
| client | cliente@medeiros.com | 123456 |

## Comandos úteis

No diretório `medeiros`:

```bash
# Desativar ofertas expiradas
php artisan ofertas:atualizar-status

# Regenerar thumbnails de PDFs
php artisan ofertas:gerar-thumbs
```

## Créditos

Desenvolvido por [Carlos Lima Dev](https://github.com/EduardoLima03)
