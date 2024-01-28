<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Removes the parent themes stylesheet and scripts from inc/enqueue.php
 */
function understrap_remove_scripts() {
	wp_dequeue_style('understrap-styles');
	wp_deregister_style('understrap-styles');

	wp_dequeue_script('understrap-scripts');
	wp_deregister_script('understrap-scripts');
}
add_action('wp_enqueue_scripts', 'understrap_remove_scripts', 20);

/**
 * Enqueue our stylesheet and javascript file
 */
function theme_enqueue_styles() {

	// Get the theme data.
	$the_theme = wp_get_theme();
	$theme_version = $the_theme->get('Version');

	$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
	// Grab asset urls.
	$theme_styles = "/css/child-theme{$suffix}.css";
	$theme_scripts = "/js/child-theme{$suffix}.js";

	$css_version = $theme_version . '.' . filemtime(get_stylesheet_directory() . $theme_styles);

	wp_enqueue_style('child-understrap-styles', get_stylesheet_directory_uri() . $theme_styles, array(), $css_version);
	wp_enqueue_script('jquery');

	$js_version = $theme_version . '.' . filemtime(get_stylesheet_directory() . $theme_scripts);

	wp_enqueue_script('child-understrap-scripts', get_stylesheet_directory_uri() . $theme_scripts, array(), $js_version, true);
	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

/**
 * Load the child theme's text domain
 */
function add_child_theme_textdomain() {
	load_child_theme_textdomain('understrap-child', get_stylesheet_directory() . '/languages');
}
add_action('after_setup_theme', 'add_child_theme_textdomain');

/**
 * Overrides the theme_mod to default to Bootstrap 5
 *
 * This function uses the `theme_mod_{$name}` hook and
 * can be duplicated to override other theme settings.
 *
 * @return string
 */
function understrap_default_bootstrap_version() {
	return 'bootstrap5';
}
add_filter('theme_mod_understrap_bootstrap_version', 'understrap_default_bootstrap_version', 20);

/**
 * Loads javascript for showing customizer warning dialog.
 */
function understrap_child_customize_controls_js() {
	wp_enqueue_script(
		'understrap_child_customizer',
		get_stylesheet_directory_uri() . '/js/customizer-controls.js',
		array('customize-preview'),
		'20130508',
		true
	);
}
add_action('customize_controls_enqueue_scripts', 'understrap_child_customize_controls_js');

/*Custom Houses type*/
function cw_post_type_houses() {
	$supports = array(
		'title', // post title
		'editor', // post content
		'author', // post author
		'thumbnail', // featured images
		'excerpt', // post excerpt
		'custom-fields', // custom fields
		'comments', // post comments
		'revisions', // post revisions
		'post-formats', // post formats
	);
	$labels = array(
		'name' => _x('Недвижимость', 'plural'),
		'singular_name' => _x('Недвижимость', 'singular'),
		'menu_name' => _x('Недвижимость', 'admin menu'),
		'name_admin_bar' => _x('Недвижимость', 'admin bar'),
		'add_new' => _x('Добавить новую', 'add new'),
		'add_new_item' => __('Добавить новую недвижимость'),
		'new_item' => __('Новая недвижимость'),
		'edit_item' => __('Редактировать недвижимость'),
		'view_item' => __('Смотреть недвижимость'),
		'all_items' => __('Вся недвижимость'),
		'search_items' => __('Искать недвижимость'),
		'not_found' => __('Недвижимость не найдена'),
	);
	$args = array(
		'supports' => $supports,
		'labels' => $labels,
		'public' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'houses'),
		'has_archive' => true,
		'hierarchical' => false,
	);
	register_post_type('houses', $args);
}
add_action('init', 'cw_post_type_houses');

