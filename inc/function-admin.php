<?php 

// --------------------------------------------------------------------------------
// Admin Page
// --------------------------------------------------------------------------------

function mh_add_admin_page() {

	// Add MH Catalog Admin Page
	add_menu_page('MH Catalog Theme Options', 'MH Catalog', 'manage_options', 'MH_catalog', 'mh_catalog_create_page', 'dashicons-dashboard', 110);

	// Add MH Catalog Sub-pages
	add_submenu_page('MH_catalog', 'MH Sidebar Options', 'Sidebar', 'manage_options', 'MH_catalog', 'mh_catalog_create_page');
	add_submenu_page('MH_catalog', 'MH Theme Options', 'Theme options', 'manage_options', 'MH_theme_options', 'mh_catalog_theme_support_page');
	add_submenu_page('MH_catalog', 'MH Contact Options', 'Contact Form', 'manage_options', 'MH_contact_form', 'mh_catalog_contact_page');
	add_submenu_page('MH_catalog', 'MH CSS Options', 'Custom CSS', 'manage_options', 'MH_catalog_css', 'mh_catalog_settings_page');

	// Activate Custom settings
	add_action('admin_init', 'mh_custom_settings');
}
add_action('admin_menu', 'mh_add_admin_page');

function mh_custom_settings() {

	// Sidebar Options
	// ---------------------------------------------------------------------------------------
	// Register Each Setting
	register_setting('mh-settings-group', 'profile_picture');
	register_setting('mh-settings-group', 'first_name');
	register_setting('mh-settings-group', 'last_name');
	register_setting('mh-settings-group', 'description');
	register_setting('mh-settings-group', 'twitter_handle');
	register_setting('mh-settings-group', 'facebook_handle');

	// Sidebar section settings
	add_settings_section('mh-sidebar-options', 'Sidebar Options', 'mh_sidebar_options', 'MH_catalog');

	// Sidebar section Fields
	add_settings_field('sidebar-profile-picture', 'Profile Picture', 'mh_sidebar_profile_picture', 'MH_catalog', 'mh-sidebar-options');
	add_settings_field('sidebar-name', 'Name', 'mh_sidebar_name', 'MH_catalog', 'mh-sidebar-options');
	add_settings_field('sidebar-description', 'Description', 'mh_sidebar_description', 'MH_catalog', 'mh-sidebar-options');
	add_settings_field('sidebar-twitter', 'Twitter Handle', 'mh_sidebar_twitter', 'MH_catalog', 'mh-sidebar-options');
	add_settings_field('sidebar-facebook', 'Facebook Handle', 'mh_sidebar_facebook', 'MH_catalog', 'mh-sidebar-options');

	// Theme Support Options
	// --------------------------------------------------------------------------------------- 
	// Register Each Setting
	register_setting('mh-theme-support', 'post_formats');
	register_setting('mh-theme-support', 'custom_header');
	register_setting('mh-theme-support', 'custom_background');

	// Theme Support section settings
	add_settings_section('mh-theme-options', 'Theme Options', 'mh_theme_options', 'MH_theme_options');

	// Theme Support section Fields
	add_settings_field('post_formats', 'Post Formats', 'mh_post_formats', 'MH_theme_options', 'mh-theme-options');
	add_settings_field('custom_header', 'Custom Header', 'mh_custom_header', 'MH_theme_options', 'mh-theme-options');
	add_settings_field('custom_background', 'Custom Background', 'mh_custom_background', 'MH_theme_options', 'mh-theme-options');

	// Contact Form Options
	// --------------------------------------------------------------------------------------- 
	// Register Each Setting
	register_setting('mh-contact-form', 'activate_contact_form');

	// Contact form section settings
	add_settings_section('mh-contact-form-options', 'Contact Form', 'mh_contact_form_options ', 'MH_contact_form_options');

	add_settings_field('activate-form', 'Activate Contact Form', 'mh_activate_contact', 'MH_contact_form_options', 'mh-contact-form-options');
}

function mh_theme_options() {
	echo 'Activate and deactivate theme settings';
}

function mh_contact_form_options() {
	echo 'Activate and deactivate contact form';
}

function mh_sidebar_options() {
	echo '<p>Custom sidebar settings</p>';
}

