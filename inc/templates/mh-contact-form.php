<h1>MH Contact Form Options</h1>
<p>Customize default options of the theme</p>
<br>

<p>Use this <strong>shortcode</strong> to display form on page: </p>
<code>[contact_form]</code>

<?php settings_errors(); ?>
<form method="post" action="options.php" class="mh-admin-form">
	<?php settings_fields('mh-contact-form');?>
	<?php do_settings_sections('MH_contact_form_options');?>
	<?php submit_button('Save Changes', 'primary', 'btn-submit'); ?>
</form>
