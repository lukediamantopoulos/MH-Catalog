<?php 
// --------------------------------------------------------------------------------
// Includes
// --------------------------------------------------------------------------------

require get_template_directory() .'/inc/function-admin.php';
require get_template_directory() .'/inc/custom-post-types.php';
require get_template_directory() .'/inc/shortcodes.php';
require get_template_directory() .'/inc/ajax.php';
require get_template_directory() .'/inc/widgets.php';

// --------------------------------------------------------------------------------
// Theme Support
// --------------------------------------------------------------------------------

function mh_theme_setup() {
	add_theme_support('menus');
	add_theme_support( 'post-thumbnails' ); 
    add_theme_support('custom-logo');
}
add_action('after_setup_theme', 'mh_theme_setup');

// Add Post formats -- function-admin.php
$options = get_option('post_formats');
$formats = array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat');
$output = array();
foreach ($formats as $format) {
	$output[] = ( @$options[$format] == 1 ? $format : '');
}
if ( !empty($options)) {
	add_theme_support('post-formats', $output);
}

// Add Custom headers -- function-admin.php
$customHeader = get_option('custom_header');
if ( @$customHeader == 1) {
	add_theme_support('custom-header');
}

// Add Custom background -- function-admin.php
$customBackground = get_option('custom_background');
if ( @$customBackground == 1) {
	add_theme_support('custom-background');
}

// --------------------------------------------------------------------------------
// Register Post Navigation
// --------------------------------------------------------------------------------

function mh_post_navigation() {
	$nav = '<div class="row post-nav">';

	$prev = get_previous_post_link( '<div class="post-link-nav">%link</div> ', '%title');
	$nav .= '<div class="col-50">' . $prev . '</div>'; 

	$next = get_next_post_link( '<div class="post-link-nav">%link</div> ', '%title');
	$nav .= '<div class="col-50">' . $next . '</div>'; 

	$nav .= '</div>'; // row

	return $nav;
}

// --------------------------------------------------------------------------------
// Register Menus
// --------------------------------------------------------------------------------

function mh_register_theme_menus() {

	register_nav_menus(
		array(
			'primary-menu' => __( 'Primary Menu' )
		)
	);

	register_nav_menus(
		array(
			'sidebar-menu' => __( 'Sidebar Menu' )
		)
	);
}
add_action( 'init', 'mh_register_theme_menus' );

// --------------------------------------------------------------------------------
// Load Styles
// --------------------------------------------------------------------------------

function mh_theme_styles() {
	wp_enqueue_style('font_montserrat', 'https://fonts.googleapis.com/css?family=Montserrat:400,700');
	wp_enqueue_style('font_playfair', 'https://fonts.googleapis.com/css?family=Playfair+Display:700,900');
	wp_enqueue_style('css_main', get_template_directory_uri() . '/style.css');	
}
add_action( 'wp_enqueue_scripts', 'mh_theme_styles');

// --------------------------------------------------------------------------------
// Load Scripts
// --------------------------------------------------------------------------------

function mh_theme_scripts() {
	wp_enqueue_script('js_jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', '', '', true);
	wp_enqueue_script('js_gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js', '', '', true);
	wp_enqueue_script('js_main', get_template_directory_uri() . '/script.js', array('js_gsap'), '', true);
}
add_action( 'wp_enqueue_scripts', 'mh_theme_scripts');

// --------------------------------------------------------------------------------
// Admin Enqueue Functions
// --------------------------------------------------------------------------------

function mh_load_admin_scripts( $hook ) {

	// Check if the page is our custom admin page
	if('toplevel_page_MH_catalog' != $hook) {
		return;
	}

	// Register and Enqueue Styles
	wp_register_style('mh_admin_css', get_template_directory_uri() . '/css/style.admin.css', array(), '1.0.0', 'all');
	wp_enqueue_style('mh_admin_css');

	// Enqueue Media Uploader
	wp_enqueue_media();

	// Register and Enqueue Scripts
	wp_register_script('mh_admin_js', get_template_directory_uri() . '/js/script.admin.js', array(), '1.0.0', true);
	wp_enqueue_script('mh_admin_js');
}
add_action('admin_enqueue_scripts', 'mh_load_admin_scripts');

// --------------------------------------------------------------------------------
// Widget locations
// --------------------------------------------------------------------------------

function mh_widget_locations() {

	// Footer Widget Location
	register_sidebar( array(
		'name' => 'Footer Widget',
		'id' => 'footer1',
		'before_widget' => '<section id="%1$s" class="widget-item %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>'
	));

	// Footer Beneath Widget Location
	register_sidebar( array(
		'name' => 'Footer Beneath Widget',
		'id' => 'footer2',
		'before_widget' => '<section id="%1$s" class="widget-item %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>'
	));

	// Sidebar Widget Location
	register_sidebar( array(
		'name' => 'Sidebar Widget',
		'id' => 'sidebar1',
		'description' => 'Dynamic Sidebar',
		'before_widget' => '<section id="%1$s" class="widget-item %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>'
	));

	// Header Widget Location
	register_sidebar( array(
		'name' => 'Header Widget',
		'id' => 'header1',
		'before_widget' => '<section id="%1$s" class="widget-item %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>'
	));
}
add_action('widgets_init', 'mh_widget_locations');

