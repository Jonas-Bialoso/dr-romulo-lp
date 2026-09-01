<?php
/**
 * Rodapé.
 *
 * @package dr-romulo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$drm_logo_branco = drm_opt( 'drm_logo_branco' );
if ( ! $drm_logo_branco ) {
	$drm_logo_branco = drm_icone( 'logo-dr-romulo-branco.svg' );
}

$drm_insta = drm_opt( 'drm_instagram' );
$drm_insta_url = 'https://www.instagram.com/' . ltrim( $drm_insta, '@' );
?>
</main>

<footer class="site-footer">
	<div class="section__inner site-footer__inner">

		<div class="site-footer__cols">
			<div class="site-footer__col">
				<img class="site-footer__logo" src="<?php echo esc_url( $drm_logo_branco ); ?>"
				     alt="<?php echo esc_attr( drm_opt( 'drm_medico_nome' ) ); ?>" width="174" height="32">
			</div>

			<div class="site-footer__col">
				<h2 class="site-footer__title">Médico / Responsável Técnico</h2>
				<p class="site-footer__item">
					<?php
					echo esc_html(
						drm_opt( 'drm_medico_nome' ) . ' · ' . drm_opt( 'drm_crm' ) . ' · ' . drm_opt( 'drm_rqe' ) . ' — Dermatologia'
					);
					?>
				</p>
				<p class="site-footer__item"><?php echo esc_html( drm_opt( 'drm_diretor' ) ); ?></p>
			</div>

			<div class="site-footer__col">
				<h2 class="site-footer__title">Contato</h2>
				<p class="site-footer__item">
					<a href="tel:+<?php echo esc_attr( preg_replace( '/\D/', '', drm_opt( 'drm_whatsapp' ) ) ); ?>">
						<?php echo esc_html( drm_opt( 'drm_telefone' ) ); ?>
					</a>
				</p>
				<p class="site-footer__item">
					<a href="mailto:<?php echo esc_attr( drm_opt( 'drm_email' ) ); ?>">
						<?php echo esc_html( drm_opt( 'drm_email' ) ); ?>
					</a>
				</p>
				<p class="site-footer__item">
					<a href="<?php echo esc_url( $drm_insta_url ); ?>" rel="noopener"><?php echo esc_html( $drm_insta ); ?></a>
				</p>
			</div>

			<div class="site-footer__col">
				<h2 class="site-footer__title">Localização</h2>
				<p class="site-footer__item"><?php echo esc_html( drm_opt( 'drm_endereco' ) ); ?></p>
				<p class="site-footer__item"><?php echo esc_html( drm_opt( 'drm_bairro' ) ); ?></p>
			</div>

			<div class="site-footer__col">
				<h2 class="site-footer__title">Políticas</h2>
				<p class="site-footer__item">
					<a href="<?php echo esc_url( drm_opt( 'drm_privacidade', '#' ) ?: '#' ); ?>">Política de Privacidade</a>
				</p>
				<p class="site-footer__item">
					<a href="<?php echo esc_url( drm_opt( 'drm_termos', '#' ) ?: '#' ); ?>">Termos de Uso</a>
				</p>
			</div>
		</div>

		<div class="site-footer__divider" role="presentation"></div>

		<div class="site-footer__base">
			<p class="site-footer__disclaimer"><?php echo esc_html( drm_opt( 'drm_disclaimer' ) ); ?></p>

			<p class="site-footer__credit">
				Criado por
				<img src="<?php echo esc_url( drm_icone( 'logo-criado-por.svg' ) ); ?>" alt="" aria-hidden="true" width="20" height="16">
			</p>
		</div>

	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
