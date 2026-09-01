<?php
/**
 * Seeder — popula o site em um clique.
 *
 * Cria as campanhas, importa as imagens do tema para a Mídia, cria todos os
 * itens dos CPTs com o conteúdo já validado contra o Figma, monta as páginas
 * com seus meta fields e configura a home.
 *
 * O conteúdo vem de inc/dados-seed.php, que é gerado a partir do HTML
 * estático — ver o cabeçalho daquele arquivo.
 *
 * @package dr-romulo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Página do seeder em Ferramentas.
 */
function drm_menu_seeder() {
	add_management_page(
		'Popular site — Dr. Rômulo',
		'Popular site',
		'manage_options',
		'drm-seeder',
		'drm_tela_seeder'
	);
}
add_action( 'admin_menu', 'drm_menu_seeder' );

/**
 * Tela.
 */
function drm_tela_seeder() {
	$rodou = get_option( 'drm_seed_rodado' );
	?>
	<div class="wrap">
		<h1>Popular site</h1>

		<?php if ( isset( $_GET['drm_ok'] ) ) : ?>
			<div class="notice notice-success"><p><strong>Pronto.</strong> <?php echo esc_html( get_option( 'drm_seed_resumo' ) ); ?></p></div>
		<?php endif; ?>

		<p>
			Cria as campanhas, importa as imagens do tema para a biblioteca de Mídia,
			cadastra todo o conteúdo das duas landing pages e configura a home.
		</p>

		<?php if ( $rodou ) : ?>
			<div class="notice notice-warning inline">
				<p>
					O seeder já foi executado em <strong><?php echo esc_html( $rodou ); ?></strong>.
					Rodar de novo <strong>cria conteúdo duplicado</strong> — use só se você apagou os itens antes.
				</p>
			</div>
		<?php endif; ?>

		<form method="post">
			<?php wp_nonce_field( 'drm_rodar_seed', 'drm_seed_nonce' ); ?>
			<p>
				<label>
					<input type="checkbox" name="drm_confirmo" value="1" required>
					Entendo que isso cria conteúdo no site.
				</label>
			</p>
			<?php submit_button( $rodou ? 'Rodar novamente' : 'Popular o site', 'primary', 'drm_rodar' ); ?>
		</form>

		<hr>
		<h2>Depois de rodar</h2>
		<ol>
			<li>Preencha <strong>CRM, RQE e diretor técnico</strong> em Aparência → Personalizar → Responsável técnico. Os valores vêm como placeholder e são exigência do CFM.</li>
			<li>Confira Aparência → Personalizar → Contato e Localização.</li>
			<li>Revise o texto alternativo das fotos do consultório em Mídia.</li>
		</ol>
	</div>
	<?php
}

/**
 * Executa.
 */
