# Guia de Uso — Painéis do Site Medeiros

Guia prático de uso do painel administrativo do site do Supermercado Medeiros, destinado aos perfis **admin**, **marketing** e **rh**.

> **Atenção:** o perfil de marketing no sistema é registrado como `marketing` (não existe o perfil "mkt"). Na tela de login o acesso é feito com o e-mail e senha cadastrados pelo administrador.

---

## 1. Acesso ao painel

1. Acesse a página de login do site: `/login`.
2. Informe seu **e-mail**, **senha** e clique em **Entrar**.
3. Após o login você será redirecionado automaticamente para o painel correspondente ao seu perfil:
   - **admin** → painel de administração (`/dashboard/admin`)
   - **marketing** → painel de marketing (`/dashboard/marketing`)
   - **rh** → painel de RH (`/dashboard/rh`)
4. Para sair, clique em **Sair** no menu lateral.

**Não tem login?** O cadastro público (`/register`) cria apenas contas do tipo **cliente** (para candidatura a vagas). Contas de admin, marketing e rh são criadas exclusivamente pelo administrador no painel de usuários.

### Menu lateral

O menu lateral muda conforme seu perfil:

| Perfil | Itens disponíveis |
|--------|-------------------|
| Todos | Dashboard, Alterar Senha, Ver Site |
| admin + rh | **Recursos Humanos**: Vagas, Currículos |
| admin + marketing | **Marketing**: Ofertas |
| admin | **Administração**: Blocos (Home), Aparência, Configurações, Mídia, Usuários |
| cliente | Minha Área: Meu Currículo, Ver Vagas |

> O perfil **admin** tem acesso a todas as seções (RH, Marketing e Administração).

---

## 2. Perfil: Administração (admin)

### 2.1 Dashboard

Acesse **Dashboard** no menu lateral. Mostra um resumo com contadores de páginas, seções, usuários e quantidade de usuários cadastrados.

### 2.2 Blocos da Home

Acesse **Administração → Blocos (Home)**. Os blocos são os componentes que montam a página inicial do site (banners, textos, carrosséis, promoções do app etc.).

- **Criar bloco:** clique em "Novo bloco", escolha o tipo e preencha os campos.
- **Tipos de bloco disponíveis:** `banner`, `texto`, `imagem`, `carrossel`, `ofertas`, `vagas`, `cta_app`, `mapa`, `promo_app`.
- **Editar:** clique no bloco desejado e altere o conteúdo; salve.
- **Reordenar:** use a função de reordenar para mudar a posição dos blocos na home.
- **Excluir:** remova o bloco quando não for mais necessário (ação irreversível).
- **Ativar/desativar:** cada bloco pode ficar ativo ou inativo sem precisar excluir.

**Slides do carrossel:** nos blocos do tipo `carrossel` é possível adicionar, editar, reordenar/mover e excluir slides com imagem e link.

### 2.3 Páginas e seções

Acesse **Administração → Páginas**. Permite gerenciar as páginas institucionais e as seções de conteúdo (`/pagina/{slug}`).

- **Criar página:** informe o nome e o slug (o slug define o endereço da página, ex.: `atendimento` → `/pagina/atendimento`).
- **Criar seção:** adicione seções de conteúdo dentro de uma página.
- **Editar conteúdo:** atualize o texto/conteúdo de cada seção e salve.
- **Excluir seção:** remova a seção quando não for mais necessária.

### 2.4 Menu de navegação

Acesse **Administração → Menu**. Edita os itens do menu de navegação do site público.

- **Adicionar item:** informe o título e o link/destino.
- **Mover item:** altere a ordem em que os itens aparecem no menu.
- **Remover item:** exclua o item do menu.

### 2.5 Aparência e Configurações

- **Aparência:** ajuste as cores do site (cor primária, secundária, texto, verde escuro, dourado).
- **Configurações:** atualize informações gerais exibidas no site:
  - Nome do site e descrição
  - Telefone central, WhatsApp, Instagram, Facebook
  - Links das lojas de aplicativos (Play Store / App Store)
  - CNPJ, links de portfólio/cadastro, link de currículos

Salve as alterações para aplicá-las imediatamente ao site público.

### 2.6 Mídia

Acesse **Administração → Mídia**. Biblioteca de imagens usadas no site.

- **Enviar imagem:** formato JPEG, PNG, JPG, GIF ou WEBP, máximo de **10 MB**.
- **Excluir imagem:** remova imagens que não estão mais em uso.

### 2.7 Usuários

Acesse **Administração → Usuários**. Gerencia as contas de acesso ao painel (contas de administrador não são listadas).

- **Criar usuário:** informe nome, e-mail, telefone, senha e a função. Funções permitidas para novos usuários: **rh**, **marketing** ou **cliente**.
- **Alterar função:** mude o perfil de um usuário (ex.: promover para rh ou marketing).
- **Alterar senha:** defina uma nova senha para o usuário.
- **Excluir usuário:** remova o acesso do usuário (não é possível excluir a própria conta).

