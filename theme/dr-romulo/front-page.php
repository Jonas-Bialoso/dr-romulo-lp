<?php
/**
 * Home — LP de retirada de preenchimento guiada por ultrassom.
 * Figma: frame 7075:28.
 *
 * A ordem das seções e os layouts vêm do Figma; o conteúdo vem dos CPTs
 * filtrados pela campanha definida no meta box da página.
 *
 * @package dr-romulo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$drm_campanha = drm_meta( 'drm_campanha_slug', 'preenchimento' );
	$drm_layout   = drm_meta( 'drm_sinais_layout', 'icone' );

	drm_secao_hero();
	?>

	<!-- Sinais de alerta — Figma 7075:85 -->
	<section class="section section--cream" id="sinais-de-alerta">
		<div class="section__inner stack-80">
			<div class="stack-56">
				<?php
				drm_cabecalho_secao(
					drm_meta( 'drm_sinais_eyebrow' ),
					drm_meta( 'drm_sinais_titulo' ),
					drm_meta( 'drm_sinais_lead' ),
					'split'
				);

				$drm_sinais = drm_itens( 'drm_sinal', $drm_campanha, 12 );
				if ( 'foto' === $drm_layout ) {
					drm_cards_foto( $drm_sinais );
				} else {
					drm_cards_icone( $drm_sinais );
				}
				?>
			</div>

			<?php drm_callout( drm_meta( 'drm_sinais_callout' ), '', drm_imagem( 'sinais-detalhe.png' ) ); ?>
		</div>
	</section>

	<!-- Por que com ultrassom — Figma 7090:78 -->
	<section class="section section--cream section--pad-100" id="por-que-ultrassom">
		<div class="section__inner stack-80">
			<div class="split-media">
				<?php
				$drm_pag_trat = get_page_by_path( 'o-tratamento', OBJECT, 'page' );
				$drm_img_trat = $drm_pag_trat ? drm_thumb_url( $drm_pag_trat->ID, 'full' ) : '';
				?>
				<figure class="split-media__figure">
					<?php if ( $drm_img_trat ) : ?>
						<img src="<?php echo esc_url( $drm_img_trat ); ?>"
						     alt="Sala de procedimentos do consultório" width="560" height="921"
						     loading="lazy" decoding="async">
					<?php endif; ?>
				</figure>

				<div class="split-media__body">
					<div class="title-group">
						<p class="eyebrow eyebrow--lg"><?php echo esc_html( drm_meta( 'drm_benef_eyebrow' ) ); ?></p>
						<h2 class="split-media__title"><?php echo esc_html( drm_meta( 'drm_benef_titulo' ) ); ?></h2>
					</div>

					<p class="split-media__text"><?php echo esc_html( drm_meta( 'drm_benef_intro' ) ); ?></p>

					<div class="pillars">
						<p class="pillars__label"><?php echo esc_html( drm_meta( 'drm_benef_rotulo' ) ); ?></p>
						<?php drm_lista_numerada( drm_itens( 'drm_beneficio', $drm_campanha, 12 ) ); ?>
					</div>
				</div>
			</div>

			<?php drm_callout( drm_meta( 'drm_benef_callout' ), 'evidencia', drm_imagem( 'evidencia-detalhe.png' ) ); ?>
		</div>
	</section>

	<!-- Como é feito — Figma 7075:201 -->
	<section class="section section--cream" id="como-e-feito">
		<div class="section__inner stack-56">
			<?php
			drm_cabecalho_secao( drm_meta( 'drm_etapas_eyebrow' ), drm_meta( 'drm_etapas_titulo' ) );
			drm_timeline( drm_itens( 'drm_etapa', $drm_campanha, 8 ) );
			?>
		</div>
	</section>

	<?php
	drm_secao_cta_meio();
	drm_secao_sobre();
	drm_secao_diferencial( $drm_campanha );
	drm_secao_consultorio();
	drm_secao_depoimentos();
	drm_secao_faq( $drm_campanha );
	drm_secao_cta_final( drm_imagem( 'cta-final-foto.png' ) );

endwhile;

get_footer();
