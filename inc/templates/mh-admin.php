<h1>MH Sidebar Options</h1>
<p>Customize default options of the theme</p>

<?php 
	$profilePicture = esc_attr( get_option( 'profile_picture') );
	$firstName = esc_attr( get_option( 'first_name') );
	$lastName = esc_attr( get_option( 'last_name') );
	$fullName = $firstName . ' ' . $lastName;
	$description = esc_attr( get_option( 'description') );
 ?>

<h2>Sidebar Preview</h2>
<div class="mh-sidebar-preview">
	<div class="mh-sidebar">
		<div class="mh-sidebar-image-container">
			<div id="profile-picture-preview" class="mh-sidebar-image" style="background-image: url(<?php print $profilePicture; ?>);"></div>
		</div>
		<h1 class="mh-sidebar-name"><?php print $fullName; ?></h1>
		<h2 class="mh-sidebar-description"><?php print $description; ?></h2>
		<ul class="mh-sidebar-social">
			<li class="mh-sidebar-social-item">
				<a href="#">
					<img src="#" alt="#" class="mh-sidebar-social-icon">
				</a>
			</li>
			<li class="mh-sidebar-social-item">
				<a href="#">
					<img src="#" alt="#" class="mh-sidebar-social-icon">
				</a>
			</li>
			<li class="mh-sidebar-social-item">
				<a href="#">
					<img src="#" alt="#" class="mh-sidebar-social-icon">
				</a>
			</li>
		</ul>
	</div>
</div>

<?php settings_errors(); ?>
<form method="post" action="options.php" class="mh-admin-form">
	<?php settings_fields('mh-settings-group');?>
	<?php do_settings_sections('MH_catalog');?>
	<?php submit_button('Save Changes', 'primary', 'btn-submit'); ?>
</form>
