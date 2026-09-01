<?php
/**
 * Renderizadores de seção.
 *
 * As duas LPs compartilham todos os blocos e diferem só nos dados, por isso
 * cada seção é uma função que lê do CPT/meta, em vez de um template-part
 * duplicado por página.
 *
 * @package dr-romulo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Chapéu + título (+ descrição). $layout: 'split' lado a lado, 'stack' empilhado.
 */
function drm_cabecalho_secao( $eyebrow, $titulo, $lead = '', $layout = 'stack', $lead_largo = false ) {
	if ( ! $eyebrow && ! $titulo ) {
		return;
	}
	?>
	<header class="section-header">
		<?php if ( $eyebrow ) : ?>
			<p class="eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
		<?php endif; ?>

		<?php if ( 'split' === $layout && $lead ) : ?>
			<div class="section-header__split">
				<h2 class="section-title"><?php echo esc_html( $titulo ); ?></h2>
				<p class="section-lead"><?php echo esc_html( $lead ); ?></p>
			</div>
		<?php elseif ( $lead ) : ?>
			<div class="section-header__stack">
				<h2 class="section-heading"><?php echo esc_html( $titulo ); ?></h2>
				<p class="section-lead <?php echo $lead_largo ? 'section-lead--780' : ''; ?>"><?php echo esc_html( $lead ); ?></p>
			</div>
		<?php else : ?>
			<h2 class="section-heading"><?php echo esc_html( $titulo ); ?></h2>
		<?php endif; ?>
	</header>
	<?php
}

/**
 * Hero.
 */
function drm_secao_hero() {
	$px    = (int) drm_meta( 'drm_hero_titulo_px', 48 );
	$img   = drm_thumb_url( get_the_ID(), 'full' );
	$badge = drm_meta( 'drm_hero_badge_tit' );
	?>
	<section class="section hero<?php echo 37 === $px ? ' hero--liftera' : ''; ?>">
		<div class="section__inner hero__inner">
			<div class="hero__text">
				<div class="hero__copy">
					<p class="hero__eyebrow"><?php echo esc_html( drm_meta( 'drm_hero_eyebrow' ) ); ?></p>

					<div class="hero__block">
						<h1 class="hero__heading"><?php echo esc_html( drm_meta( 'drm_hero_titulo' ) ); ?></h1>
						<p class="hero__lead"><?php echo esc_html( drm_meta( 'drm_hero_lead' ) ); ?></p>
						<p class="hero__support"><?php echo esc_html( drm_meta( 'drm_hero_apoio' ) ); ?></p>
					</div>
				</div>

				<div class="hero__actions">
					<?php drm_botao( drm_meta( 'drm_hero_cta', 'Agendar minha avaliação' ) ); ?>

					<p class="hero__microcopy">
						<span class="icon-box" aria-hidden="true">
							<img src="<?php echo esc_url( drm_icone( 'icon-map-pin.svg' ) ); ?>" alt="" width="18" height="18">
						</span>
						<span class="hero__microcopy-text"><?php echo esc_html( drm_meta( 'drm_hero_micro' ) ); ?></span>
					</p>
				</div>
			</div>

			<figure class="hero__media">
				<?php if ( $img ) : ?>
					<img class="hero__image" src="<?php echo esc_url( $img ); ?>"
					     alt="<?php echo esc_attr( get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ); ?>"
					     width="568" height="557">
				<?php endif; ?>

				<?php if ( $badge ) : ?>
					<figcaption class="tech-badge">
						<span class="icon-box icon-box--55" aria-hidden="true">
							<img src="<?php echo esc_url( drm_icone( 'icon-ultrassom.svg' ) ); ?>" alt="" width="38" height="38">
						</span>
						<span class="tech-badge__body">
							<strong class="tech-badge__title"><?php echo esc_html( $badge ); ?></strong>
							<span class="tech-badge__text"><?php echo esc_html( drm_meta( 'drm_hero_badge_txt' ) ); ?></span>
						</span>
					</figcaption>
				<?php endif; ?>
			</figure>
		</div>
	</section>
	<?php
}

/**
 * Bloco escuro com ícone, texto e CTA.
 *
 * @param string $texto    Texto do aviso.
 * @param string $variante '' (LP1), 'hug' ou 'fill'.
 * @param string $imagem   URL da foto recortada, ou '' para não exibir.
 */
