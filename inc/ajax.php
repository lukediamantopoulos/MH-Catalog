<?php 
// --------------------------------------------------------------------------------
// Ajax Calls
// --------------------------------------------------------------------------------

add_action('wp_ajax_nopriv_mh_save_user_contact_form', 'mh_save_contact');
add_action('wp_ajax_mh_save_user_contact_form', 'mh_save_contact');

function mh_save_contact() {
	$name = wp_strip_all_tags($_POST['name']);
	$email = wp_strip_all_tags($_POST['email']);
	$message = wp_strip_all_tags($_POST['message']);

	$args = array(
		'post_title' => $name,
		'post_content' => $message,
		'post_author' => 1,
		'post_type' => 'mh-contact',
		'post_status' => 'publish',
		'meta_input' => array(
			'_contact_email_value_key' => $email
		)
	);

	// Saves post
	$postID = wp_insert_post( $args );
	echo $postID;

	die();
}

?>