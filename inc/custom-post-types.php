<?php 
// --------------------------------------------------------------------------------
// Custom Post type -- Contact Form Page
// --------------------------------------------------------------------------------

$contact = get_option( 'activate_contact_form');
if( @$contact == 1 ) {
	add_action('init', 'mh_custom_post_type_contact');

	// Set Columns
	add_filter('manage_mh-contact_posts_columns', 'mh_set_mh_contact_columns');

	//Add content inside columns
	add_action('manage_mh-contact_posts_custom_column', 'mh_contact_custom_contact', 10, 2);

	// Hook Email Meta Box 
	add_action('add_meta_boxes', 'mh_contact_email_meta_box');

	// Saving the value in the meta box 'email'
	add_action('save_post', 'mh_save_contact_email_data');
}

function mh_custom_post_type_contact() {
	$labels = array(
		'name'				 	=> 'Messages',
	    'singular_name' 	 	=> 'Message',
	    'menu_name'				=> 'Messages',
	    'name_admin_bar'		=> 'Message'
	);

	$args = array(
		'labels' => $labels,
		'show_ui' => true,
		'show_in_menu' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 26,
		'menu_icon' => 'dashicons-email-alt',
		'supports' => array( 
			'title', 
			'editor',  
			'author')
	);
	register_post_type('mh-contact', $args);
}

// --------------------------------------------------------------------------------
// Custom Columns -- Contact Form Page
// --------------------------------------------------------------------------------

// Sets the column on the Custom Post Type
function mh_set_mh_contact_columns( $columns ) {
	$newColumns = array();
	$newColumns['title'] = 'Full Name';
	$newColumns['message'] = 'Message';
	$newColumns['email'] = 'Email';
	$newColumns['date'] = 'Date';
	return $newColumns;
}

// Dictates what goes into each column
function mh_contact_custom_contact( $column, $post_id) {
	switch( $column ) {
		case 'message' :
		echo 'hello';
		echo get_the_excerpt();
		break;

		case 'email' :
		$email = get_post_meta($post_id, '_contact_email_value_key', true);
		echo $email;
		break;
	}
}

// --------------------------------------------------------------------------------
// Meta Boxes -- Contact Form Page
// --------------------------------------------------------------------------------

// Creating metabox for contact form
function mh_contact_email_meta_box() {
	add_meta_box( 'contact_email', 'User Email', 'mh_contact_email_callback', 'mh-contact', 'side' );
}

// Callback for email meta box
function mh_contact_email_callback( $post) {
	wp_nonce_field('mh_save_contact_email_data', 'mh_contact_email_meta_box_nonce');

	$value = get_post_meta($post->ID, '_contact_email_value_key', true);

	echo '<label for="mh_contact_email_field"> User Email Address</label>';
	echo '<input type="email" id="mh_contact_email_field" name="mh_contact_email_field" value="' . esc_attr( $value ) . '" size=""25 />';
}

// Save data in email Meta box
function mh_save_contact_email_data( $post_id) {
	// Check if nonce is actually set
	if ( ! isset( $_POST['mh_contact_email_meta_box_nonce'] ) ) {
		return;
	}

	// Check if its a legit Nonce create in WP
	if ( ! wp_verify_nonce( $_POST['mh_contact_email_meta_box_nonce'], 'mh_save_contact_email_data') ){
		return;
	}

	// Check if WP is autosaving
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
		return;
	}

	// Check if user has permission
	if( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// If no value is in the field
	if ( ! isset( $_POST['mh_contact_email_field'] ) ) {
		return;
	}

	$email_data = sanitize_text_field( $_POST['mh_contact_email_field'] );

	update_post_meta( $post_id, '_contact_email_value_key', $email_data );
}

// --------------------------------------------------------------------------------
// Custom Post type -- Library Item
// --------------------------------------------------------------------------------
function mh_custom_post_type_library() {
	$labels = array(
		'name' => 'Library',
	    'singular_name' => 'Library',
	    'add_new' => 'Add Item',
	    'all_items' => 'All Items',
	    'add_new_item' => 'Add New Library Item',
	    'edit' => 'Edit Item',
	    'edit_item' => 'Edit Library Item',
	    'new_item' => 'New Library Item',
	    'view_item' => 'View Item',
	    'view_item' => 'View Library Item',
	    'search_items' => 'Search Library Items',
	    'not_found' => 'No Library Items found',
	    'not_found_in_trash' => 'No Library Items found in Trash',
	    'parent' => 'Parent Library Item'
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'publicly_queryable' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'supports' => array( 
			'title', 
			'editor', 
			'excerpt', 
			'comments',
			'revisions',  
			'thumbnail', 
			'custom-fields' ),
		// 'taxonomies' => array( 'category', 'post_tag' ),
		'menu_position' => 5,
		'menu_icon' => get_template_directory_uri() . '/images/cpt-library-image.svg'
	);
	register_post_type('library', $args);
}
add_action('init', 'mh_custom_post_type_library');
 ?>