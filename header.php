<!DOCTYPE html>
<html lang="en" style="margin-top: 0px !important">
<head>
	<meta charset="UTF-8">
	<title><?php wp_title(); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

	<div id="site">

		<!-- ------------------------------------------------------------------------------------ -->
		<!-- Border -->
		<!-- ------------------------------------------------------------------------------------ -->
		
		<div class="border border-top"></div>
		<div class="border border-left"></div>
		<div class="border border-bottom"></div>
	
		<!-- ------------------------------------------------------------------------------------ -->
		<!-- Header -->
		<!-- ------------------------------------------------------------------------------------ -->
		<header class="mh-header">

			<?php 
				$custom_logo_id = get_theme_mod( 'custom_logo' );
				$logoURL = wp_get_attachment_image_src( $custom_logo_id , 'full' );
			?>
			
			<!-- ------------------------------------------------------------------------------------ -->
			<!-- Logo -->
			<!-- ------------------------------------------------------------------------------------ -->
			<div class="logo">
				<a href="<?php echo get_option("siteurl"); ?>">
					<img src="<?php print $logoURL[0]; ?>" alt="">
				</a>
			</div>
			
			<!-- ------------------------------------------------------------------------------------ -->
			<!-- Navigation in header -->
			<!-- ------------------------------------------------------------------------------------ -->
			<div class="mh-header-menus">
				<?php if ( has_nav_menu( 'primary-menu' ) ) { ?>
					<div class="menu-location">
						<?php 
							$defaults = array(
								'container' => false,
								'theme_location' => 'primary-menu',
								'menu_class' => 'mh-header-menu'
							);

							wp_nav_menu( $defaults );
						?>
					</div>
				<?php } ?> 
			
			<!-- ------------------------------------------------------------------------------------ -->
			<!-- Sub pages menu -->
			<!-- ------------------------------------------------------------------------------------ -->

				<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php
							$children = wp_list_pages( 'title_li=&child_of='. get_top_ancestor_ID() .'&echo=0');
						?>

						<?php if ( $children) : ?>
						    <ul class="mh-header-menu-sub">
						        <?php  echo $children; ?>
						    </ul>
						<?php endif; ?>

					<?php endwhile; ?>
				<?php endif; ?>
			</div>
			
			<!-- ------------------------------------------------------------------------------------ -->
			<!-- Widget Location header -->
			<!-- ------------------------------------------------------------------------------------ -->
			<?php if (is_active_sidebar('header1')) : ?>
				<div class="widget-location">
					<?php dynamic_sidebar('header1'); ?>
				</div>
			<?php endif; ?>
		</header>
		
		<!-- ------------------------------------------------------------------------------------ -->
		<!-- Sidebar -->
		<!-- ------------------------------------------------------------------------------------ -->
		<aside class="mh-sidebar">
			
			<!-- Hamburger Menu -->
			<div id="mh-sidebar-toggle">
				<div class="mh-sidebar-toggle-container">
					<div class="sidebar-toggle-bar"></div>
					<div class="sidebar-toggle-bar"></div>
					<div class="sidebar-toggle-bar"></div>
				</div>
			</div>
				
			<!-- If nav if set, display nav -->
			<div class="mh-sidebar-inner clearfix">

				<?php if ( has_nav_menu( 'sidebar-menu' ) ) { ?>
					<div class="menu-location">
						<?php 
							$defaults = array(
								'container' => false,
								'theme_location' => 'sidebar-menu',
								'menu_class' => 'mh-sidebar-menu'
							);
							wp_nav_menu( $defaults );
						?>
					</div>
				<?php } ?> 
				

				<?php if (is_active_sidebar('sidebar1')) : ?>
					<div class="widget-location">
						<?php dynamic_sidebar('sidebar1'); ?>
					</div>
				<?php endif; ?>
			</div>
		</aside>

		<!-- ------------------------------------------------------------------------------------ -->
		<!-- Start of Page -->
		<!-- ------------------------------------------------------------------------------------ -->

		<div class="header-space"></div>

