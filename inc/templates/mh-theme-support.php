<h1>MH Theme Options</h1>
<p>Customize default options of the theme</p>

<?php settings_errors(); ?>
<form method="post" action="options.php" class="mh-admin-form">
	<?php settings_fields('mh-theme-support');?>
	<?php do_settings_sections('MH_theme_options');?>
	<?php submit_button('Save Changes', 'primary', 'btn-submit'); ?>
</form>
