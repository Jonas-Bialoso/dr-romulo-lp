<?php
/**
 * Template Name: LP Liftera
 *
 * LP do Liftera — ultrassom microfocado para flacidez.
 * Figma: frame 7002:24.
 *
 * Mesmas seções da home, com dois layouts diferentes: os sinais viram cards
 * com foto e a seção de benefícios vira uma grade de fotos ("Objetivos
 * clínicos"), com a lista numerada aparecendo na seção do tratamento.
 *
 * @package dr-romulo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$drm_campanha = drm_meta( 'drm_campanha_slug', 'liftera' );

	drm_secao_hero();
	?>

	<!-- Sinais de alerta — Figma 7008:211 -->
	<section class="section section--cream" id="sinais-de-alerta">
		<div class="section__inner stack-80">
			<div class="stack-56">
				<?php
				drm_cabecalho_secao(
					drm_meta( 'drm_sinais_eyebrow' ),
					drm_meta( 'drm_sinais_titulo' ),
					drm_meta( 'drm_sinais_lead' ),
					'stack',
					true
				);
				drm_cards_foto( drm_itens( 'drm_sinal', $drm_campanha, 12 ) );
				?>
			</div>

			<?php drm_callout( drm_meta( 'drm_sinais_callout' ), 'hug', drm_imagem( 'sinais-detalhe.png' ) ); ?>
		</div>
	</section>

	<!-- O que é o Liftera — Figma 7012:422 -->
	<section class="section section--cream" id="o-que-e-o-liftera">
		<div class="section__inner stack-80">
			<div class="split-media split-media--liftera">
				<?php
				$drm_pag_trat = get_page_by_path( 'o-tratamento-liftera', OBJECT, 'page' );
				$drm_img_trat = $drm_pag_trat ? drm_thumb_url( $drm_pag_trat->ID, 'full' ) : '';
				?>
				<figure class="split-media__figure split-media__figure--liftera">
					<?php if ( $drm_img_trat ) : ?>
						<img src="<?php echo esc_url( $drm_img_trat ); ?>"
						     alt="Equipamento de ultrassom microfocado no consultório" width="568" height="802"
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
						<?php
						// Aqui a lista numerada explica o mecanismo do aparelho.
						drm_lista_numerada( drm_itens( 'drm_mecanismo', $drm_campanha, 8 ), true );
						drm_botao( 'Falar com um especialista', 'primary', 'btn--inline' );
						?>
					</div>
				</div>
			</div>

			<div class="stack-56">
				<?php
				drm_cabecalho_secao(
					drm_meta( 'drm_etapas_eyebrow' ),
					drm_meta( 'drm_etapas_titulo' ),
					drm_meta( 'drm_etapas_lead' ),
					'stack',
					true
				);
				drm_timeline( drm_itens( 'drm_etapa', $drm_campanha, 8 ) );
				drm_botao( 'Agendar minha avaliação', 'primary', 'btn--inline' );
				?>
			</div>
		</div>
	</section>

	<!-- Resultados do tratamento — Figma 7020:922 -->
	<section class="section section--cream" id="resultados">
		<div class="section__inner stack-80">
			<div class="stack-56">
				<?php
				drm_cabecalho_secao(
					drm_meta( 'drm_benef_eyebrow_2', 'Objetivos Clínicos' ),
					drm_meta( 'drm_benef_titulo_2', 'O que esperar do tratamento' ),
					drm_meta( 'drm_benef_lead' ),
					'stack',
					true
				);
				drm_cards_foto( drm_itens( 'drm_beneficio', $drm_campanha, 12 ), 'resultado' );
				?>
			</div>

			<?php
			// O nó da foto está com visible:false no Figma — o callout desta
			// seção não leva imagem.
			drm_callout( drm_meta( 'drm_benef_callout' ), 'fill' );
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
	drm_secao_cta_final( drm_imagem( 'cta-final-liftera.png' ), 'liftera' );

endwhile;

get_footer();