register_taxonomy('house_type', ['houses'], [
	'label' => __('Типы недвижемости', 'txtdomain'),
	'hierarchical' => true,
	'rewrite' => ['slug' => 'house-type'],
	'show_admin_column' => true,
	'show_in_rest' => true,
	'labels' => [
		'singular_name' => __('Тип недвижимости', 'txtdomain'),
		'all_items' => __('Все типы недвижемости', 'txtdomain'),
		'edit_item' => __('Редактировать тип недвижемости', 'txtdomain'),
		'view_item' => __('Смотреть тип недвижемости', 'txtdomain'),
		'update_item' => __('Обновить тип недвижемости', 'txtdomain'),
		'add_new_item' => __('Добавтить тип недвижемости', 'txtdomain'),
		'new_item_name' => __('Имя нового типа недвижемости', 'txtdomain'),
		'search_items' => __('Искать тип недвижемости', 'txtdomain'),
		'parent_item' => __('Родительский тип недвижемости', 'txtdomain'),
		'parent_item_colon' => __('Родительский тип недвижемости:', 'txtdomain'),
		'not_found' => __('Тип недвижемости не найден', 'txtdomain'),
	],
]);
register_taxonomy_for_object_type('house_type', 'houses');

/*Custom Cities type*/
function cw_post_type_cities() {
	$supports = array(
		'title', // post title
		'editor', // post content
		'author', // post author
		'thumbnail', // featured images
		'excerpt', // post excerpt
		'custom-fields', // custom fields
		'comments', // post comments
		'revisions', // post revisions
		'post-formats', // post formats
	);
	$labels = array(
		'name' => _x('Города', 'plural'),
		'singular_name' => _x('Города', 'singular'),
		'menu_name' => _x('Города', 'admin menu'),
		'name_admin_bar' => _x('Города', 'admin bar'),
		'add_new' => _x('Add New', 'add new'),
		'add_new_item' => __('Add New cities'),
		'new_item' => __('New cities'),
		'edit_item' => __('Edit cities'),
		'view_item' => __('View cities'),
		'all_items' => __('All cities'),
		'search_items' => __('Search cities'),
		'not_found' => __('No cities found.'),
	);
	$args = array(
		'supports' => $supports,
		'labels' => $labels,
		'public' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'cities'),
		'has_archive' => true,
		'hierarchical' => false,
	);
	register_post_type('cities', $args);
}
add_action('init', 'cw_post_type_cities');

/* Fire our meta box setup function on the post editor screen. */
add_action('load-post.php', 'houses_post_meta_boxes_setup');
add_action('load-post-new.php', 'houses_post_meta_boxes_setup');

/* Create one or more meta boxes to be displayed on the post editor screen. */
function houses_add_post_meta_boxes() {

	add_meta_box(
		'house-city', // Unique ID
		esc_html__('Город', 'example'), // Title
		'house_city_meta_box', // Callback function
		'houses', // Admin page (or post type)
		'normal', // Context
		'default' // Priority
	);
}

/* Display the post meta box. */
function house_city_meta_box($post) {
	?>

  <?php wp_nonce_field(basename(__FILE__), 'house_city_nonce');?>

  <p>
    <!-- <label for="house-city"><?php \_e("Город", 'example');?></label> -->

   <?php $db_house_city = esc_attr(get_post_meta($post->ID, 'house_city', true));?>

   <?php $args = array(
		'numberposts' => 0,
		'post_type' => 'cities',
		'order' => 'ASC',
		'orderby' => 'title',
	);
	$cities = get_posts($args);

	// var_dump($cities);

	if ($cities): ?>
	<select name="house-city">
		<option>Не выбрано</option>
	    <?php foreach ($cities as $сity) {?>
	    	<?php $selected = ($сity->ID == $db_house_city) ? 'selected' : '';?>
			<option value="<?php echo $сity->ID; ?>" <?php echo $selected; ?> >
				<?php echo $сity->post_title; ?>
			</option>
		<?php }?>
	</select>
	<?php else: ?>
		Чтобы выбрать город, его сначала нужно <a href="/wp-admin/edit.php?post_type=ities" target="_blank">добавить</a>.
	<?php endif;?>
  </p>
<?php }

/* Save post meta on the 'save_post' hook. */
add_action('save_post', 'save_house_meta', 10, 2);

/* Meta box setup function. */
function houses_post_meta_boxes_setup() {

	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action('add_meta_boxes', 'houses_add_post_meta_boxes');

	/* Save post meta on the 'save_post' hook. */
	add_action('save_post', 'save_house_meta', 10, 2);
}

