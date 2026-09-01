<?php
/**
 * Custom Post Types e taxonomia.
 *
 * O modelo está documentado em MODEL.md, na raiz do repositório. A ideia
 * central: os conteúdos que repetem são os mesmos nas duas LPs, e o que muda
 * é o recorte — por isso um CPT por significado e uma taxonomia de campanha
 * para segmentar, em vez de duplicar oito post types por página.
 *
 * @package dr-romulo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Definição declarativa dos CPTs.
 *
 * 'campanha' indica se o tipo é filtrado por campanha (preenchimento /
 * liftera) ou se é compartilhado entre as duas LPs.
 */
function drm_tipos() {
	return array(
		'drm_sinal'       => array(
			'singular' => 'Sinal de alerta',
			'plural'   => 'Sinais de alerta',
			'icone'    => 'dashicons-warning',
			'campanha' => true,
			'thumb'    => true,
		),
		'drm_beneficio'   => array(
			'singular' => 'Benefício',
			'plural'   => 'Benefícios',
			'icone'    => 'dashicons-chart-line',
			'campanha' => true,
			'thumb'    => true,
		),
		'drm_mecanismo'   => array(
			'singular' => 'Como o tratamento age',
			'plural'   => 'Como o tratamento age',
			'icone'    => 'dashicons-visibility',
			'campanha' => true,
			'thumb'    => false,
		),
		'drm_etapa'       => array(
			'singular' => 'Etapa do atendimento',
			'plural'   => 'Etapas do atendimento',
			'icone'    => 'dashicons-list-view',
			'campanha' => true,
			'thumb'    => false,
		),
		'drm_pilar'       => array(
			'singular' => 'Pilar da consulta',
			'plural'   => 'Pilares da consulta',
			'icone'    => 'dashicons-awards',
			'campanha' => true,
			'thumb'    => false,
		),
		'drm_faq'         => array(
			'singular' => 'Pergunta frequente',
			'plural'   => 'Perguntas frequentes',
			'icone'    => 'dashicons-editor-help',
			'campanha' => true,
			'thumb'    => false,
		),
		'drm_depoimento'  => array(
			'singular' => 'Depoimento',
			'plural'   => 'Depoimentos',
			'icone'    => 'dashicons-format-quote',
			'campanha' => false,
			'thumb'    => false,
		),
		'drm_formacao'    => array(
			'singular' => 'Item da trajetória',
			'plural'   => 'Trajetória',
			'icone'    => 'dashicons-welcome-learn-more',
			'campanha' => false,
			'thumb'    => false,
		),
		'drm_foto'        => array(
			'singular' => 'Foto do consultório',
			'plural'   => 'Fotos do consultório',
			'icone'    => 'dashicons-format-gallery',
			'campanha' => false,
			'thumb'    => true,
		),
	);
}

/**
 * Registra os CPTs.
 */
function drm_registrar_cpts() {
	foreach ( drm_tipos() as $slug => $t ) {
		$suporta = array( 'title', 'editor', 'page-attributes' );
		if ( $t['thumb'] ) {
			$suporta[] = 'thumbnail';
		}

		register_post_type(
			$slug,
			array(
				'labels'              => array(
					'name'               => $t['plural'],
					'singular_name'      => $t['singular'],
					'add_new_item'       => 'Adicionar ' . $t['singular'],
					'edit_item'          => 'Editar ' . $t['singular'],
					'new_item'           => 'Novo ' . $t['singular'],
					'view_item'          => 'Ver ' . $t['singular'],
					'search_items'       => 'Buscar em ' . $t['plural'],
					'not_found'          => 'Nada encontrado',
					'menu_name'          => $t['plural'],
				),
				'public'              => false,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_rest'        => true,
				'has_archive'         => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => false,
				'menu_icon'           => $t['icone'],
				'supports'            => $suporta,
				// page-attributes dá o campo de ordem: é ele que controla a
				// sequência dos cards e a numeração 01..06 exibida na página.
				'hierarchical'        => false,
			)
		);
	}
}
add_action( 'init', 'drm_registrar_cpts' );

/**
 * Taxonomia de campanha.
 *
 * Adicionar uma terceira LP passa a ser criar um termo, não um post type.
 */
function drm_registrar_taxonomia() {
	$tipos = array();
	foreach ( drm_tipos() as $slug => $t ) {
		if ( $t['campanha'] ) {
			$tipos[] = $slug;
		}
	}

	register_taxonomy(
		'drm_campanha',
		$tipos,
		array(
			'labels'            => array(
				'name'          => 'Campanhas',
				'singular_name' => 'Campanha',
				'menu_name'     => 'Campanhas',
				'add_new_item'  => 'Adicionar campanha',
			),
			'public'            => false,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'hierarchical'      => true,
		)
	);
}
add_action( 'init', 'drm_registrar_taxonomia' );

/**
 * Ordena os CPTs pelo campo de ordem no admin, para o cliente ver a mesma
 * sequência que sai na página.
 */
function drm_ordem_admin( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}
	$tipo = $query->get( 'post_type' );
	if ( $tipo && isset( drm_tipos()[ $tipo ] ) ) {
		$query->set( 'orderby', 'menu_order' );
		$query->set( 'order', 'ASC' );
	}
}
add_action( 'pre_get_posts', 'drm_ordem_admin' );
