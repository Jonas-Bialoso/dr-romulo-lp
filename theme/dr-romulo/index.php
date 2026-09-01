<?php
/**
 * Fallback obrigatório do WordPress.
 *
 * O tema é de landing page: não há blog nem arquivo. Qualquer rota que não
 * seja uma das duas LPs cai aqui e é redirecionada para a home, em vez de
 * mostrar uma listagem vazia.
 *
 * @package dr-romulo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<section class="section">
	<div class="section__inner stack-56">
		<?php if ( have_posts() ) : ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class(); ?>>
					<header class="section-header">
						<h1 class="section-heading"><?php the_title(); ?></h1>
					</header>
					<div class="about__narrative"><?php the_content(); ?></div>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<header class="section-header">
				<h1 class="section-heading">Página não encontrada</h1>
			</header>
			<p class="split-media__text">
				O endereço que você acessou não existe.
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Voltar para a página inicial</a>.
			</p>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