/* Save the meta box’s post metadata. */
function save_house_meta($post_id, $post) {

	/* Verify the nonce before proceeding. */
	if (!isset($_POST['house_city_nonce']) || !wp_verify_nonce($_POST['house_city_nonce'], basename(__FILE__))) {
		return $post_id;
	}

	/* Get the post type object. */
	$post_type = get_post_type_object($post->post_type);

	/* Check if the current user has permission to edit the post. */
	if (!current_user_can($post_type->cap->edit_post, $post_id)) {
		return $post_id;
	}

	/* Get the posted data and sanitize it for use as an HTML class. */
	$new_meta_value = (isset($_POST['house-city']) ? sanitize_html_class($_POST['house-city']) : '');

	/* Get the meta key. */
	$meta_key = 'house_city';

	/* Get the meta value of the custom field key. */
	$meta_value = get_post_meta($post_id, $meta_key, true);

	/* If a new meta value was added and there was no previous value, add it. */
	if ($new_meta_value && '' == $meta_value) {
		add_post_meta($post_id, $meta_key, $new_meta_value, true);
	}

	/* If the new meta value does not match the old value, update it. */
	elseif ($new_meta_value && $new_meta_value != $meta_value) {
		update_post_meta($post_id, $meta_key, $new_meta_value);
	}

	/* If there is no new meta value but an old value exists, delete it. */
	elseif ('' == $new_meta_value && $meta_value) {
		delete_post_meta($post_id, $meta_key, $meta_value);
	}

}

// Create house by user
add_action('wpcf7_before_send_mail', 'create_house_post');

function create_house_post() {
	$submission = WPCF7_Submission::get_instance();
	$posted_data = $submission->get_posted_data();

	if (isset($_POST['create-house'])) {
		$title = sanitize_text_field($_POST['text-title']);
		$type = sanitize_text_field($_POST['menu-type']);
		$ploshad = intval(sanitize_text_field($_POST['text-ploshad']));
		$stoimost = sanitize_file_name($_POST['text-stoimost']);
		$adres = sanitize_text_field($_POST['text-adres']);
		$zhilaya_ploshhad = sanitize_text_field($_POST['text-zhilaya_ploshhad']);
		$etazh = sanitize_text_field($_POST['etazh']);
		$opisanie = sanitize_text_field($_POST['opisanie']);
		$type = sanitize_text_field($_POST['menu-type']);

		$my_post = array(
			'post_title' => $title,
			//'post_status' => 'pending',
			'post_status' => 'publish',
			'post_type' => 'houses',
			'post_content' => $opisanie,
			'post_author' => 1,
		);

		$post_id = wp_insert_post($my_post);

		wp_set_object_terms($post_id, $type, 'house_type');

		update_field('adres', $adres, $post_id);
		update_field('ploshad', $ploshad, $post_id);
		update_field('stoimost', $stoimost, $post_id);
		update_field('zhilaya_ploshhad', $zhilaya_ploshhad, $post_id);
		if (intval($etazh) > 0) {
			update_field('etazh', $etazh, $post_id);
		}

		$uploadedFiles = $submission->uploaded_files();

		if (isset($posted_data['file-photo'])) {
			$featuredUpload = wp_upload_bits($_FILES["file-photo"]["name"], null, file_get_contents($uploadedFiles['file-photo'][0]));
			require_once ABSPATH . 'wp-admin/includes/admin.php';
			$filename = $featuredUpload['file'];
			$attachment = array(
				'post_mime_type' => $featuredUpload['type'],
				'post_parent' => $post_id,
				'post_title' => sanitize_file_name($filename),
				'post_content' => '',
				'post_status' => 'inherit',
			);

			$attachment_id = wp_insert_attachment($attachment, $filename, $post_id);

			if (!is_wp_error($attachment_id)) {
				require_once ABSPATH . 'wp-admin/includes/image.php';
				$attachment_data = wp_generate_attachment_metadata($attachment_id, $filename);
				wp_update_attachment_metadata($attachment_id, $attachment_data);
				set_post_thumbnail($post_id, $attachment_id);
			}

		}

	}

}
// aaaa