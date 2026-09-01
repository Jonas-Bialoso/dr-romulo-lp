<?php
/**
 * Meta boxes das páginas de LP.
 *
 * Meta box nativo, sem ACF: o MODEL.md registra essa decisão para o tema não
 * depender de plugin. Os rótulos estão em português porque quem opera o admin
 * é o cliente, não um dev.
 *
 * @package dr-romulo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Estrutura dos campos por bloco.
 */
function drm_campos_pagina() {
	return array(
		'campanha' => array(
			'titulo' => 'Campanha desta página',
			'campos' => array(
				'drm_campanha_slug' => array(
					'label' => 'Slug da campanha',
					'ajuda' => 'Define quais sinais, benefícios, etapas, pilares e perguntas aparecem. Use "preenchimento" ou "liftera".',
				),
			),
		),
		'hero' => array(
			'titulo' => 'Hero',
			'campos' => array(
				'drm_hero_eyebrow'   => array( 'label' => 'Chapéu' ),
				'drm_hero_titulo'    => array( 'label' => 'Título', 'tipo' => 'textarea' ),
				'drm_hero_lead'      => array( 'label' => 'Parágrafo principal', 'tipo' => 'textarea' ),
				'drm_hero_apoio'     => array( 'label' => 'Parágrafo de apoio', 'tipo' => 'textarea' ),
				'drm_hero_cta'       => array( 'label' => 'Texto do botão', 'padrao' => 'Agendar minha avaliação' ),
				'drm_hero_micro'     => array( 'label' => 'Microcopy ao lado do botão' ),
				'drm_hero_badge_tit' => array( 'label' => 'Badge sobre a foto — título' ),
				'drm_hero_badge_txt' => array( 'label' => 'Badge sobre a foto — descrição' ),
				'drm_hero_titulo_px' => array( 'label' => 'Tamanho do título em px', 'ajuda' => 'A LP de preenchimento usa 48; a do Liftera, 37.' ),
			),
		),
		'sinais' => array(
			'titulo' => 'Seção: Sinais de alerta',
			'campos' => array(
				'drm_sinais_eyebrow'  => array( 'label' => 'Chapéu' ),
				'drm_sinais_titulo'   => array( 'label' => 'Título', 'tipo' => 'textarea' ),
				'drm_sinais_lead'     => array( 'label' => 'Descrição', 'tipo' => 'textarea' ),
				'drm_sinais_callout'  => array( 'label' => 'Aviso do bloco escuro', 'tipo' => 'textarea' ),
				'drm_sinais_layout'   => array( 'label' => 'Layout dos cards', 'ajuda' => 'Use "icone" (LP de preenchimento) ou "foto" (LP do Liftera).', 'padrao' => 'icone' ),
			),
		),
		'beneficios' => array(
			'titulo' => 'Seção: Benefícios / Objetivos',
			'campos' => array(
				'drm_benef_eyebrow' => array( 'label' => 'Chapéu' ),
				'drm_benef_titulo'  => array( 'label' => 'Título', 'tipo' => 'textarea' ),
				'drm_benef_lead'    => array( 'label' => 'Descrição', 'tipo' => 'textarea' ),
				'drm_benef_callout' => array( 'label' => 'Aviso do bloco escuro', 'tipo' => 'textarea' ),
				'drm_benef_layout'  => array( 'label' => 'Layout dos cards', 'ajuda' => '"lista" ou "foto".', 'padrao' => 'lista' ),
				'drm_benef_intro'   => array( 'label' => 'Texto introdutório da coluna', 'tipo' => 'textarea' ),
				'drm_benef_rotulo'  => array( 'label' => 'Rótulo acima da lista' ),
				// Só a LP do Liftera usa: lá esta seção aparece duas vezes,
				// uma explicando o aparelho e outra listando os objetivos.
				'drm_benef_eyebrow_2' => array( 'label' => 'Chapéu do bloco de objetivos (só Liftera)', 'padrao' => 'Objetivos Clínicos' ),
				'drm_benef_titulo_2'  => array( 'label' => 'Título do bloco de objetivos (só Liftera)', 'padrao' => 'O que esperar do tratamento' ),
			),
		),
		'etapas' => array(
			'titulo' => 'Seção: Como funciona',
			'campos' => array(
				'drm_etapas_eyebrow' => array( 'label' => 'Chapéu' ),
				'drm_etapas_titulo'  => array( 'label' => 'Título', 'tipo' => 'textarea' ),
				'drm_etapas_lead'    => array( 'label' => 'Descrição', 'tipo' => 'textarea' ),
			),
		),
		'diferencial' => array(
			'titulo' => 'Seção: Diferencial',
			'campos' => array(
				'drm_dif_eyebrow' => array( 'label' => 'Chapéu' ),
				'drm_dif_titulo'  => array( 'label' => 'Título', 'tipo' => 'textarea' ),
				'drm_dif_texto'   => array( 'label' => 'Parágrafo (só na LP do Liftera)', 'tipo' => 'textarea' ),
				'drm_dif_rotulo'  => array( 'label' => 'Rótulo acima dos pilares' ),
			),
		),
		'cta_meio' => array(
			'titulo' => 'CTA intermediária',
			'campos' => array(
				'drm_ctam_eyebrow' => array( 'label' => 'Chapéu' ),
				'drm_ctam_titulo'  => array( 'label' => 'Título', 'tipo' => 'textarea' ),
				'drm_ctam_texto'   => array( 'label' => 'Parágrafo', 'tipo' => 'textarea' ),
				'drm_ctam_botao'   => array( 'label' => 'Texto do botão', 'padrao' => 'Falar com a equipe no WhatsApp' ),
				'drm_ctam_micro'   => array( 'label' => 'Microcopy' ),
			),
		),
		'cta_final' => array(
			'titulo' => 'CTA final',
			'campos' => array(
				'drm_ctaf_titulo' => array( 'label' => 'Título', 'tipo' => 'textarea' ),
				'drm_ctaf_texto'  => array( 'label' => 'Parágrafo', 'tipo' => 'textarea' ),
				'drm_ctaf_botao'  => array( 'label' => 'Texto do botão', 'padrao' => 'Falar com a equipe no WhatsApp' ),
				'drm_ctaf_micro'  => array( 'label' => 'Microcopy' ),
			),
		),
		'faq' => array(
			'titulo' => 'Seção: Dúvidas frequentes',
			'campos' => array(
				'drm_faq_eyebrow' => array( 'label' => 'Chapéu', 'padrao' => 'Dúvidas frequentes' ),
				'drm_faq_titulo'  => array( 'label' => 'Título', 'padrao' => 'Dúvidas frequentes' ),
				'drm_faq_botao'   => array( 'label' => 'Texto do botão', 'padrao' => 'Tire suas dúvidas' ),
			),
		),
	);
}