function drm_executar_seeder() {
	if ( ! isset( $_POST['drm_rodar'] ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( ! isset( $_POST['drm_seed_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['drm_seed_nonce'] ) ), 'drm_rodar_seed' ) ) {
		return;
	}

	$dados = require DRM_DIR . '/inc/dados-seed.php';
	$conta = array( 'termos' => 0, 'itens' => 0, 'imagens' => 0, 'paginas' => 0 );

	// 1. campanhas
	foreach ( $dados['campanhas'] as $c ) {
		if ( ! term_exists( $c['slug'], 'drm_campanha' ) ) {
			wp_insert_term( $c['nome'], 'drm_campanha', array( 'slug' => $c['slug'] ) );
			$conta['termos']++;
		}
	}

	// 2. itens por campanha
	foreach ( $dados['itens'] as $tipo => $campanhas ) {
		foreach ( $campanhas as $campanha => $itens ) {
			foreach ( $itens as $i => $item ) {
				$id = drm_criar_item( $tipo, $item, $i );
				if ( ! $id ) {
					continue;
				}
				wp_set_object_terms( $id, $campanha, 'drm_campanha' );
				$conta['itens']++;
				if ( ! empty( $item['imagem'] ) && drm_anexar_imagem( $id, $item['imagem'] ) ) {
					$conta['imagens']++;
				}
			}
		}
	}

	// 3. itens compartilhados
	foreach ( $dados['compartilhados'] as $tipo => $itens ) {
		foreach ( $itens as $i => $item ) {
			$id = drm_criar_item( $tipo, $item, $i );
			if ( ! $id ) {
				continue;
			}
			$conta['itens']++;
			if ( ! empty( $item['imagem'] ) && drm_anexar_imagem( $id, $item['imagem'] ) ) {
				$conta['imagens']++;
			}
		}
	}

	// 4. páginas
	$ids = array();
	foreach ( $dados['paginas'] as $chave => $p ) {
		$existente = get_page_by_path( $p['slug'], OBJECT, 'page' );
		if ( $existente ) {
			$ids[ $chave ] = $existente->ID;
			continue;
		}

		$id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $p['titulo'],
				'post_name'    => $p['slug'],
				'post_content' => isset( $p['conteudo'] ) ? $p['conteudo'] : '',
			)
		);
		if ( is_wp_error( $id ) ) {
			continue;
		}

		$ids[ $chave ] = $id;
		$conta['paginas']++;

		if ( ! empty( $p['template'] ) ) {
			update_post_meta( $id, '_wp_page_template', $p['template'] );
		}
		if ( ! empty( $p['meta'] ) ) {
			foreach ( $p['meta'] as $k => $v ) {
				update_post_meta( $id, $k, $v );
			}
		}
		if ( ! empty( $p['imagem'] ) && drm_anexar_imagem( $id, $p['imagem'] ) ) {
			$conta['imagens']++;
		}
	}

	// 5. home estática
	if ( isset( $ids['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['home'] );
	}

	$resumo = sprintf(
		'%d campanhas, %d itens, %d imagens e %d páginas.',
		$conta['termos'],
		$conta['itens'],
		$conta['imagens'],
		$conta['paginas']
	);
	update_option( 'drm_seed_rodado', current_time( 'd/m/Y H:i' ) );
	update_option( 'drm_seed_resumo', $resumo );

	wp_safe_redirect( admin_url( 'tools.php?page=drm-seeder&drm_ok=1' ) );
	exit;
}
add_action( 'admin_init', 'drm_executar_seeder' );

/**
 * Cria um item de CPT.
 *
 * @return int|false
 */
function drm_criar_item( $tipo, $item, $ordem ) {
	$id = wp_insert_post(
		array(
			'post_type'    => $tipo,
			'post_status'  => 'publish',
			'post_title'   => isset( $item['titulo'] ) ? $item['titulo'] : '',
			'post_content' => isset( $item['texto'] ) ? $item['texto'] : '',
			'menu_order'   => $ordem,
		)
	);
	if ( is_wp_error( $id ) ) {
		return false;
	}

	if ( ! empty( $item['icone'] ) ) {
		update_post_meta( $id, 'drm_icone', $item['icone'] );
	}
	if ( ! empty( $item['escuro'] ) ) {
		update_post_meta( $id, 'drm_badge_escuro', $item['escuro'] );
	}
	if ( ! empty( $item['data'] ) ) {
		update_post_meta( $id, 'drm_data', $item['data'] );
	}

	return $id;
}

/**
 * Copia uma imagem de assets/images para a Mídia e define como destacada.
 *
 * Reaproveita o anexo se o arquivo já foi importado, para não encher a
 * biblioteca ao rodar o seeder mais de uma vez.
 *
 * @return bool
 */
function drm_anexar_imagem( $post_id, $arquivo ) {
	$origem = DRM_DIR . '/assets/images/' . $arquivo;
	if ( ! file_exists( $origem ) ) {
		return false;
	}

	$existente = drm_achar_anexo( $arquivo );
	if ( $existente ) {
		set_post_thumbnail( $post_id, $existente );
		return false; // não conta como nova importação
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$upload = wp_upload_bits( $arquivo, null, file_get_contents( $origem ) ); // phpcs:ignore
	if ( ! empty( $upload['error'] ) ) {
		return false;
	}

	$tipo   = wp_check_filetype( $upload['file'] );
	$anexo  = array(
		'post_mime_type' => $tipo['type'],
		'post_title'     => sanitize_file_name( pathinfo( $arquivo, PATHINFO_FILENAME ) ),
		'post_status'    => 'inherit',
	);
	$att_id = wp_insert_attachment( $anexo, $upload['file'], $post_id );
	if ( is_wp_error( $att_id ) ) {
		return false;
	}

	wp_update_attachment_metadata( $att_id, wp_generate_attachment_metadata( $att_id, $upload['file'] ) );
	update_post_meta( $att_id, '_drm_origem', $arquivo );
	set_post_thumbnail( $post_id, $att_id );

	return true;
}

/**
 * Procura um anexo já importado pelo nome do arquivo de origem.
 *
 * @return int|false
 */
function drm_achar_anexo( $arquivo ) {
	$achados = get_posts(
		array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'posts_per_page' => 1,
			'meta_key'       => '_drm_origem',   // phpcs:ignore
			'meta_value'     => $arquivo,        // phpcs:ignore
			'fields'         => 'ids',
			'no_found_rows'  => true,
		)
	);
	return $achados ? $achados[0] : false;
}

/**
 * Aviso persistente enquanto CRM/RQE seguirem como placeholder.
 *
 * É exigência da Resolução CFM 1.974/2011 e some sozinho quando os valores
 * reais forem preenchidos.
 */
function drm_aviso_crm() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$pendentes = array();
	if ( false !== strpos( drm_opt( 'drm_crm' ), '00000' ) ) {
		$pendentes[] = 'CRM';
	}
	if ( false !== strpos( drm_opt( 'drm_rqe' ), '00000' ) ) {
		$pendentes[] = 'RQE';
	}
	if ( false !== strpos( drm_opt( 'drm_diretor' ), 'nome + CRM' ) ) {
		$pendentes[] = 'diretor técnico';
	}
	if ( ! $pendentes ) {
		return;
	}
	printf(
		'<div class="notice notice-error"><p><strong>Pendência legal:</strong> %s ainda com valor de exemplo. '
			. 'A Resolução CFM 1.974/2011 exige esses dados reais em publicidade médica. '
			. '<a href="%s">Preencher agora</a>.</p></div>',
		esc_html( implode( ', ', $pendentes ) ),
		esc_url( admin_url( 'customize.php?autofocus[section]=drm_medico' ) )
	);
}
add_action( 'admin_notices', 'drm_aviso_crm' );