function drm_callout( $texto, $variante = '', $imagem = '' ) {
	if ( ! $texto ) {
		return;
	}
	$classe = trim( 'callout ' . ( $variante ? 'callout--' . $variante : '' ) );
	?>
	<div class="<?php echo esc_attr( $classe ); ?>">
		<div class="callout__main <?php echo 'fill' === $variante ? 'callout__main--fill' : ''; ?>">
			<span class="icon-box icon-box--64 icon-box--ghost" aria-hidden="true">
				<img src="<?php echo esc_url( drm_icone( 'icon-alerta-urgencia.svg' ) ); ?>" alt="" width="38" height="38">
			</span>
			<p class="callout__text <?php echo 'fill' === $variante ? 'callout__text--fill' : ( 'hug' === $variante ? 'callout__text--557' : '' ); ?>">
				<?php echo esc_html( $texto ); ?>
			</p>
		</div>

		<?php if ( $imagem ) : ?>
			<img class="callout__image <?php echo $variante ? 'callout__image--669' : ''; ?>"
			     src="<?php echo esc_url( $imagem ); ?>" alt="" aria-hidden="true"
			     width="226" height="159" loading="lazy" decoding="async">
		<?php endif; ?>

		<?php drm_botao( 'Agendar minha avaliação', 'light' ); ?>
	</div>
	<?php
}

/**
 * Cards com ícone (LP de preenchimento).
 */
function drm_cards_icone( $itens ) {
	if ( ! $itens ) {
		return;
	}
	echo '<ul class="alert-grid">';
	foreach ( $itens as $i => $post ) {
		$icone = get_post_meta( $post->ID, 'drm_icone', true );
		?>
		<li class="alert-card">
			<span class="icon-box icon-box--55" aria-hidden="true">
				<img src="<?php echo esc_url( drm_icone( $icone ? $icone : 'icon-alerta-urgencia.svg' ) ); ?>" alt="" width="32" height="32">
			</span>
			<div class="alert-card__body">
				<h3 class="alert-card__title"><?php echo esc_html( $post->post_title ); ?></h3>
				<p class="alert-card__text"><?php echo esc_html( drm_texto( $post ) ); ?></p>
			</div>
		</li>
		<?php
	}
	echo '</ul>';
}

/**
 * Cards com foto de fundo (LP do Liftera).
 *
 * @param WP_Post[] $itens
 * @param string    $variante '' (sinais) ou 'resultado' (objetivos clínicos).
 */
function drm_cards_foto( $itens, $variante = '' ) {
	if ( ! $itens ) {
		return;
	}
	echo '<ul class="foto-grid">';
	foreach ( $itens as $i => $post ) {
		$foto = drm_thumb_url( $post->ID );
		// O Figma inverte o badge em foto clara; o campo permite reproduzir isso.
		$escuro = 'sim' === get_post_meta( $post->ID, 'drm_badge_escuro', true );
		?>
		<li class="foto-card <?php echo $variante ? 'foto-card--' . esc_attr( $variante ) : ''; ?>"
		    <?php echo $foto ? 'style="background-image:url(\'' . esc_url( $foto ) . '\')"' : ''; ?>>
			<span class="foto-card__num <?php echo $escuro ? 'foto-card__num--dark' : ''; ?>" aria-hidden="true"><?php echo esc_html( drm_num( $i ) ); ?></span>
			<div class="foto-card__body">
				<h3 class="foto-card__title"><?php echo esc_html( $post->post_title ); ?></h3>
				<p class="foto-card__text"><?php echo esc_html( drm_texto( $post ) ); ?></p>
			</div>
		</li>
		<?php
	}
	echo '</ul>';
}

/**
 * Lista numerada com divisor (evidências do exame / objetivos).
 */
function drm_lista_numerada( $itens, $texto_pequeno = false ) {
	if ( ! $itens ) {
		return;
	}
	$ultimo = count( $itens ) - 1;
	echo '<ol class="pillars__list">';
	foreach ( $itens as $i => $post ) {
		?>
		<li class="pillar <?php echo $i === $ultimo ? 'pillar--last' : ''; ?>">
			<span class="pillar__num" aria-hidden="true"><?php echo esc_html( drm_num( $i ) ); ?></span>
			<div class="pillar__body">
				<h3 class="pillar__title"><?php echo esc_html( $post->post_title ); ?></h3>
				<p class="pillar__text <?php echo $texto_pequeno ? 'pillar__text--14' : ''; ?>"><?php echo esc_html( drm_texto( $post ) ); ?></p>
			</div>
		</li>
		<?php
	}
	echo '</ol>';
}

