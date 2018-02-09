<?php 
/* 
	-- Page Template
	Spits out generic page
*/
?>

<article class="container-page align-center" id="post-<?php the_ID(); ?>">
	<header class="post-header">
		<?php the_title('<h1 class="post-title">', '</h1>'); ?>
	</header>

	<div class="post-content">
		<?php the_content(); ?>
	</div>
	
</article>