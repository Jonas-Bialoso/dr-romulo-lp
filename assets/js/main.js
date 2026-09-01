/* ==========================================================================
   Dr. Rômulo Malaquias — carrosséis

   Dirigido pelo DOM real: mede o passo a partir da posição dos slides, quantos
   cabem no viewport e quantas páginas isso dá. Nada de contagem fixa — se o
   CMS adicionar ou remover itens, a paginação acompanha.

   Marcação esperada:
     [data-carousel]
       [data-carousel-viewport]   ← container com overflow-x
         <track>                  ← primeiro filho: flex com os slides
       [data-carousel-prev] / [data-carousel-next]
       [data-carousel-dots]       ← preenchido por JS
   ========================================================================== */
(function () {
  'use strict';

  var semMovimento = window.matchMedia('(prefers-reduced-motion: reduce)');

  function initCarousel(root) {
    var viewport = root.querySelector('[data-carousel-viewport]');
    if (!viewport) return;

    var track = viewport.firstElementChild;
    if (!track) return;

    var prev = root.querySelector('[data-carousel-prev]');
    var next = root.querySelector('[data-carousel-next]');
    var caixaDots = root.querySelector('[data-carousel-dots]');
    var dots = [];

    function slides() {
      return Array.prototype.slice.call(track.children);
    }

    // Distância entre as bordas esquerdas de dois slides (largura + gap).
    // Medido do DOM para não depender de constantes do CSS.
    function passo() {
      var s = slides();
      if (s.length < 2) return s.length ? s[0].getBoundingClientRect().width : 0;
      return s[1].getBoundingClientRect().left - s[0].getBoundingClientRect().left;
    }

    function maxScroll() {
      return Math.max(0, viewport.scrollWidth - viewport.clientWidth);
    }

    function rolavel() {
      return maxScroll() > 1;
    }

    // Quantos slides inteiros cabem no viewport
    function porPagina() {
      var p = passo();
      if (!p) return 1;
      return Math.max(1, Math.floor((viewport.clientWidth + 1) / p));
    }

    function totalPaginas() {
      if (!rolavel()) return 1;
      return Math.max(1, Math.ceil(slides().length / porPagina()));
    }

    function paginaAtual() {
      var p = passo() * porPagina();
      if (!p) return 0;
      var i = Math.round(viewport.scrollLeft / p);
      return Math.min(i, totalPaginas() - 1);
    }

    function irPara(indice) {
      var total = totalPaginas();
      var alvo = Math.max(0, Math.min(indice, total - 1));
      var destino = Math.min(alvo * passo() * porPagina(), maxScroll());
      viewport.scrollTo({
        left: destino,
        behavior: semMovimento.matches ? 'auto' : 'smooth'
      });
    }

    function montarDots() {
      if (!caixaDots) return;
      var n = totalPaginas();

      if (dots.length === n) return;   // nada mudou, evita rebuild à toa

      caixaDots.textContent = '';
      dots = [];

      if (n <= 1) {
        caixaDots.hidden = true;
        return;
      }
      caixaDots.hidden = false;

      for (var i = 0; i < n; i++) {
        var b = document.createElement('button');
        b.type = 'button';
        b.className = 'carousel__dot';
        b.setAttribute('aria-label', 'Ir para o grupo ' + (i + 1) + ' de ' + n);
        b.dataset.indice = String(i);
        b.addEventListener('click', function (e) {
          irPara(Number(e.currentTarget.dataset.indice));
        });
        caixaDots.appendChild(b);
        dots.push(b);
      }
    }

    function atualizar() {
      var inerte = !rolavel();
      var max = maxScroll();

      // só mostra o cursor de "arrastável" quando há de fato o que rolar
      root.classList.toggle('is-scrollable', !inerte);

      if (prev) {
        prev.hidden = inerte;
        prev.disabled = viewport.scrollLeft <= 1;
      }
      if (next) {
        next.hidden = inerte;
        next.disabled = viewport.scrollLeft >= max - 1;
      }

      var atual = paginaAtual();
      for (var i = 0; i < dots.length; i++) {
        var ativo = i === atual;
        dots[i].classList.toggle('carousel__dot--active', ativo);
        dots[i].setAttribute('aria-current', ativo ? 'true' : 'false');
      }
    }

    function recalcular() {
      montarDots();
      atualizar();
    }

    if (prev) prev.addEventListener('click', function () { irPara(paginaAtual() - 1); });
    if (next) next.addEventListener('click', function () { irPara(paginaAtual() + 1); });

    var agendado = false;
    viewport.addEventListener('scroll', function () {
      if (agendado) return;
      agendado = true;
      window.requestAnimationFrame(function () {
        agendado = false;
        atualizar();
      });
    }, { passive: true });

    viewport.addEventListener('keydown', function (e) {
      if (e.key === 'ArrowRight') { e.preventDefault(); irPara(paginaAtual() + 1); }
      if (e.key === 'ArrowLeft')  { e.preventDefault(); irPara(paginaAtual() - 1); }
    });

    /* ---- arrastar com o mouse ---- */
    var arrastando = false, xInicial = 0, scrollInicial = 0, moveu = false;

    viewport.addEventListener('pointerdown', function (e) {
      if (e.pointerType === 'touch') return;   // toque o navegador já resolve
      if (!rolavel()) return;
      arrastando = true;
      moveu = false;
      xInicial = e.clientX;
      scrollInicial = viewport.scrollLeft;
      viewport.style.scrollSnapType = 'none';
      viewport.style.cursor = 'grabbing';
    });

    window.addEventListener('pointermove', function (e) {
      if (!arrastando) return;
      var d = e.clientX - xInicial;
      if (Math.abs(d) > 4) moveu = true;
      viewport.scrollLeft = scrollInicial - d;
    });

    window.addEventListener('pointerup', function () {
      if (!arrastando) return;
      arrastando = false;
      viewport.style.scrollSnapType = '';
      viewport.style.cursor = '';
      if (moveu) irPara(paginaAtual());   // encaixa no slide mais próximo
    });

    // Não deixa o arraste virar clique em link/imagem
    viewport.addEventListener('click', function (e) {
      if (moveu) { e.preventDefault(); e.stopPropagation(); moveu = false; }
    }, true);

    /* ---- recálculos ---- */
    var timer = null;
    window.addEventListener('resize', function () {
      window.clearTimeout(timer);
      timer = window.setTimeout(recalcular, 150);
    });

    // As imagens mudam o scrollWidth ao terminar de carregar
    window.addEventListener('load', recalcular);
    slides().forEach(function (s) {
      var img = s.tagName === 'IMG' ? s : s.querySelector('img');
      if (img && !img.complete) img.addEventListener('load', recalcular, { once: true });
    });

    recalcular();
  }

  /* ------------------------------------------------------------------
     Header sticky — ganha profundidade e encolhe ao descolar do topo
     ------------------------------------------------------------------ */
  function initHeader() {
    var header = document.querySelector('.site-header');
    if (!header) return;

    var agendado = false;
    function avaliar() {
      header.classList.toggle('is-stuck', window.scrollY > 8);
    }
    window.addEventListener('scroll', function () {
      if (agendado) return;
      agendado = true;
      window.requestAnimationFrame(function () { agendado = false; avaliar(); });
    }, { passive: true });
    avaliar();
  }

  /* ------------------------------------------------------------------
     Menu mobile — painel sobreposto; o nav só cabe ao lado do logo e do
     CTA acima de 1024px
     ------------------------------------------------------------------ */
  function initMenu() {
    var botao = document.querySelector('[data-nav-toggle]');
    var header = document.querySelector('.site-header');
    var nav = document.getElementById('menu-principal');
    if (!botao || !header || !nav) return;

    function fechar() {
      header.classList.remove('is-open');
      document.body.classList.remove('menu-aberto');
      botao.setAttribute('aria-expanded', 'false');
      botao.setAttribute('aria-label', 'Abrir menu');
    }

    botao.addEventListener('click', function () {
      var aberto = header.classList.toggle('is-open');
      document.body.classList.toggle('menu-aberto', aberto);
      botao.setAttribute('aria-expanded', aberto ? 'true' : 'false');
      botao.setAttribute('aria-label', aberto ? 'Fechar menu' : 'Abrir menu');
      if (aberto) {
        var primeiro = nav.querySelector('a');
        if (primeiro) primeiro.focus({ preventScroll: true });
      }
    });

    // clicar num item leva à seção e fecha o menu
    nav.addEventListener('click', function (e) {
      if (e.target.closest('a')) fechar();
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') fechar();
    });

    // ao voltar para desktop o menu não pode ficar preso aberto
    var mq = window.matchMedia('(min-width: 1024px)');
    var aoMudar = function (e) { if (e.matches) fechar(); };
    if (mq.addEventListener) mq.addEventListener('change', aoMudar);
    else mq.addListener(aoMudar);
  }

  /* ------------------------------------------------------------------
     Animações de entrada

     Os alvos são marcados aqui, não no HTML: se o JS não rodar, nada fica
     preso invisível. O atraso em cascata é calculado pela posição do
     elemento dentro do próprio pai, então grades animam item a item.
     ------------------------------------------------------------------ */
  var ALVOS = [
    '.hero__text', '.hero__media',
    '.section-header', '.stack-56 > .section-header',
    '.alert-card', '.foto-card', '.pilar-card', '.pillar',
    '.timeline__step', '.trajetoria__item', '.faq-item',
    '.callout', '.split-media__figure', '.split-media__body',
    '.about__left', '.consultorio__text', '.consultorio__action',
    '.carousel', '.depoimentos__head', '.depoimentos__carousel',
    '.cta-band__content', '.cta-band__actions',
    '.cta-final__content', '.cta-final__photo',
    '.site-footer__col', '.site-footer__base'
  ];

  var MIDIAS = ['.hero__media', '.split-media__figure', '.cta-final__photo'];

  function initReveal() {
    if (!('IntersectionObserver' in window)) return;
    if (semMovimento.matches) return;

    var vistos = [];
    ALVOS.forEach(function (sel) {
      var els = document.querySelectorAll(sel);
      for (var i = 0; i < els.length; i++) {
        var el = els[i];
        if (el.hasAttribute('data-reveal')) continue;
        // sticky + transform/will-change não combinam: a foto do médico fica fora
        if (el.classList.contains('about__media')) continue;
        el.setAttribute('data-reveal', MIDIAS.indexOf(sel) > -1 ? 'media' : '');
        // cascata pela posição entre os irmãos
        var irmaos = el.parentElement ? el.parentElement.children : [el];
        var idx = Array.prototype.indexOf.call(irmaos, el);
        el.style.setProperty('--reveal-delay', Math.min(idx * 70, 350) + 'ms');
        vistos.push(el);
      }
    });

    if (!vistos.length) return;
    document.documentElement.classList.add('js-reveal-ready');

    var obs = new IntersectionObserver(function (entradas) {
      entradas.forEach(function (e) {
        if (!e.isIntersecting) return;
        e.target.classList.add('is-visible');
        obs.unobserve(e.target);
        e.target.addEventListener('transitionend', function () {
          e.target.classList.add('is-done');
        }, { once: true });
      });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.06 });

    vistos.forEach(function (el) { obs.observe(el); });
  }

  function iniciar() {
    initHeader();
    initMenu();
    initReveal();
    var lista = document.querySelectorAll('[data-carousel]');
    for (var i = 0; i < lista.length; i++) initCarousel(lista[i]);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', iniciar);
  } else {
    iniciar();
  }
})();
