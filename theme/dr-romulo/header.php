<?php
/**
 * Cabeçalho.
 *
 * @package dr-romulo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$drm_logo = drm_opt( 'drm_logo' );
if ( ! $drm_logo ) {
	$drm_logo = drm_icone( 'logo-dr-romulo.svg' );
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/svg+xml" href="<?php echo esc_url( drm_icone( 'favicon.svg' ) ); ?>">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-header__logo"
	   aria-label="<?php echo esc_attr( drm_opt( 'drm_medico_nome' ) . ' — página inicial' ); ?>">
		<img src="<?php echo esc_url( $drm_logo ); ?>"
		     alt="<?php echo esc_attr( drm_opt( 'drm_medico_nome' ) ); ?>" width="174" height="32">
	</a>

	<nav class="site-nav" id="menu-principal" aria-label="Navegação principal">
		<?php
		if ( has_nav_menu( 'principal' ) ) {
			wp_nav_menu(
				array(
					'theme_location' => 'principal',
					'container'      => false,
					'items_wrap'     => '<ul>%3$s</ul>',
					'depth'          => 1,
				)
			);
		} else {
			// Fallback: as âncoras das seções desta página. O rótulo "O que é o
			// Liftera" vem do Figma; a âncora precisa resolver na página em que
			// está, e por isso é o único ponto em que as duas LPs divergem.
			$drm_ancora_tratamento = is_page_template( 'page-liftera.php' ) ? '#o-que-e-o-liftera' : '#por-que-ultrassom';
			?>
			<ul>
				<li><a href="#sinais-de-alerta">Sinais de alerta</a></li>
				<li><a href="<?php echo esc_attr( $drm_ancora_tratamento ); ?>">O que é o Liftera</a></li>
				<li><a href="#sobre-o-medico">Sobre o Dr. Rômulo</a></li>
				<li><a href="#consultorio">Consultório</a></li>
				<li><a href="#duvidas">Dúvidas</a></li>
			</ul>
			<?php
		}
		drm_botao( 'Agendar minha avaliação', 'light', 'site-nav__cta' );
		?>
	</nav>

	<?php drm_botao( 'Agendar avaliação', 'header' ); ?>

	<button class="nav-toggle" type="button" aria-label="Abrir menu"
	        aria-expanded="false" aria-controls="menu-principal" data-nav-toggle>
		<span class="nav-toggle__bars" aria-hidden="true"></span>
	</button>
</header>

<main>
