<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();

$container = get_theme_mod('understrap_container_type');

?>



<div class="wrapper" id="page-wrapper">

	<div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

		<div class="row">

			<?php
// Do the left sidebar check and open div#primary.
get_template_part('global-templates/left-sidebar-check');
?>

			<main class="site-main" id="main">

				<section class="mb-5">

<?php $args = array(
	'numberposts' => 10,
	'post_type' => 'cities',
	'order' => 'ASC',
	'orderby' => 'title',
);
$сities = get_posts($args);
if ($сities):
?>

				<h2>Города</h2>
				<div class="row">
				<?php foreach ($сities as $сity) {?>



					<div class="col-md-6 col-lg-4 mb-4">
						<a class="card card--link" href="<?php echo get_post_permalink($сity->ID); ?>">
							<div class="card-img-container card-img-top">
								<img src="<?php echo get_the_post_thumbnail_url($сity, 'medium'); ?>" class="" alt="<?php echo $сity->post_title; ?>">
							</div>

							<div class="card-body">
								<h5 class="card-title"><?php echo $сity->post_title; ?></h5>
							</div>
						</a>
					</div>
				<?php }?>
				<?php endif;?>
				</div>

			</section>






<?php get_template_part('template-parts/section-houses');?>


				<section class="mb-5">

					<h2>Добавить объект недвижимости</h2>

<?php echo do_shortcode('[contact-form-7 id="ef62c79" title="Добавление объекта недвижимости"]'); ?>

				</section>

			</main>

			<?php
// Do the right sidebar check and close div#primary.
get_template_part('global-templates/right-sidebar-check');
?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #page-wrapper -->

<?php
get_footer();
