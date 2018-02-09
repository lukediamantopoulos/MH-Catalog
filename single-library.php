<?php get_header(); ?>

<div class="row">
  
  <?php 

  if ( have_posts() ):

    while( have_posts() ): the_post(); ?>

      <article id="post-<?php the_ID();?>" class="mh-post">
        
        <?php mh_save_post_views( get_the_ID() );  ?>

        <?php the_title('<h1 class="content-title">','</h1>');?>
        
        <small><?php echo mh_get_terms( $post->ID, 'genre' );?> // <?php echo mh_get_terms( $post->ID, 'publisher' );?></small>

        <?php 
          if( current_user_can('manage_options') ) {
            edit_post_link();
          };
        ?>

        <?php the_content(); ?>
        
        <!-- Custom post type -->
        <?php $meta_value = get_post_meta( $post->ID, 'release_date', true);
        if(!empty( $meta_value )) {
          echo '<p>' . $meta_value . '</p>';
        }
        ?>

        <?php echo mh_post_navigation(); ?>
        
      </article>

    <?php endwhile;
    endif; ?>

</div>

<?php get_footer(); ?>