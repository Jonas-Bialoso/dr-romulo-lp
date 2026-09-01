# Modelo de dados — Dr. Rômulo Malaquias (Dermatologia)

Documento da **Fase 0.0** da skill `figma-to-pixel-perfect-v2`. Define CPTs, taxonomia,
Customizer e meta fields **antes** de escrever código, para que o HTML estático já saia com
a estrutura que o tema WordPress vai consumir.

- **Arquivo Figma:** `OFVtBmgdhjLf16MFpf9LOp` — Dr. Rômulo Dermatologista
- **Slug do tema:** `dr-romulo`
- **Prefixo:** `drm_`
- **Extração:** API REST do Figma (MCP indisponível — sem autorização OAuth nesta sessão)

---

## 1. As duas landing pages

O projeto são **duas LPs distintas**, com estrutura de seções paralela mas conteúdo
totalmente diferente. Isso é o fato que estrutura todo o modelo.

| # | LP | Frame Figma | Tema | Headline | Status |
|---|----|-------------|------|----------|--------|
| 1 | Retirada de preenchimento | `7075:28` (1440×9443) | Hialuronidase guiada por ultrassom | "Antes de dissolver, é preciso enxergar." | **concluída** — `index.html` |
| 2 | Liftera | `7002:24` (1440×11214) | Ultrassom microfocado / flacidez | "Quando o rosto começa a perder sustentação…" | **concluída** — `liftera.html` |

### Publicação

GitHub Pages, branch `main`, raiz do repositório:

- LP1 — https://jonas-bialoso.github.io/dr-romulo-lp/
- LP2 — https://jonas-bialoso.github.io/dr-romulo-lp/liftera.html
- Repositório — https://github.com/Jonas-Bialoso/dr-romulo-lp

**O repositório é público**, exigência do GitHub Pages no plano gratuito. As fotos do
médico e do consultório, e os placeholders de CRM, estão acessíveis na internet aberta e
são indexáveis. Trocar para privado exige GitHub Pro ou outra hospedagem.

### Componentes compartilhados entre as duas LPs

Header, sobre-o-médico, carrossel do consultório e depoimentos são os mesmos COMPONENT do
Figma. O montador (`scratchpad/montar-lp2.mjs`) extrai esses blocos do `index.html` e os
insere no `liftera.html` sem tocar em um caractere — a Fase 3 da skill proíbe regerar
componente compartilhado a partir do Figma, porque isso introduz drift.

**Uma exceção deliberada:** a âncora do item "O que é o Liftera" no menu. Ela precisa
resolver na página em que está, então aponta para `#por-que-ultrassom` na LP1 e para
`#o-que-e-o-liftera` na LP2. É o único ponto de divergência.

O rodapé **não** é byte-idêntico: a instância do Figma sobrescreve o disclaimer (a LP2
menciona a Anvisa) e a linha do responsável técnico.

### Estado da LP1 (estático)

`index.html` + `assets/css/style.css`, todas as 13 seções validadas por diff numérico
contra a API do Figma. Altura total renderizada: **9434px contra 9443px do Figma** (0,095%).
Desvio absoluto somado das 13 seções: 18px — todo ele arredondamento de inteiros do próprio
Figma (ver seção 8 abaixo). Zero erros de console, zero imagens quebradas, zero 404,
sem scroll horizontal.

**Correções feitas depois da primeira revisão do cliente:**

1. **Largura do conteúdo (token `--gutter`).** Acima de 1440px o `--section-px` satura em
   112px, então header, rodapé, "sobre o médico" e os carrosséis grudavam na borda
   enquanto as demais seções centralizavam em 1216 — em 1685px o desalinhamento do menu
   era de 122px. Resolvido com
   `--gutter: max(var(--section-px), calc((100% - var(--content-w)) / 2))`.
2. **Carrosséis funcionais.** Viewport com scroll real, setas ancoradas fora dele (dentro
   rolariam junto), dots gerados por JS a partir da contagem real de páginas, teclado e
   `prefers-reduced-motion`. Com apenas 3 depoimentos não há o que rolar e os controles se
   escondem sozinhos; aparecem quando o CPT tiver um 4º.
3. **"Sobre o médico" centralizado.** Gap de 80 → 56, fechando em 1216 exatos com as
   colunas nos 580 projetados. Diverge do Figma (que soma 1240) por decisão do cliente.