// --------------------------------------------------------------------------------
// Custom Taxonomy -- Library Item
// --------------------------------------------------------------------------------

function mh_custom_taxonomy() {

	// add new taxonomy -- hierarchical -- Category -- Genre
	$genreLabels = array(
		'name' => 'Genres',
		'singular_name' => 'Genre',
		'search_items' => 'Search Genres',
		'all_items' => 'All Genres',
		'parent_item' => 'Parent Genre',
		'parent_item_colon' => 'Parent Genre:',
		'edit_item' => 'Edit Genre',
		'update_item' => 'Update Genre',
		'add_new_item' => 'New Genre',
		'new_item_name' => 'New Genre Name',
		'menu_name' => 'Genre'
	);

	$genreArgs = array(
		'hierarchical' => true,
		'labels' => $genreLabels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'genre')
	);
	register_taxonomy( 'genre', array('library'), $genreArgs);

	// add new taxonomy -- NON hierarchical -- Tag -- Publisher
	$publisherLabels = array(
		'name' => 'Publishers',
		'singular_name' => 'Publisher',
		'search_items' => 'Search Publishers',
		'all_items' => 'All Publishers',
		'parent_item' => 'Parent Publisher',
		'parent_item_colon' => 'Parent Publisher:',
		'edit_item' => 'Edit Publisher',
		'update_item' => 'Update Publisher',
		'add_new_item' => 'New Publisher',
		'new_item_name' => 'New Publisher Name',
		'menu_name' => 'Publisher'
	);

	$publisherArgs = array(
		'hierarchical' => false,
		'labels' => $publisherLabels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'publisher')
	);
	register_taxonomy( 'publisher', array('library'), $publisherArgs);
}

add_action('init', 'mh_custom_taxonomy');

// --------------------------------------------------------------------------------
// Fetches custom Taxonomies -- Publisher & Genre
// --------------------------------------------------------------------------------

function mh_get_terms( $postID, $term ){
	$tax_list = wp_get_post_terms( $postID, $term );
	$output = '';

	$i = 0;
	foreach( $tax_list as $tax ) { $i++;
	    if ( $i > 1) { $output .= ', '; }
	    $output .= '<a href="'. get_term_link( $tax ) . '">' . $tax->name . '</a>';
	}
	return $output;
}

// --------------------------------------------------------------------------------
// Filter -- Excerpt Length
// --------------------------------------------------------------------------------

function mh_custom_excerpt_length( $length ) {
	return 10;
}
add_filter('excerpt_length', 'mh_custom_excerpt_length', 999);

// --------------------------------------------------------------------------------
// Get Top Ancestor of page - Sub Menu
// --------------------------------------------------------------------------------

function get_top_ancestor_ID() {

	global $post;

	if($post->post_parent) {
		$ancestors = array_reverse(get_post_ancestors($post->ID));
		return $ancestors[0];
	}
	return $post->ID;
}

// --------------------------------------------------------------------------------
// Add Footer Beneath Link if Widget is active
// --------------------------------------------------------------------------------

if (is_active_sidebar('footer2')) :
	function custom_menu_link ( $items, $args) {
		if ($args->theme_location == 'primary-menu') {
	    	$items .= '<li class="menu-item"><a id="btn-footer-beneath-open">Contact Now</a></li>';
	    }
	    return $items;
	}

	add_filter( 'wp_nav_menu_items', 'custom_menu_link', 10, 2 );
endif;

// --------------------------------------------------------------------------------
// Add theme CSS
// --------------------------------------------------------------------------------

function mh_admin_color_schemes() {

	$theme_dir = get_stylesheet_directory_uri();

	wp_admin_css_color(
		'material_dark', __('Material Dark'),
		$theme_dir . '/admin/material_dark/colors.css',
		array('#EBEBEB', '#FF7767',  '#333333', '#24282D',)
	);
}
add_filter( 'admin_init', 'mh_admin_color_schemes');

// --------------------------------------------------------------------------------
// Customize Register -- CSS
// --------------------------------------------------------------------------------

function mh_customize_register( $wp_customize ) {

	$wp_customize->add_setting( 'mh_link_color', array(
		'default' => '#FF7767',
		'transport' => 'refresh'
	));

	$wp_customize->add_section( 'mh_color_scheme', array(
		'title' => __('Color Scheme', "MH Catalog"),
		'priority' => 30
	));

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mh_link_color_control', array(
		'label' => __('Secondary Color', 'MH Catalog'),
		'section' => 'mh_color_scheme',
		'settings' => 'mh_link_color'
	)));
}
add_action('customize_register', 'mh_customize_register');

function mh_customize_css() { ?>
	
	<style type="text/css">
		header .mh-header-menu li.current-menu-item a,
		header .mh-header-menu li.current-page-ancestor a,
		header .mh-header-menu-sub .current_page_item a {
			color: <?php echo get_theme_mod('mh_link_color') ?>
		}
	</style>

<?php }
add_action('wp_head', 'mh_customize_css');
?>