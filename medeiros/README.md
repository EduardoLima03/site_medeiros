# 🛒 Site Medeiros Supermercado

Site institucional do Supermercado Medeiros com sistema de gestão de ofertas, vagas de emprego e candidaturas.

## Funcionalidades

- **Site público**: home, lojas, ofertas da semana, trabalhe conosco, sobre
- **Painéis por role**:
  - `admin` — gerenciar cores, textos do site e usuários
  - `rh` — vagas de emprego + candidaturas com currículos
  - `marketing` — ofertas (imagem ou PDF) com vigência
  - `client` — inscrição em vagas e acompanhamento de status
- **Ofertas**: upload de imagem ou PDF; PDFs geram thumbnail automático da 1ª página
- **Currículos**: formulário detalhado com extração de texto de PDF via `smalot/pdfparser`
- **Candidaturas**: fluxo candidatado → analisando → selecionado_entrevista / recusado

## Requisitos

- PHP 8.2+
- [Ghostscript](https://www.ghostscript.com/) (para thumbnails de PDF)
- Composer
- SQLite (padrão) ou MySQL

## Instalação

```bash
git clone git@github.com:EduardoLima03/site_medeiros.git
cd site_medeiros
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

## Servir

```bash
php artisan serve
```

Usa o `ServeCommand` personalizado com limites de upload (`upload_max_filesize=100M`, `post_max_size=105M`).

## Usuários de teste (seeder)

| Role | Email | Senha |
|------|-------|-------|
| admin | admin@medeiros.com | 123456 |
| rh | rh@medeiros.com | 123456 |
| marketing | marketing@medeiros.com | 123456 |
| client | cliente@medeiros.com | 123456 |

## Comandos úteis

```bash
# Desativar ofertas expiradas
php artisan ofertas:atualizar-status

# Regenerar thumbnails de PDFs
php artisan ofertas:gerar-thumbs
```

## Créditos

Desenvolvido por [Carlos Lima Dev](https://github.com/EduardoLima03)
