<?php get_header(); ?>

<div class="main">
  <div class="container">
    <div class="content">
      <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

        <?php mh_save_post_views( get_the_ID() );  ?> <!-- Displays amount of views -->

        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <h1 class="entry-title"><?php the_title(); ?></h1>

          <div class="entry-content">
            <?php the_content(); ?>

            <?php echo mh_post_navigation();  ?>

      <?php endwhile; // end of the loop. ?>

    </div> <!-- /.content -->


  </div> <!-- /.container -->
</div> <!-- /.main -->

<?php get_footer(); ?>