<?php
/**
 * The template for displaying all single posts
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();
$container = get_theme_mod('understrap_container_type');
?>

<div class="wrapper" id="single-wrapper">

	<div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

		<div class="row">

		<?php
// Do the left sidebar check and open div#primary.
get_template_part('global-templates/left-sidebar-check');
?>

			<main class="site-main" id="main">

			<?php
while (have_posts()) {
	the_post();
	?>


				<article <?php post_class();?> id="post-<?php the_ID();?>">

					<header class="entry-header">

						<?php the_title('<h1 class="entry-title">', '</h1>');?>

						<div class="entry-meta">

							<?php understrap_posted_on();?>

						</div><!-- .entry-meta -->

					</header><!-- .entry-header -->

					<?php echo get_the_post_thumbnail($post->ID, 'large'); ?>

					<div class="entry-content">

					<?php
the_content();
	understrap_link_pages();
	?>

					<?php if (get_field('ploshhad')): ?>
				    <p>Площадь: <?php the_field('ploshhad');?> м²</p>
					<?php endif;?>

					<?php if (get_field('stoimost')): ?>
				    <p>Стоимость: <?php the_field('stoimost');?> ₽</p>
					<?php endif;?>


					<?php if (get_field('adres')): ?>
				    <p>Адрес: <?php the_field('adres');?></p>
					<?php endif;?>


					<?php if (get_field('zhilaya_ploshhad')): ?>
				    <p>Жилая площадь: <?php the_field('zhilaya_ploshhad');?> м²</p>
					<?php endif;?>


					<?php if (get_field('etazh')): ?>
				    <p>Этаж: <?php the_field('etazh');?></p>
					<?php endif;?>


					</div><!-- .entry-content -->

					<footer class="entry-footer">

						<?php understrap_entry_footer();?>

					</footer><!-- .entry-footer -->

				</article><!-- #post-<?php the_ID();?> -->


				<?php
understrap_post_nav();

	// If comments are open or we have at least one comment, load up the comment template.
	if (comments_open() || get_comments_number()) {
		comments_template();
	}
}
?>

			</main>

			<?php
// Do the right sidebar check and close div#primary.
get_template_part('global-templates/right-sidebar-check');
?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #single-wrapper -->

<?php
get_footer();