/**
 * Timeline horizontal das etapas.
 */
function drm_timeline( $itens ) {
	if ( ! $itens ) {
		return;
	}
	$ultimo = count( $itens ) - 1;
	echo '<ol class="timeline">';
	foreach ( $itens as $i => $post ) {
		?>
		<li class="timeline__step">
			<div class="timeline__head">
				<span class="timeline__badge" aria-hidden="true"><?php echo esc_html( drm_num( $i ) ); ?></span>
				<?php if ( $i !== $ultimo ) : ?>
					<span class="timeline__line" aria-hidden="true"></span>
				<?php endif; ?>
			</div>
			<div class="timeline__body">
				<h3 class="timeline__title"><?php echo esc_html( $post->post_title ); ?></h3>
				<p class="timeline__text"><?php echo esc_html( drm_texto( $post ) ); ?></p>
			</div>
		</li>
		<?php
	}
	echo '</ol>';
}

/**
 * Seção Diferencial (pilares da consulta).
 *
 * @param string $campanha Slug da campanha.
 */
function drm_secao_diferencial( $campanha ) {
	$pilares = drm_itens( 'drm_pilar', $campanha, 8 );
	$texto   = drm_meta( 'drm_dif_texto' );
	$split   = (bool) $texto;
	?>
	<section class="section diferencial">
		<div class="section__inner stack-56">

			<div class="diferencial__head <?php echo $split ? 'diferencial__head--split' : ''; ?>">
				<div class="diferencial__head-text">
					<p class="eyebrow"><?php echo esc_html( drm_meta( 'drm_dif_eyebrow' ) ); ?></p>
					<h2 class="section-heading"><?php echo esc_html( drm_meta( 'drm_dif_titulo' ) ); ?></h2>
					<?php if ( $split ) { drm_botao( 'Agendar minha avaliação', 'primary', 'btn--inline' ); } ?>
				</div>

				<?php if ( $split ) : ?>
					<div class="diferencial__head-body">
						<p class="diferencial__body-text"><?php echo esc_html( $texto ); ?></p>
					</div>
				<?php else : ?>
					<?php drm_botao( 'Agendar minha avaliação' ); ?>
				<?php endif; ?>
			</div>

			<div class="pilares">
				<p class="pilares__label"><?php echo esc_html( drm_meta( 'drm_dif_rotulo' ) ); ?></p>
				<ol class="pilares__grid">
					<?php
					foreach ( $pilares as $i => $post ) :
						$icone = get_post_meta( $post->ID, 'drm_icone', true );
						?>
						<li class="pilar-card">
							<div class="pilar-card__row">
								<span class="icon-box icon-box--48" aria-hidden="true">
									<img src="<?php echo esc_url( drm_icone( $icone ? $icone : 'icon-pilar-seguranca.svg' ) ); ?>" alt="" width="22" height="22">
								</span>
								<span class="pilar-card__num" aria-hidden="true"><?php echo esc_html( drm_num( $i ) ); ?></span>
							</div>
							<div class="pilar-card__body">
								<h3 class="pilar-card__title"><?php echo esc_html( $post->post_title ); ?></h3>
								<p class="pilar-card__text"><?php echo esc_html( drm_texto( $post ) ); ?></p>
							</div>
						</li>
					<?php endforeach; ?>
				</ol>
			</div>

		</div>
	</section>
	<?php
}

/**
 * CTA intermediária (faixa escura com foto de fundo).
 */