4. **Peso dos assets: 15,73 MB → 1,36 MB (−91%).** As fotos estavam em PNG @2x — formato
   errado para conteúdo fotográfico. Convertidas para JPEG q82; o fundo dos CTAs, que fica
   atrás de um overlay 90% opaco, foi reduzido para 1920px e q62. 13 imagens abaixo da
   dobra com `loading="lazy"`.

**Pendências conhecidas da LP1:**

1. **Rótulo "O que é o Liftera" no menu** — o componente de header é compartilhado com a
   LP2 e ficou com o texto dela. A âncora foi apontada para `#por-que-ultrassom` para o
   link não morrer, mas o texto é decisão de conteúdo do cliente.
2. **Alt text do carrossel** — as 8 fotos usam alt indexado genérico
   ("Consultório na EviDenS Clinic — foto N de 8"). Vale descrever cada uma.
3. **CRM/RQE placeholder** (ver seção 3).
4. **As quatro correções acima não foram validadas em navegador** — o painel de preview
   travou e não voltou. HTML e JS validados por fora (tags balanceadas, `node --check`),
   e todos os 46 assets referenciados existem em disco.

> **Atenção aos nomes de frame.** Os nomes no Figma estão obsoletos e enganam. Em LP1, o frame
> `o-que-e-o-liftera` contém "Como funciona o seu atendimento" (nada de Liftera), e
> `sinais-de-alerta` trata de complicações de preenchimento. Sempre conferir o conteúdo real,
> nunca o nome do node.

**Decisão-chave:** conteúdos repetitivos viram CPT **compartilhado entre as duas LPs**,
segmentado pela taxonomia `drm_campanha`. A alternativa (um CPT por LP) duplicaria oito
post types e quebraria na terceira LP.

---

## 2. Custom Post Types

Registrados em `inc/cpts.php` por uma tabela única (`drm_tipos()`), todos com
`show_in_rest: true` e `supports: title, editor, thumbnail, page-attributes`.
O `menu_order` controla a ordem e alimenta a numeração 01…06 exibida nos cards.

| CPT | Slug | Onde aparece | Campanha? |
|-----|------|--------------|-----------|
| Sinais de alerta | `drm_sinal` | Seção "Sinais de alerta" (cards de ícone na LP1, cards de foto na LP2) | sim |
| Benefícios / Objetivos | `drm_beneficio` | LP1 "O que o exame permite identificar" (lista numerada) · LP2 "O que esperar do tratamento" (grade de fotos) | sim |
| Mecanismo de ação | `drm_mecanismo` | LP2 "O que é o Liftera" — lista numerada que explica o aparelho | sim |
| Etapas do atendimento | `drm_etapa` | "Como funciona o seu atendimento" (timeline) | sim |
| Pilares da consulta | `drm_pilar` | Seção "Diferencial" | sim |
| Perguntas frequentes | `drm_faq` | Accordion | sim |
| Depoimentos | `drm_depoimento` | Carrossel de depoimentos | não — compartilhado |
| Trajetória | `drm_formacao` | "Trajetória acadêmica e profissional" | não — compartilhado |
| Fotos do consultório | `drm_foto` | Carrossel + lightbox | não — compartilhado |

Metas de item, gravadas pelo seeder e editáveis no admin: `drm_icone` (nome do SVG em
`assets/icons/`), `drm_badge_escuro` (badge "Verificado" em variante escura) e `drm_data`
(mês/ano do depoimento, instituição da formação).

**Contagem real do conteúdo importado:** 6+6 sinais · 4+6 benefícios · 3 mecanismos ·
4+4 etapas · 4+4 pilares · 8+8 FAQs · 3 depoimentos · 7 formações · 8 fotos.

### Taxonomia

`drm_campanha` — hierárquica, aplicada a `drm_sinal`, `drm_beneficio`, `drm_mecanismo`,
`drm_etapa`, `drm_pilar` e `drm_faq`. Termos: **`preenchimento`** e **`liftera`**.

Cada template lê `drm_campanha_slug` do meta box da página e filtra por esse termo.
Adicionar uma LP nova = criar um termo, não um post type.

---

## 3. Customizer (`theme_mod`) — global, vale para as duas LPs

Definido em `inc/customizer.php` por `drm_campos_customizer()`, que também carrega os
defaults lidos por `drm_opt()` — não há default duplicado em dois lugares.