### 2.8 Alterar a própria senha

Acesse **Alterar Senha** no menu lateral. Informe a senha atual, a nova senha (mínimo de 8 caracteres) e confirme. Ao salvar, você permanece conectado neste dispositivo e é desconectado dos demais.

---

## 3. Perfil: Marketing

### 3.1 Dashboard

Acesse **Dashboard**. Mostra a quantidade de ofertas ativas e o total de ofertas cadastradas.

### 3.2 Ofertas

Acesse **Marketing → Ofertas**. As ofertas publicadas aparecem na seção "Ofertas" do site público.

**Criar uma oferta:**
1. Acesse **Marketing → Ofertas → Nova oferta** (ou "Criar oferta").
2. Preencha:
   - **Título** da oferta
   - **Tipo:** `imagem` ou `pdf`
   - **Arquivo:** envie a imagem ou o PDF da oferta
     - Imagem: JPEG ou PNG
     - PDF: até **100 MB**
   - **Data de início** e **data de fim** (a oferta só aparece no site dentro desse período)
   - Marque **ativa** para publicar
3. Salve a oferta.

**Editar / excluir oferta:** use as opções de editar ou excluir na lista de ofertas.

**Ofertas em PDF — gerar miniatura:** após enviar um PDF, use o botão **"Gerar thumbnails"** para criar a imagem de prévia da oferta. Sem a miniatura, a oferta pode não ter imagem de destaque.

**Desativação automática:** ofertas com data de fim vencida são desativadas automaticamente pelo sistema. Você também pode desativar manualmente desmarcando o campo **ativa**.

---

## 4. Perfil: RH

### 4.1 Dashboard

Acesse **Dashboard**. Mostra o número de vagas abertas, total de vagas e total de currículos recebidos.

### 4.2 Vagas

Acesse **RH → Vagas**. Gerencia as vagas exibidas na página "Trabalhe Conosco" do site.

**Criar vaga:**
1. Acesse **RH → Vagas → Nova vaga**.
2. Preencha:
   - **Título** da vaga
   - **Descrição** (o que a vaga oferece, requisitos etc.)
   - **Imagem** (opcional, até **2 MB**)
   - **Status:** `aberta` ou `fechada`
3. Salve. A vaga com status **aberta** fica disponível para candidatura no site.

**Editar vaga:** altere título, descrição, imagem ou status (feche a vaga quando não houver mais interesse em candidatos).

**Excluir vaga:** remova a vaga definitivamente.

### 4.3 Candidaturas

Acesse **RH → Vagas** e clique em **"Candidaturas"** na vaga desejada. Lá você vê todos os candidatos daquela vaga e pode **atualizar o status** de cada candidatura:

| Status | Significado |
|--------|-------------|
| `candidatado` | Candidatura recebida (status inicial) |
| `analisando` | Currículo em análise |
| `selecionado_entrevista` | Selecionado para entrevista |
| `recusado` | Não selecionado |

> Observação: os candidatos também acompanham o status das próprias candidaturas no painel de cliente. Mantenha o status atualizado.

### 4.4 Currículos

Acesse **RH → Currículos**. Lista completa dos currículos enviados pelo site.

- **Download:** baixe o currículo em PDF.
- **Imprimir:** abra a versão otimizada para impressão do currículo.

---

## 5. Dúvidas frequentas

**Esqueci minha senha / preciso redefinir a senha**
Peça a um administrador para alterar sua senha em **Administração → Usuários → Alterar senha**. Não há redefinição por e-mail.

**Não consigo acessar uma área do painel**
Verifique se seu perfil tem a permissão necessária. Se o acesso estiver errado, um administrador pode alterar sua função em **Administração → Usuários**.

**A oferta que publiquei não aparece no site**
Confirme que: a oferta está **ativa**, o período (início/fim) está vigente e o arquivo foi enviado corretamente. Ofertas vencidas são desativadas automaticamente.

**Enviei um PDF e não tem imagem de prévia**
Use o botão **"Gerar thumbnails"** na edição da oferta para gerar a miniatura.

**A imagem do bloco/oferta não está sendo salva**
Verifique os limites de upload: mídia admin 10 MB, bloco/slide 8 MB, vaga 2 MB, currículo 5 MB, oferta PDF 100 MB.

**Posso excluir um usuário administrador?**
Não. Contas com função admin não aparecem na lista de usuários e não podem ser excluídas pelo painel.

---

## 6. Referência rápida de limites de upload

| Onde | Arquivo | Limite |
|------|---------|--------|
| Oferta (marketing) | Imagem JPEG/PNG ou PDF | PDF até 100 MB |
| Bloco / slide (home) | Imagem | 8 MB |
| Vaga (rh) | Imagem | 2 MB |
| Currículo (cliente) | PDF | 5 MB |
| Mídia (admin) | Imagem JPEG/PNG/JPG/GIF/WEBP | 10 MB |