// --------------------------------------------------------------------------------------- 
// Contact form Settings Fields
// --------------------------------------------------------------------------------------- 
// Contact form field -- Activate
function mh_activate_contact() {
	$options = get_option('activate_contact_form');	
	$checked = ( @$options == 1 ? 'checked' : '');
	echo '<label><input type="checkbox" id="activate_contact_form" name="activate_contact_form" value="1"' . $checked . '></label>'; 
	echo $output;
}

// --------------------------------------------------------------------------------------- 
// Theme Support Settings Fields
// --------------------------------------------------------------------------------------- 
// Theme Support field -- Post Format
function mh_post_formats() {
	$options = get_option('post_formats');
	$formats = array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat');
	$output = '';
	foreach ($formats as $format) {
		$checked = ( @$options[$format] == 1 ? 'checked' : '');
		$output .= '<label><input type="checkbox" id="'. $format . '" name="post_formats[' . $format . ']" value="1"' . $checked . '>' .$format . '</label></br>';  
	}
	echo $output;
}

// Theme Support field -- Custom Header
function mh_custom_header() {
	$options = get_option('custom_header');	
	$checked = ( @$options[$format] == 1 ? 'checked' : '');
	echo '<label><input type="checkbox" id="custom_header" name="custom_header" value="1"' . $checked . '>Activate Custom Header</label>'; 
	echo $output;
}

// Theme Support field -- Custom Background
function mh_custom_background() {
	$options = get_option('custom_background');	
	$checked = ( @$options[$format] == 1 ? 'checked' : '');
	echo '<label><input type="checkbox" id="custom_background" name="custom_background" value="1"' . $checked . '>Activate Custom Background</label>'; 
	echo $output;
}

// --------------------------------------------------------------------------------------- 
// Sidebar Settings Fields
// --------------------------------------------------------------------------------------- 

// Sidebar field -- Profile Picture
function mh_sidebar_profile_picture() {
	$picture = esc_attr(get_option( 'profile_picture' ));
	if( empty($picture) ) {
		echo '<input type="button" class="button button-secondary" value="Upload Profile Picture" id="upload-button"> <input type="hidden" name="profile_picture" id="profile-picture" value="">';
	} else {
		echo '<input type="button" class="button button-primary" value="Replace Profile Picture" id="upload-button"> <input type="hidden" name="profile_picture" id="profile-picture" value="' . $picture . '"> <input type="button" class="button button-secondary" value="Remove" id="remove-picture">';
	}
}

// Sidebar field -- Name
function mh_sidebar_name() {
	$firstName = esc_attr(get_option( 'first_name' ));
	$lastName = esc_attr(get_option( 'last_name' ));
	echo '<input type="text" name="first_name" value="' . $firstName . '" placeholder="First Name">';
	echo '<input type="text" name="last_name" value="' . $lastName . '" placeholder="Last Name">';
}

// Sidebar field -- description
function mh_sidebar_description() {
	$description = esc_attr(get_option( 'description' ));
	echo '<input type="text" name="description" value="' . $description . '" placeholder="A little about you"> <p class="description">Input a personal description</p>';
}

// Sidebar field -- Twitter Handle
function mh_sidebar_twitter() {
	$twitter = esc_attr(get_option( 'twitter_handle' ));
	echo '<input type="text" name="twitter_handle" value="' . $twitter . '" placeholder="Twitter Handle"> <p class="description">Input your Twitter handle</p>';
}

// Sidebar field -- Facebook handle
function mh_sidebar_facebook() {
	$facebook = esc_attr(get_option( 'facebook_handle' ));
	echo '<input type="text" name="facebook_handle" value="' . $facebook . '" placeholder="Facebook Handle"> <p class="description">Input your Facebook handle</p>';
}

// Generation of our admin page
function mh_catalog_create_page() {
	require_once( get_template_directory() . '/inc/templates/mh-admin.php');
}

// Generation of our settings subpage
function mh_catalog_settings_page() {
	
}

// Generation of our contact subpage
function mh_catalog_contact_page() {
	require_once( get_template_directory() . '/inc/templates/mh-contact-form.php');
}

// Generation of our theme support subpage
function mh_catalog_theme_support_page() {
	require_once( get_template_directory() . '/inc/templates/mh-theme-support.php');
}

// --------------------------------------------------------------------------------------- 
// Remove Menu Items
// --------------------------------------------------------------------------------------- 

function mh_remove_menu_items() {
	remove_menu_page( 'edit-comments.php' ); // Comments
}
add_action('admin_menu', 'mh_remove_menu_items');
?>