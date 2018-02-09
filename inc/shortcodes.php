<?php 

// --------------------------------------------------------------------------------
// Contact form Shortcode 
// --------------------------------------------------------------------------------

function mh_contact_form( $atts, $content = null) {

	// [contact_form]

	// Gets the attributes
	$atts = shortcode_atts(
		array(),
		$atts,
		'contact_form'
	);

	// HTML
	ob_start(); // Delays the print of the content below
	include 'templates/mh-contact-form-template.php';
	return ob_get_clean(); // Returns the output buffer
}
add_shortcode('contact_form', 'mh_contact_form');

// --------------------------------------------------------------------------------
// Popover
// --------------------------------------------------------------------------------

function mh_popover( $atts, $content = null) {

	// [popover title="Popover title" color="color" content="popover content"]This is the clickable content[/popover]

	// Gets the attributes
	$atts = shortcode_atts(
		array(
			'title' => '',
			'content' => '',
			'color' => ''
		),
		$atts,
		'popover'
	);

	//  HTML
	return '<span class="mh-popover" data-color="' . $atts[ 'color' ] . '" title="' . $atts[ 'title' ] . '" data-content="' . $atts[ 'content' ] . '">' . $content . '</span> ';

}
add_shortcode('popover', 'mh_popover');
?>