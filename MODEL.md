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

Todos com `show_in_rest: true`, `supports: title, editor, thumbnail, page-attributes`
(o `menu_order` controla a ordem e alimenta a numeração 01…06 exibida nos cards).

| CPT | Slug | Onde aparece | Campos | Campanha? |
|-----|------|--------------|--------|-----------|
| Sinais de alerta | `drm_sinal` | Seção "Sinais de alerta" | título, descrição (`post_content`), ordem | sim |
| Evidências / Benefícios | `drm_beneficio` | LP1 "O que o exame permite identificar" · LP2 "O que esperar do tratamento" | título, descrição, ordem | sim |
| Etapas do atendimento | `drm_etapa` | "Como funciona o seu atendimento" | título, descrição, ordem | sim |
| Pilares da consulta | `drm_pilar` | Seção "Diferencial" | título, descrição, ordem | sim |
| Perguntas frequentes | `drm_faq` | Accordion FAQ | pergunta (título), resposta, ordem | sim |
| Depoimentos | `drm_depoimento` | Seção depoimentos | citação, iniciais, mês/ano, verificada (bool) | não — compartilhado |
| Trajetória | `drm_formacao` | "Trajetória acadêmica e profissional" | título, instituição, ordem | não — compartilhado |
| Fotos do consultório | `drm_foto` | Carousel | imagem (featured), legenda, ordem | não — compartilhado |

**Contagem no Figma (LP1):** 6 sinais · 4 evidências · 4 etapas · 4 pilares · 8 FAQs ·
3 depoimentos · 7 itens de trajetória.

### Taxonomia

`drm_campanha` — hierárquica, aplicada a `drm_sinal`, `drm_beneficio`, `drm_etapa`,
`drm_pilar`, `drm_faq`. Termos iniciais: **`preenchimento`**, **`liftera`**.

Cada template de LP consulta seu CPT filtrando por esse termo. Adicionar uma LP nova = criar
um termo, não um post type.

---

## 3. Customizer (`theme_mod`) — global, vale para as duas LPs

| Seção | Setting | Valor no Figma |
|-------|---------|----------------|
| Contato | `drm_whatsapp` | `(11) 94912-8259` |
| Contato | `drm_whatsapp_msg` | texto pré-preenchido do link `wa.me` |
| Contato | `drm_email` | `dr.romulo.contato@gmail.com` |
| Contato | `drm_instagram` | `@romulo.dermato` |
| Localização | `drm_clinica` | EviDenS Clinic |
| Localização | `drm_endereco` | Rua Dr. Diogo de Faria, 1087 — conj. 901-904 |
| Localização | `drm_bairro` | Vila Clementino, São Paulo/SP |
| Localização | `drm_maps_url` | link do Google Maps |
| Responsável técnico | `drm_medico_nome` | Dr. Rômulo Malaquias |
| Responsável técnico | `drm_crm` | **`CRM-SP 00000`** ⚠️ |
| Responsável técnico | `drm_rqe` | **`RQE 00000`** ⚠️ |
| Responsável técnico | `drm_diretor_tecnico` | **placeholder** ⚠️ |
| Legal | `drm_disclaimer` | texto informativo do rodapé |
| Identidade | `drm_logo` | upload |

> ⚠️ **Pendência bloqueante para publicação.** CRM, RQE e diretor técnico estão como `00000` /
> "Nome completo do médico" no Figma. A Resolução CFM 1.974/2011 exige nome, CRM e RQE reais em
> publicidade médica. O tema deve renderizar esses campos a partir do Customizer, e os valores
> reais precisam ser preenchidos antes do site ir ao ar. Não inventar valores.

---

## 4. Meta fields por página (LP)

Conteúdo único de cada LP — meta box nativo no editor da página, sem dependência de plugin.

| Bloco | Campos |
|-------|--------|
| Hero | `eyebrow`, `headline`, `subtitulo`, `paragrafo_apoio`, `cta_label`, `microcopy`, `imagem`, `badge_titulo`, `badge_texto` |
| Intro de seção (×5) | `eyebrow`, `titulo`, `descricao` — um conjunto por seção de listagem |
| Nota de rodapé de seção | `nota` (ex.: alerta de urgência médica em Sinais de alerta) |
| CTA intermediária | `eyebrow`, `headline`, `texto`, `botao_label`, `microcopy` |
| CTA final | `headline`, `texto`, `botao_label`, `microcopy` |
| Sobre o médico | `bio`, `foto`, `nome_exibido`, `cargo` |

---

## 5. Páginas e templates

| Página | Template | Conteúdo |
|--------|----------|----------|
| Home → LP Preenchimento | `front-page.php` | LP1 (`7075:28`) |
| LP Liftera | `page-liftera.php` | LP2 (`7002:24`) |
| Política de Privacidade | `page.php` | `post_content` rico |
| Termos de Uso | `page.php` | `post_content` rico |

---

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