function drm_secao_cta_meio() {
	?>
	<section class="section cta-band">
		<div class="section__inner cta-band__inner">
			<div class="cta-band__content">
				<p class="cta-band__eyebrow"><?php echo esc_html( drm_meta( 'drm_ctam_eyebrow' ) ); ?></p>
				<h2 class="cta-band__title"><?php echo esc_html( drm_meta( 'drm_ctam_titulo' ) ); ?></h2>
				<p class="cta-band__text"><?php echo esc_html( drm_meta( 'drm_ctam_texto' ) ); ?></p>
			</div>

			<div class="cta-band__actions">
				<?php drm_botao( drm_meta( 'drm_ctam_botao', 'Falar com a equipe no WhatsApp' ), 'light' ); ?>
				<p class="cta-band__microcopy">
					<img src="<?php echo esc_url( drm_icone( 'icon-lock.svg' ) ); ?>" alt="" aria-hidden="true" width="14" height="14">
					<?php echo esc_html( drm_meta( 'drm_ctam_micro' ) ); ?>
				</p>
			</div>
		</div>
	</section>
	<?php
}

/**
 * CTA final (card com foto recortada).
 *
 * @param string $foto     URL do recorte.
 * @param string $variante '' ou 'liftera'.
 */
function drm_secao_cta_final( $foto = '', $variante = '' ) {
	?>
	<section class="section cta-final">
		<div class="section__inner">
			<div class="cta-final__card <?php echo $variante ? 'cta-final__card--' . esc_attr( $variante ) : ''; ?>">

				<div class="cta-final__content <?php echo $variante ? 'cta-final__content--687' : ''; ?>">
					<div class="cta-final__copy <?php echo $variante ? 'cta-final__copy--16' : ''; ?>">
						<h2 class="cta-final__title"><?php echo esc_html( drm_meta( 'drm_ctaf_titulo' ) ); ?></h2>
						<p class="cta-final__text"><?php echo esc_html( drm_meta( 'drm_ctaf_texto' ) ); ?></p>
					</div>

					<div class="cta-final__actions">
						<?php drm_botao( drm_meta( 'drm_ctaf_botao', 'Falar com a equipe no WhatsApp' ), 'light' ); ?>
						<p class="cta-final__microcopy">
							<img src="<?php echo esc_url( drm_icone( 'icon-lock.svg' ) ); ?>" alt="" aria-hidden="true" width="14" height="14">
							<span><?php echo esc_html( drm_meta( 'drm_ctaf_micro' ) ); ?></span>
						</p>
					</div>
				</div>

				<?php if ( $foto ) : ?>
					<img class="cta-final__photo <?php echo $variante ? 'cta-final__photo--liftera' : ''; ?>"
					     src="<?php echo esc_url( $foto ); ?>" alt="" aria-hidden="true"
					     loading="lazy" decoding="async">
				<?php endif; ?>

			</div>
		</div>
	</section>
	<?php
}

/**
 * Sobre o médico — idêntico nas duas LPs.
 */
function drm_secao_sobre() {
	$trajetoria = drm_itens( 'drm_formacao', '', 20 );
	$sobre      = get_page_by_path( 'sobre-o-medico', OBJECT, 'page' );
	$foto       = $sobre ? drm_thumb_url( $sobre->ID, 'full' ) : '';
	$ultimo     = count( $trajetoria ) - 1;
	?>
	<section class="section about" id="sobre-o-medico">
		<div class="section__inner about__inner">

			<div class="about__left">
				<div class="about__intro">
					<header class="section-header">
						<p class="eyebrow">Sobre o médico</p>
						<h2 class="section-heading"><?php echo esc_html( drm_opt( 'drm_medico_nome' ) ); ?> — Dermatologista</h2>
					</header>

					<div class="about__narrative">
						<?php
						// paragraphSpacing 16 no Figma: cada parágrafo é um <p>.
						echo wp_kses_post( $sobre ? apply_filters( 'the_content', $sobre->post_content ) : '' );
						?>
					</div>
				</div>

				<div class="about__formation">
					<header class="about__formation-header">
						<p class="eyebrow">Formação e atuação</p>
						<h3 class="section-heading">Trajetória acadêmica e profissional</h3>
					</header>

					<ol class="trajetoria">
						<?php foreach ( $trajetoria as $i => $item ) : ?>
							<li class="trajetoria__item <?php echo $i === $ultimo ? 'trajetoria__item--last' : ''; ?>">
								<span class="trajetoria__marker" aria-hidden="true"></span>
								<div class="trajetoria__content">
									<h4 class="trajetoria__title"><?php echo esc_html( $item->post_title ); ?></h4>
									<p class="trajetoria__inst"><?php echo esc_html( drm_texto( $item ) ); ?></p>
								</div>
							</li>
						<?php endforeach; ?>
					</ol>
				</div>
			</div>

			<figure class="about__media">
				<?php if ( $foto ) : ?>
					<img class="about__photo" src="<?php echo esc_url( $foto ); ?>"
					     alt="Retrato de <?php echo esc_attr( drm_opt( 'drm_medico_nome' ) ); ?>" width="580" height="628">
				<?php endif; ?>

				<figcaption class="tech-badge tech-badge--doctor">
					<span class="icon-box icon-box--55" aria-hidden="true">
						<img src="<?php echo esc_url( drm_icone( 'icon-estetoscopio.svg' ) ); ?>" alt="" width="36" height="36">
					</span>
					<span class="tech-badge__body tech-badge__body--doctor">
						<span class="tech-badge__row">
							<strong class="tech-badge__title"><?php echo esc_html( drm_opt( 'drm_medico_nome' ) ); ?></strong>
							<img src="<?php echo esc_url( drm_icone( 'icon-verificado.svg' ) ); ?>" alt="" aria-hidden="true" width="16" height="16">
						</span>
						<span class="tech-badge__text">Médico Dermatologista</span>
					</span>
				</figcaption>
			</figure>

		</div>
	</section>
	<?php
}

