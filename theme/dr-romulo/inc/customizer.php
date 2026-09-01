<?php
/**
 * Customizer — dados globais, iguais nas duas LPs.
 *
 * @package dr-romulo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Campos do Customizer, declarados numa tabela só.
 *
 * 'aviso' vira a descrição do campo no painel; usado para marcar o que é
 * exigência legal.
 */
function drm_campos_customizer() {
	return array(
		'contato'  => array(
			'titulo'  => 'Contato',
			'campos'  => array(
				'drm_whatsapp'     => array( 'label' => 'WhatsApp (só números, com DDI)', 'padrao' => '5511949128259' ),
				'drm_whatsapp_msg' => array( 'label' => 'Mensagem pré-preenchida do WhatsApp', 'padrao' => 'Olá, gostaria de agendar uma avaliação.' ),
				'drm_telefone'     => array( 'label' => 'Telefone exibido', 'padrao' => '(11) 94912-8259' ),
				'drm_email'        => array( 'label' => 'E-mail', 'padrao' => 'dr.romulo.contato@gmail.com' ),
				'drm_instagram'    => array( 'label' => 'Instagram (@)', 'padrao' => '@romulo.dermato' ),
			),
		),
		'local'    => array(
			'titulo' => 'Localização',
			'campos' => array(
				'drm_clinica'  => array( 'label' => 'Nome da clínica', 'padrao' => 'EviDenS Clinic' ),
				'drm_endereco' => array( 'label' => 'Endereço', 'padrao' => 'Rua Dr. Diogo de Faria, 1087 — conj. 901-904' ),
				'drm_bairro'   => array( 'label' => 'Bairro / cidade', 'padrao' => 'Vila Clementino, São Paulo/SP' ),
				'drm_maps'     => array( 'label' => 'Link do Google Maps', 'padrao' => '' ),
			),
		),
		'medico'   => array(
			'titulo' => 'Responsável técnico',
			'campos' => array(
				'drm_medico_nome' => array( 'label' => 'Nome do médico', 'padrao' => 'Dr. Rômulo Malaquias' ),
				'drm_crm'         => array(
					'label'  => 'CRM',
					'padrao' => 'CRM-SP 00000',
					'aviso'  => 'OBRIGATÓRIO. A Resolução CFM 1.974/2011 exige CRM real em publicidade médica. O valor atual é um placeholder.',
				),
				'drm_rqe'         => array(
					'label'  => 'RQE',
					'padrao' => 'RQE 00000',
					'aviso'  => 'OBRIGATÓRIO. Registro de Qualificação de Especialista. O valor atual é um placeholder.',
				),
				'drm_diretor'     => array(
					'label'  => 'Diretor técnico da clínica (nome + CRM)',
					'padrao' => 'Diretor técnico da clínica (nome + CRM)',
					'aviso'  => 'OBRIGATÓRIO por resolução do CFM. O valor atual é um placeholder.',
				),
			),
		),
		'legal'    => array(
			'titulo' => 'Textos legais',
			'campos' => array(
				'drm_disclaimer' => array(
					'label'  => 'Aviso do rodapé',
					'tipo'   => 'textarea',
					'padrao' => 'Esta página tem caráter informativo e não substitui a consulta médica. A indicação de qualquer procedimento depende de avaliação individual. Resultados variam de acordo com cada paciente.',
				),
				'drm_privacidade' => array( 'label' => 'URL da Política de Privacidade', 'padrao' => '' ),
				'drm_termos'      => array( 'label' => 'URL dos Termos de Uso', 'padrao' => '' ),
			),
		),
	);
}

/**
 * Registra as seções e os campos.
 */
function drm_customizer( $wp_customize ) {
	$ordem = 20;

	foreach ( drm_campos_customizer() as $secao => $dados ) {
		$id_secao = 'drm_' . $secao;

		$wp_customize->add_section(
			$id_secao,
			array(
				'title'    => $dados['titulo'],
				'panel'    => '',
				'priority' => $ordem++,
			)
		);

		foreach ( $dados['campos'] as $id => $campo ) {
			$tipo = isset( $campo['tipo'] ) ? $campo['tipo'] : 'text';

			$wp_customize->add_setting(
				$id,
				array(
					'default'           => $campo['padrao'],
					'sanitize_callback' => 'textarea' === $tipo ? 'sanitize_textarea_field' : 'sanitize_text_field',
					'transport'         => 'refresh',
				)
			);

			$wp_customize->add_control(
				$id,
				array(
					'label'       => $campo['label'],
					'section'     => $id_secao,
					'type'        => $tipo,
					'description' => isset( $campo['aviso'] ) ? $campo['aviso'] : '',
				)
			);
		}
	}

	// Identidade: logos
	$wp_customize->add_section( 'drm_identidade', array( 'title' => 'Identidade', 'priority' => 15 ) );

	foreach ( array(
		'drm_logo'        => 'Logo (fundo claro)',
		'drm_logo_branco' => 'Logo (fundo escuro / rodapé)',
	) as $id => $label ) {
		$wp_customize->add_setting( $id, array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
		$wp_customize->add_control(
			new WP_Customize_Image_Control( $wp_customize, $id, array( 'label' => $label, 'section' => 'drm_identidade' ) )
		);
	}
}
add_action( 'customize_register', 'drm_customizer' );
