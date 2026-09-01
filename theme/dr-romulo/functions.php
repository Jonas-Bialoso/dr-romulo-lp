<?php
/**
 * Dr. Rômulo Malaquias — setup do tema.
 *
 * @package dr-romulo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'DRM_VERSAO', '1.0.0' );
define( 'DRM_DIR', get_template_directory() );
define( 'DRM_URI', get_template_directory_uri() );

/**
 * Suporte do tema.
 */
function drm_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );

	// Tamanho usado pelos cards de foto (389x450 em 2x) e pelo carrossel.
	add_image_size( 'drm_card', 778, 900, true );
	add_image_size( 'drm_slide', 778, 574, true );

	register_nav_menus(
		array(
			'principal' => __( 'Menu principal', 'dr-romulo' ),
		)
	);

	load_theme_textdomain( 'dr-romulo', DRM_DIR . '/languages' );
}
add_action( 'after_setup_theme', 'drm_setup' );

/**
 * CSS e JS.
 *
 * A versão usa filemtime em vez de DRM_VERSAO para o cache quebrar a cada
 * alteração durante o desenvolvimento, sem precisar bater a versão do tema.
 */
function drm_assets() {
	$css = DRM_DIR . '/assets/css/style.css';
	$js  = DRM_DIR . '/assets/js/main.js';

	wp_enqueue_style(
		'drm-inter',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'drm-style',
		DRM_URI . '/assets/css/style.css',
		array( 'drm-inter' ),
		file_exists( $css ) ? filemtime( $css ) : DRM_VERSAO
	);

	wp_enqueue_script(
		'drm-main',
		DRM_URI . '/assets/js/main.js',
		array(),
		file_exists( $js ) ? filemtime( $js ) : DRM_VERSAO,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'drm_assets' );

/**
 * preconnect para o Google Fonts, como no estático.
 */
function drm_resource_hints( $urls, $relation ) {
	if ( 'preconnect' === $relation ) {
		$urls[] = array( 'href' => 'https://fonts.googleapis.com' );
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'drm_resource_hints', 10, 2 );

require_once DRM_DIR . '/inc/cpts.php';
require_once DRM_DIR . '/inc/customizer.php';
require_once DRM_DIR . '/inc/meta-boxes.php';
require_once DRM_DIR . '/inc/helpers.php';
require_once DRM_DIR . '/inc/secoes.php';
require_once DRM_DIR . '/inc/seeder.php';
