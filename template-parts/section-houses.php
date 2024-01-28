<?php

if (isset($args['city'])) {
	$query_args = array(
		'numberposts' => 10,
		'post_type' => 'houses',
		'meta_query' => array(
			array(
				'key' => 'house_city',
				'value' => $args['city'],
			),
		),

	);
} else {
	$query_args = array(
		'numberposts' => 100,
		'post_type' => 'houses',
	);
}

$houses = get_posts($query_args);

if ($houses):
?>
<section class="mb-5">
				<h2>
					<?php if (isset($args['city'])) {?>
					Объекты недвижимости в этом городе
					<?php } else {?>
						Последние объекты недвижимости
					<?php }?>
				</h2>
				<div class="row">
				<?php foreach ($houses as $house) {
	?>
<div class="col-md-6 col-lg-4 mb-4">
	<a class="card card--link" href="<?php echo get_post_permalink($house->ID); ?>">
		<div class="card-img-container card-img-top">
			<img src="<?php echo get_the_post_thumbnail_url($house, 'medium'); ?>" class="" alt="<?php echo $house->post_title; ?>">
		</div>

		<div class="card-body">
			<h5 class="card-title"><?php echo $house->post_title; ?></h5>
			<p class="card-text">

				<?php if (get_field('ploshhad', $house->ID)): ?>
				    <b>Площадь:</b> <?php echo get_field('ploshhad', $house->ID); ?> м² <br>
					<?php endif;?>

					<?php if (get_field('stoimost', $house->ID)): ?>
				    <b>Стоимость:</b> <?php the_field('stoimost', $house->ID);?> ₽<br>
					<?php endif;?>


					<?php if (get_field('adres', $house->ID)): ?>
				    <b>Адрес:</b> <?php the_field('adres', $house->ID);?><br>
					<?php endif;?>


					<?php if (get_field('zhilaya_ploshhad', $house->ID)): ?>
				    <b>Жилая площадь:</b> <?php the_field('zhilaya_ploshhad', $house->ID);?> м²<br>
					<?php endif;?>


					<?php if (get_field('etazh', $house->ID)): ?>
				    <b>Этаж:</b> <?php the_field('etazh', $house->ID);?>
					<?php endif;?>

			</p>

		</div>
	</a>
</div>
				<?php }?>

				</div>

			</section>

<?php endif;?>