/**
 * Consultório com carrossel — idêntico nas duas LPs.
 */
function drm_secao_consultorio() {
	$fotos = drm_itens( 'drm_foto', '', 30 );
	$total = count( $fotos );
	$pag   = get_page_by_path( 'consultorio', OBJECT, 'page' );
	?>
	<section class="section consultorio" id="consultorio">

		<div class="consultorio__head">
			<div class="consultorio__text">
				<div class="consultorio__title-stack">
					<p class="eyebrow">O consultório</p>
					<h2 class="section-heading">Onde você será atendida</h2>
				</div>

				<p class="consultorio__body"><?php echo esc_html( $pag ? drm_texto( $pag ) : '' ); ?></p>

				<p class="consultorio__address">
					<span class="icon-box" aria-hidden="true">
						<img src="<?php echo esc_url( drm_icone( 'icon-pin-endereco.svg' ) ); ?>" alt="" width="18" height="18">
					</span>
					<span class="consultorio__address-text">
						<?php echo esc_html( drm_opt( 'drm_endereco' ) . ' · ' . drm_opt( 'drm_bairro' ) ); ?>
					</span>
				</p>
			</div>

			<div class="consultorio__action">
				<?php drm_botao( 'Agendar minha avaliação' ); ?>
			</div>
		</div>

		<div class="carousel" data-carousel role="group" aria-label="Fotos do consultório">
			<div class="carousel__viewport" data-carousel-viewport tabindex="0">
				<ul class="carousel__track">
					<?php foreach ( $fotos as $i => $foto ) : ?>
						<li class="carousel__item">
							<img class="carousel__slide"
							     src="<?php echo esc_url( drm_thumb_url( $foto->ID, 'drm_slide' ) ); ?>"
							     alt="<?php echo esc_attr( $foto->post_title ? $foto->post_title : sprintf( 'Consultório — foto %d de %d', $i + 1, $total ) ); ?>"
							     width="389" height="287"
							     <?php echo $i > 0 ? 'loading="lazy"' : ''; ?> decoding="async">
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<button class="carousel__nav carousel__nav--prev" type="button" data-carousel-prev aria-label="Fotos anteriores">
				<img src="<?php echo esc_url( drm_icone( 'icon-chevron-left.svg' ) ); ?>" alt="" aria-hidden="true" width="20" height="20">
			</button>
			<button class="carousel__nav carousel__nav--next" type="button" data-carousel-next aria-label="Próximas fotos">
				<img src="<?php echo esc_url( drm_icone( 'icon-chevron-right.svg' ) ); ?>" alt="" aria-hidden="true" width="20" height="20">
			</button>

			<div class="carousel__dots" data-carousel-dots></div>
		</div>

	</section>
	<?php
}

/**
 * Depoimentos — idêntico nas duas LPs.
 */