| Seção | Setting | Valor de origem |
|-------|---------|-----------------|
| Contato | `drm_whatsapp` | `(11) 94912-8259` |
| Contato | `drm_whatsapp_msg` | texto pré-preenchido do link `wa.me` |
| Contato | `drm_telefone` | telefone do consultório |
| Contato | `drm_email` | `dr.romulo.contato@gmail.com` |
| Contato | `drm_instagram` | `@romulo.dermato` |
| Localização | `drm_clinica` | EviDenS Clinic |
| Localização | `drm_endereco` | Rua Dr. Diogo de Faria, 1087 — conj. 901-904 |
| Localização | `drm_bairro` | Vila Clementino, São Paulo/SP |
| Localização | `drm_maps` | link do Google Maps |
| Responsável técnico | `drm_medico_nome` | Dr. Rômulo Malaquias |
| Responsável técnico | `drm_crm` | **`CRM-SP 00000`** ⚠️ |
| Responsável técnico | `drm_rqe` | **`RQE 00000`** ⚠️ |
| Responsável técnico | `drm_diretor` | **placeholder** ⚠️ |
| Legal | `drm_disclaimer` | texto informativo do rodapé |
| Legal | `drm_privacidade` / `drm_termos` | URLs das páginas legais |
| Identidade | `drm_logo_branco` | upload do logo do header |

> ⚠️ **Pendência bloqueante para publicação.** CRM, RQE e diretor técnico saem como `00000` /
> "Diretor técnico da clínica (nome + CRM)". A Resolução CFM 1.974/2011 exige nome, CRM e RQE
> reais em publicidade médica. **Não inventar valores.** Enquanto forem placeholder,
> `drm_aviso_crm()` mostra um `notice-error` em todas as telas do admin, com link direto para
> a seção do Customizer. O aviso some sozinho quando os três forem preenchidos.

---

## 4. Meta fields por página (LP)

Meta box nativo (`inc/meta-boxes.php`), sem ACF. Um bloco por seção, labels em português.
`drm_meta()` lê com fallback, então uma LP nova sem os campos preenchidos não quebra.

| Bloco | Campos |
|-------|--------|
| Campanha | `drm_campanha_slug` |
| Hero | `drm_hero_eyebrow`, `drm_hero_titulo`, `drm_hero_titulo_px`, `drm_hero_lead`, `drm_hero_apoio`, `drm_hero_cta`, `drm_hero_micro`, `drm_hero_badge_tit`, `drm_hero_badge_txt` |
| Sinais | `drm_sinais_eyebrow`, `drm_sinais_titulo`, `drm_sinais_lead`, `drm_sinais_callout`, `drm_sinais_layout` (`icone` \| `foto`) |
| Benefícios | `drm_benef_eyebrow`, `drm_benef_titulo`, `drm_benef_intro`, `drm_benef_rotulo`, `drm_benef_lead`, `drm_benef_callout`, `drm_benef_layout`, e `drm_benef_eyebrow_2` / `drm_benef_titulo_2` para a segunda seção de benefícios da LP2 |
| Etapas | `drm_etapas_eyebrow`, `drm_etapas_titulo`, `drm_etapas_lead` |
| Diferencial | `drm_dif_eyebrow`, `drm_dif_titulo`, `drm_dif_texto`, `drm_dif_rotulo` |
| CTA do meio | `drm_ctam_eyebrow`, `drm_ctam_titulo`, `drm_ctam_texto`, `drm_ctam_botao`, `drm_ctam_micro` |
| CTA final | `drm_ctaf_titulo`, `drm_ctaf_texto`, `drm_ctaf_botao`, `drm_ctaf_micro` |
| FAQ | `drm_faq_eyebrow`, `drm_faq_titulo`, `drm_faq_botao` |

`drm_hero_titulo_px` guarda o tamanho do título em px porque as duas LPs usam corpos
diferentes no mesmo componente (56 na LP1, 52 na LP2) — é o único caso em que o conteúdo
carrega uma medida.

**Total gravado pelo seeder:** 37 metas na home, 41 na LP2, nenhuma vazia.

---

## 5. Páginas e templates

| Página | Slug | Template | Conteúdo |
|--------|------|----------|----------|
| Home → LP Preenchimento | `home` | `front-page.php` | LP1 (`7075:28`) |
| LP Liftera | `liftera` | `page-liftera.php` (Template Name: LP Liftera) | LP2 (`7002:24`) |
| O tratamento | `o-tratamento` / `o-tratamento-liftera` | — | páginas-suporte, servem só para carregar a imagem destacada da seção de duas colunas |

`index.php` existe como fallback obrigatório do WordPress e apenas redireciona o loop
para o template certo.

## 6. Decisões técnicas

