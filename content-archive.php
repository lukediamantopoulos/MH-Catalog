<?php 
/* 
	-- Page Template
	Spits out generic page
*/
?>

<article class="mh-post align-center" id="post-<?php the_ID(); ?>">
	<div class="container">
		<header class="post-header">
			<a class="post-title-link" href="<?php the_permalink(); ?>">
				<?php the_title('<h1 class="post-title">', '</h1>'); ?>
			</a>
		</header>

		<div class="post-content">
			<?php the_excerpt(); ?>
		</div>
	</div>
</article>