<?php 

get_header(); ?>

	<div class="row page-search-results">
			
		<?php if ( have_posts() ) : ?>
				
			<h2 class="page-search-title">Search Results for: <em><?php the_search_query(); ?></em></h2>

			<div class="container flex">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part('content', 'search');  ?>

				<?php endwhile;  ?>

			</div>

		<?php endif;  ?>

	</div>

<?php get_footer(); ?>