function drm_secao_depoimentos() {
	$itens = drm_itens( 'drm_depoimento', '', 20 );
	?>
	<section class="section depoimentos">
		<div class="section__inner depoimentos__inner">

			<div class="depoimentos__head">
				<div class="depoimentos__head-text">
					<p class="eyebrow">Depoimentos</p>
					<h2 class="section-heading depoimentos__title">O que as pacientes relatam</h2>
				</div>

				<p class="depoimentos__verified">
					5.0 ★★★★★ - Avaliações verificadas no Google
					<img src="<?php echo esc_url( drm_icone( 'icon-shield-check.svg' ) ); ?>" alt="" aria-hidden="true" width="16" height="16">
				</p>
			</div>

			<div class="depoimentos__carousel" data-carousel>
				<div class="depoimentos__viewport" data-carousel-viewport tabindex="0">
					<ul class="depoimentos__grid">
						<?php foreach ( $itens as $dep ) : ?>
							<li class="depoimento">
								<div class="depoimento__head">
									<span class="depoimento__stars" role="img" aria-label="5 de 5 estrelas">
										<?php for ( $e = 0; $e < 5; $e++ ) : ?>
											<img src="<?php echo esc_url( drm_icone( 'icon-estrela.svg' ) ); ?>" alt="" aria-hidden="true" width="16" height="16">
										<?php endfor; ?>
									</span>
									<img class="depoimento__google" src="<?php echo esc_url( drm_icone( 'icon-google.svg' ) ); ?>"
									     alt="Avaliação publicada no Google" width="24" height="24">
								</div>

								<blockquote class="depoimento__quote"><?php echo esc_html( drm_texto( $dep ) ); ?></blockquote>

								<div class="depoimento__foot">
									<span class="depoimento__author">
										<strong class="depoimento__initials"><?php echo esc_html( $dep->post_title ); ?></strong>
										<span class="depoimento__label">Paciente verificada</span>
									</span>
									<span class="depoimento__date"><?php echo esc_html( get_post_meta( $dep->ID, 'drm_data', true ) ); ?></span>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>

				<button class="carousel__nav carousel__nav--prev" type="button" data-carousel-prev aria-label="Depoimentos anteriores">
					<img src="<?php echo esc_url( drm_icone( 'icon-chevron-left.svg' ) ); ?>" alt="" aria-hidden="true" width="20" height="20">
				</button>
				<button class="carousel__nav carousel__nav--next" type="button" data-carousel-next aria-label="Próximos depoimentos">
					<img src="<?php echo esc_url( drm_icone( 'icon-chevron-right.svg' ) ); ?>" alt="" aria-hidden="true" width="20" height="20">
				</button>

				<div class="depoimentos__dots" data-carousel-dots></div>
			</div>

		</div>
	</section>
	<?php
}

/**
 * Dúvidas frequentes (acordeão nativo com <details>).
 */
function drm_secao_faq( $campanha ) {
	$itens = drm_itens( 'drm_faq', $campanha, 30 );
	?>
	<section class="section faq" id="duvidas">
		<div class="section__inner faq__inner">

			<div class="faq__aside">
				<p class="eyebrow"><?php echo esc_html( drm_meta( 'drm_faq_eyebrow', 'Dúvidas frequentes' ) ); ?></p>
				<h2 class="section-heading"><?php echo esc_html( drm_meta( 'drm_faq_titulo', 'Dúvidas frequentes' ) ); ?></h2>
				<?php drm_botao( drm_meta( 'drm_faq_botao', 'Tire suas dúvidas' ) ); ?>
			</div>

			<div class="faq__list">
				<?php foreach ( $itens as $i => $item ) : ?>
					<details class="faq-item <?php echo 0 === $i ? 'faq-item--first' : ''; ?>" <?php echo 0 === $i ? 'open' : ''; ?>>
						<summary class="faq-item__q">
							<span><?php echo esc_html( ( $i + 1 ) . '. ' . $item->post_title ); ?></span>
							<img class="faq-item__chevron" src="<?php echo esc_url( drm_icone( 'icon-chevron-down.svg' ) ); ?>"
							     alt="" aria-hidden="true" width="20" height="20">
						</summary>
						<p class="faq-item__a"><?php echo esc_html( drm_texto( $item ) ); ?></p>
					</details>
				<?php endforeach; ?>
			</div>

		</div>
	</section>
	<?php
}