| Decisão | Escolha | Motivo |
|---------|---------|--------|
| Campos customizados | **Meta box nativo** | Sem dependência de plugin (ACF). Default da skill. |
| Updates do tema | **Git Updater** | `GitHub Theme URI` no `style.css` desde o início. |
| Seeder | **One-click** | Importa os assets do Figma para a Mídia, cria os CPTs com o conteúdo real, cria as páginas e configura `show_on_front`. |
| Operador do admin | Cliente leigo | Meta boxes com labels em português e ordem por `menu_order`. |
| Mobile | **Fluido inferido** | Os frames mobile do Figma continuam vazios (375×800, zero filhos). O responsivo foi inferido, não traduzido de comp — **precisa ser reconferido quando o designer entregar o mobile**. |

### Breakpoints

| Faixa | O que muda |
|-------|-----------|
| ≥ 1200px | Desktop como no Figma, conteúdo travado em 1216 |
| ≤ 1199px | Larguras fixas em px viram fluidas; imagens passam a `aspect-ratio`; as imagens absolutas dos callouts são ocultadas (posicionadas em px, colidiriam com o texto) |
| ≤ 1023px | Menu vira hambúrguer (`.nav-toggle` + `is-open`, com Escape e fechamento ao clicar num item) |
| ≤ 899px | Seções de duas colunas empilham; grades caem para 2 colunas; sticky da foto desliga; linha conectora da timeline some |
| ≤ 599px | Uma coluna; CTAs em largura total; escala tipográfica reduzida; setas de carrossel somem (fica arrasto + dots) |

Efeito colateral bom: no mobile os 3 depoimentos passam a transbordar (320px cada
contra ~329px de viewport), então **o carrossel de depoimentos finalmente pagina** —
3 dots, arrasto e clique funcionando.

Duas armadilhas que apareceram e estão resolvidas, mas vale saber:

1. `.about__media` precisa continuar `position: relative` quando o sticky desliga. Como
   `static`, o badge do médico perdia o bloco de contenção e ia parar em cima do hero.
2. `.callout--hug .callout__main` tem especificidade maior que a regra fluida geral e
   mantinha a largura de conteúdo, estourando a viewport a 1024px na LP2.

---

## 7. Tokens estruturais (Fase 0.5)

Extraídos do frame `7075:28` — não presumidos.

| Token | Valor | Origem |
|-------|-------|--------|
| `--frame-w` | `1440px` | `absoluteBoundingBox.width` do frame raiz |
| `--content-w` | `1216px` | filho interno `w=1216` em `x=112` (1440 − 112×2) |
| `--section-px` | `clamp(24px, 7.78vw, 112px)` | `paddingLeft/Right = 112` → 112/1440 = 7.78vw |
| `--content-gap` | `80px` | `itemSpacing` padrão das seções |

Padding vertical das seções: `80px` (padrão), `100px` (diferencial-v2), `120px` (CTA intermediária).

### Paleta

| Token | Hex | Uso |
|-------|-----|-----|
| `--c-primary` | `#01012C` | Texto principal, fundos escuros, bordas — 107 usos |
| `--c-cream` | `#FAF8F5` | Fundo das seções |
| `--c-white` | `#FFFFFF` | Fundo de cards |
| `--c-amber` | `#FFB000` | Acento / CTA |
| `--c-body` | `#5D6066` | Texto corrido |
| `--c-ink` | `#1A221E` | Títulos alternativos |
| `--c-border` | `#D9D4CC` | Bordas sutis |
| `--c-footer` | `#000014` | Fundo do rodapé |

### Tipografia

**Inter** em 100% dos nós de texto. Escala: 48 (h1 LP1) · 44 (CTA) · 36 · 32 (h2) · 18 · 16 · 15 · 14 · 13 · 12.

---

## 8. Divergências sistemáticas Figma → browser

Três padrões apareceram repetidamente durante a implementação. Documentados aqui porque
vão reaparecer na LP2 e em qualquer alteração de copy.

**1. O Figma arredonda `line-height` para cima, por linha.** Um texto de 16px/25,6 com 13
linhas é reportado pela API como 370px (13 × 26), mas o browser renderiza 332,8 (13 × 25,6).
É a origem de praticamente todo o desvio residual das seções. Não é erro de implementação
e não deve ser "corrigido" — forçar a altura quebraria o fluxo do texto.

**2. O design não tem folga nas quebras de texto pequeno.** Três linhas transbordavam seus
containers por 0,2 a 0,47px, e cada uma custava uma linha inteira — 13px a mais na altura
do bloco. Compensado com `letter-spacing: -.01em` nos elementos afetados
(`.tech-badge__text`, `.hero__microcopy-text`). **Qualquer edição nesses textos reabre o
problema.** Ao mexer em copy, remedir.

