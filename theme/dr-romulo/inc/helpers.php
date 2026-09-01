<?php
/**
 * Utilitários usados pelos templates.
 *
 * @package dr-romulo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Valor do Customizer com o padrão declarado em customizer.php.
 */
function drm_opt( $chave, $fallback = '' ) {
	$padrao = $fallback;

	foreach ( drm_campos_customizer() as $secao ) {
		if ( isset( $secao['campos'][ $chave ]['padrao'] ) ) {
			$padrao = $secao['campos'][ $chave ]['padrao'];
			break;
		}
	}

	return get_theme_mod( $chave, $padrao );
}

/**
 * Link do WhatsApp montado a partir do Customizer.
 */
function drm_whatsapp_url() {
	$numero = preg_replace( '/\D/', '', drm_opt( 'drm_whatsapp' ) );
	$msg    = drm_opt( 'drm_whatsapp_msg' );

	$url = 'https://wa.me/' . $numero;
	if ( $msg ) {
		$url .= '?text=' . rawurlencode( $msg );
	}
	return $url;
}

/**
 * Itens de um CPT, opcionalmente filtrados por campanha.
 *
 * @param string $tipo     Slug do CPT.
 * @param string $campanha Slug do termo, ou '' para não filtrar.
 * @param int    $limite   Quantidade máxima.
 * @return WP_Post[]
 */
function drm_itens( $tipo, $campanha = '', $limite = 20 ) {
	$args = array(
		'post_type'      => $tipo,
		'post_status'    => 'publish',
		'posts_per_page' => $limite,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	);

	if ( $campanha ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'drm_campanha',
				'field'    => 'slug',
				'terms'    => $campanha,
			),
		);
	}

	return get_posts( $args );
}

/**
 * Número com zero à esquerda, como no design (01, 02, ...).
 */
function drm_num( $i ) {
	return str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT );
}

/**
 * Meta de página com fallback.
 */
function drm_meta( $chave, $fallback = '', $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$valor   = get_post_meta( $post_id, $chave, true );
	return '' !== $valor ? $valor : $fallback;
}

/**
 * URL de um ícone do tema.
 */
function drm_icone( $nome ) {
	return DRM_URI . '/assets/icons/' . $nome;
}

/**
 * URL de uma imagem que vive no tema (recortes e fundos que não são
 * conteúdo editável — a foto do médico e as do consultório vêm da Mídia).
 */
function drm_imagem( $nome ) {
	return DRM_URI . '/assets/images/' . $nome;
}

/**
 * Botão de WhatsApp — usado em todas as seções.
 *
 * @param string $texto   Rótulo.
 * @param string $variante 'primary' (fundo escuro) ou 'light' (fundo claro).
 * @param string $extra   Classes adicionais.
 */
function drm_botao( $texto, $variante = 'primary', $extra = '' ) {
	// O ícone branco some no botão claro; o Figma usa a versão #01012C ali.
	$icone = 'light' === $variante ? 'icon-whatsapp-18-escuro.svg' : 'icon-whatsapp-18.svg';

	printf(
		'<a class="btn btn--%1$s %2$s" href="%3$s" rel="noopener" data-whatsapp>'
			. '<img class="btn__icon btn__icon--18" src="%4$s" alt="" aria-hidden="true" width="18" height="18">'
			. '%5$s</a>',
		esc_attr( $variante ),
		esc_attr( $extra ),
		esc_url( drm_whatsapp_url() ),
		esc_url( drm_icone( $icone ) ),
		esc_html( $texto )
	);
}

/**
 * Conteúdo de um post do CPT como texto simples (os cards não usam HTML rico).
 */
function drm_texto( $post ) {
	return wp_strip_all_tags( $post->post_content );
}

/**
 * Imagem destacada com fallback silencioso.
 *
 * @return string URL ou string vazia.
 */
function drm_thumb_url( $post_id, $tamanho = 'drm_card' ) {
	$url = get_the_post_thumbnail_url( $post_id, $tamanho );
	return $url ? $url : '';
}