/**
 * Todos os campos numa lista plana.
 */
function drm_campos_pagina_flat() {
	$flat = array();
	foreach ( drm_campos_pagina() as $bloco ) {
		foreach ( $bloco['campos'] as $id => $campo ) {
			$flat[ $id ] = $campo;
		}
	}
	return $flat;
}

/**
 * Registra os meta boxes só em páginas.
 */
function drm_add_meta_boxes() {
	foreach ( drm_campos_pagina() as $slug => $bloco ) {
		add_meta_box(
			'drm_box_' . $slug,
			$bloco['titulo'],
			'drm_render_meta_box',
			'page',
			'normal',
			'default',
			array( 'bloco' => $slug )
		);
	}
}
add_action( 'add_meta_boxes', 'drm_add_meta_boxes' );

/**
 * Render do meta box.
 */
function drm_render_meta_box( $post, $box ) {
	$slug   = $box['args']['bloco'];
	$blocos = drm_campos_pagina();
	$campos = $blocos[ $slug ]['campos'];

	wp_nonce_field( 'drm_salvar_meta', 'drm_meta_nonce' );

	echo '<table class="form-table" role="presentation"><tbody>';
	foreach ( $campos as $id => $campo ) {
		$valor = get_post_meta( $post->ID, $id, true );
		if ( '' === $valor && isset( $campo['padrao'] ) ) {
			$valor = $campo['padrao'];
		}
		$tipo = isset( $campo['tipo'] ) ? $campo['tipo'] : 'text';

		echo '<tr>';
		printf( '<th scope="row"><label for="%s">%s</label></th>', esc_attr( $id ), esc_html( $campo['label'] ) );
		echo '<td>';
		if ( 'textarea' === $tipo ) {
			printf(
				'<textarea id="%s" name="%s" rows="3" class="large-text">%s</textarea>',
				esc_attr( $id ),
				esc_attr( $id ),
				esc_textarea( $valor )
			);
		} else {
			printf(
				'<input type="text" id="%s" name="%s" value="%s" class="large-text">',
				esc_attr( $id ),
				esc_attr( $id ),
				esc_attr( $valor )
			);
		}
		if ( isset( $campo['ajuda'] ) ) {
			printf( '<p class="description">%s</p>', esc_html( $campo['ajuda'] ) );
		}
		echo '</td></tr>';
	}
	echo '</tbody></table>';
}

/**
 * Salva.
 */
function drm_salvar_meta( $post_id ) {
	if ( ! isset( $_POST['drm_meta_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['drm_meta_nonce'] ) ), 'drm_salvar_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( drm_campos_pagina_flat() as $id => $campo ) {
		if ( ! isset( $_POST[ $id ] ) ) {
			continue;
		}
		$bruto = wp_unslash( $_POST[ $id ] );
		$tipo  = isset( $campo['tipo'] ) ? $campo['tipo'] : 'text';
		$valor = 'textarea' === $tipo ? sanitize_textarea_field( $bruto ) : sanitize_text_field( $bruto );
		update_post_meta( $post_id, $id, $valor );
	}
}
add_action( 'save_post_page', 'drm_salvar_meta' );
