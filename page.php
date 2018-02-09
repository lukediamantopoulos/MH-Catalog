<?php 

get_header(); ?>

	<div class="row">
		
		<div class="container">
			<?php 

				if ( have_posts() ) : 

					while ( have_posts() ) : the_post(); ?>

						<?php get_template_part('content', 'page'); 

					endwhile;

				endif; 

			?>
		</div>
	</div>

<?php get_footer(); ?>