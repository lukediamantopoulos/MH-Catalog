<?php 
/* 
	-- Search Template
	Spits out Search page
*/
?>

<article class="search-item align-center card" id="post-<?php the_ID(); ?>">
	<div class="img-container"><?php the_post_thumbnail();  ?> </div>
	
	<div class="search-content">
		<h3 class="search-title"><?php the_title(); ?></h3>

		<?php the_excerpt('<p class="search-excerpt">', '</p>'); ?> 
	</div>
	
</article>