**3. `textCase: UPPER` não aparece no conteúdo do nó.** 15 nós de texto do arquivo usam
caixa alta via estilo, e vários guardam o texto em caixa mista — o eyebrow do hero é
"Retirada de preenchimento guiada por ultrassom" no conteúdo e aparece em CAIXA ALTA no
render. A caixa alta tem que vir do CSS (`text-transform: uppercase`).

Vale registrar também que **os nomes dos frames no Figma estão obsoletos** e enganam com
frequência: `o-que-e-o-liftera` contém "Como funciona o seu atendimento", os 8 slides do
carrossel se chamam `Clinic_Photo_4` mas são 8 imagens distintas, e os dois textos da
coluna Localização do rodapé têm os nomes trocados entre si. Sempre conferir `characters`
e `imageRef`, nunca o nome do nó.

---

## 9. O tema WordPress

Fica em `theme/dr-romulo/`. É o mesmo HTML e o mesmo CSS das LPs estáticas — o CSS não foi
reescrito, foi copiado. Quem muda é só a origem do conteúdo: o que estava escrito no HTML
agora vem de CPT, meta ou Customizer.

```
theme/dr-romulo/
├── style.css              cabeçalho do WP + GitHub Theme URI (Git Updater)
├── functions.php          constantes, setup, enfileiramento com cache-bust por filemtime
├── header.php             menu, logo, CTA — âncoras resolvidas por página
├── footer.php             contato, endereço, responsável técnico, disclaimer
├── index.php              fallback obrigatório
├── front-page.php         LP1
├── page-liftera.php       LP2 (Template Name: LP Liftera)
├── inc/
│   ├── cpts.php           9 CPTs + taxonomia, tabela única
│   ├── customizer.php     5 seções; é também a fonte dos defaults
│   ├── meta-boxes.php     meta box nativo, um bloco por seção
│   ├── helpers.php        drm_opt, drm_itens, drm_meta, drm_botao, drm_icone, drm_imagem…
│   ├── secoes.php         as 14 funções de render — o coração do tema
│   ├── seeder.php         Ferramentas → Popular site
│   └── dados-seed.php     conteúdo das duas LPs, gerado do HTML estático
└── assets/                css, js, images, icons — cópia dos estáticos (62 arquivos)
```

### O seeder

`Ferramentas → Popular site`, um clique. Cria as duas campanhas, importa as imagens de
`assets/images/` para a Mídia, cadastra todos os itens dos CPTs, cria as páginas com os
meta fields preenchidos e aponta `show_on_front` para a home.

- **Idempotente nas imagens e nas páginas:** cada anexo importado ganha `_drm_origem` com o
  nome do arquivo, e `drm_achar_anexo()` reaproveita em vez de duplicar; páginas existentes
  são detectadas por slug e puladas.
- **Não é idempotente nos itens dos CPTs.** Rodar duas vezes cria os posts de novo. A tela
  avisa e exige confirmação depois da primeira execução.

`inc/dados-seed.php` é **gerado**, não escrito à mão — `scratchpad/gerar-seed.mjs` lê o
`index.html` e o `liftera.html` e extrai o conteúdo. Se o texto das LPs mudar, rode o
gerador de novo em vez de editar o PHP.

### Onde o conteúdo mora

| Tipo de conteúdo | Onde | Exemplo |
|---|---|---|
| Repetível e listado | CPT + `menu_order` | os 6 sinais de alerta |
| Único da página | meta box da página | o headline do hero |
| Igual nas duas LPs | Customizer | WhatsApp, endereço, CRM |
| Foto do médico, fundos de CTA | `assets/images/` do tema | não é conteúdo editável |
| Fotos do consultório e dos cards | Mídia, via imagem destacada | trocáveis pelo cliente |

### O que ainda não foi verificado

O PHP **nunca rodou contra um WordPress real** — não existe runtime PHP nesta máquina.
O que foi verificado é estrutural (`scratchpad/checar-php.mjs`): chaves e parênteses
balanceados com consciência de string e comentário, todas as 44 funções `drm_*` chamadas
têm definição, e todos os `require_once` do `functions.php` resolvem. Isso pega erro de
digitação e função ausente; **não pega** erro de runtime do WP — nome de hook errado,
argumento em ordem trocada, retorno inesperado de `get_posts()`.

Instalar em um WordPress de teste, rodar o seeder e comparar contra as LPs estáticas é o
próximo passo real.
