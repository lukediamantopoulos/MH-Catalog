<?php

// --------------------------------------------------------------------------------
// Widgets -- Profile
// --------------------------------------------------------------------------------

class mh_profile_widget extends WP_Widget {

	// Setup the widget name, etc...
	public function __construct() {

		$widget_ops = array(
			'classname' => 'mh-profile-widget',
			'description' => ' Custom Sunset Profile Widget',
		);
		parent::__construct( 'mh_profile', 'MH Profile', $widget_ops);
	}

	// Back-end of widget
	public function form( $instance ) {
		echo '<p><strong>Options for this widget are located <a href="./admin.php?page=MH_catalog">here</a></strong></p>';
	} 

	// Front-end of widget
	public function widget( $args , $instance ) {

		$profilePicture = esc_attr( get_option( 'profile_picture') );
		$firstName = esc_attr( get_option( 'first_name') );
		$lastName = esc_attr( get_option( 'last_name') );
		$fullName = $firstName . ' ' . $lastName;
		$description = esc_attr( get_option( 'description') );


		echo $args['before_widget'];
		?>
		<!-- HTML Output -->
		<h2 class="mh-profile-name"><?php echo $fullName; ?></h2>
		<p class="mh-profile-description"><?php echo $description; ?></p>
		<!-- HTML Output -->
		<?php 
		echo $args['after_widget'];
	}
}

add_action('widgets_init', function() {
	register_widget('mh_profile_widget');
});

// --------------------------------------------------------------------------------
// Save post views 
// --------------------------------------------------------------------------------

function mh_save_post_views( $postID ) {

	$metaKey = 'mh_post_views';
	$views = get_post_meta( $postID, $metaKey, true );

	$count = (empty( $views ) ? 0 : $views);
	$count++;

	update_post_meta( $postID, $metaKey, $count);

	echo '<h1>' . $views . '</h1>';
}

remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10 , 0 );

// --------------------------------------------------------------------------------
// Widgets -- Popular Posts
// --------------------------------------------------------------------------------

class mh_popular_posts_widget extends WP_Widget {
	// Setup the widget name, etc...
	public function __construct() {

		$widget_ops = array(
			'classname' => 'mh-popular-posts-widget',
			'description' => ' Custom MH Popular Posts Widget',
		);
		parent::__construct( 'mh_popular-posts', 'MH Popular Posts', $widget_ops);
	}

	// Backend display of widget
	public function form( $instance ) {

		$title = ( !empty( $instance['title']) ? $instance['title'] : 'Popular Posts');
		$tot = ( !empty( $instance['tot']) ? absint( $instance['tot'] ) : 3);

		$output = '<p>';
		$output .= '<label for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">Title:</label>';
		$output .= '<input type="text" class="widefat" id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" name="'  . esc_attr( $this->get_field_name( 'title' ) ) . '" value="' . esc_attr( $title ) . '">';
		$output .= '</p>';

		$output .= '<p>';
		$output .= '<label for="' .esc_attr( $this->get_field_id( 'tot' ) ) . '">Number of Posts:</label>';
		$output .= '<input type="number" class="widefat" id="' . esc_attr( $this->get_field_id( 'tot' ) ) . '" name="'  . esc_attr( $this->get_field_name( 'tot' ) ) . '" value="' . esc_attr( $tot ) . '">';
		$output .= '</p>';
		echo $output;
	}

	// Update widget
	public function update( $new_instance, $old_instance) {
		$instance = array();
		$instance[ 'title' ] = ( !empty( $new_instance[ 'title' ] ) ? strip_tags( $new_instance[ 'title' ] ) : '' );
		$instance[ 'tot' ] = ( !empty( $new_instance[ 'tot' ] ) ? absint( strip_tags( $new_instance[ 'tot' ] ) ) : 0 );

		return $instance;
	}

	// Front-end of Widget
	public function widget( $args, $instance) {

		$tot = absint( $instance[ 'tot' ]);

		$posts_args = array(
			'post_type' => 'library', 
			'posts_per_page' => $tot,
			'meta_key' => 'mh_post_views',
			'orderBy' => 'meta_val_num',
			'order' => 'DESC'
		);

		$posts_query = new WP_Query( $posts_args );

		echo $args['before_widget'];

		if( !empty( $instance[ 'title' ])) :

			echo $args[ 'before_title' ] . apply_filters( 'widget_title', $instance[ 'title' ]) . $args[ 'after_title' ];
			// echo $posts_query->found_posts; // Gets the length of query
		endif;

		if( $posts_query->have_posts() ) :

			echo '<ul>';

				while( $posts_query->have_posts() ) : $posts_query->the_post();

					$output =  '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';

					echo $output;

				endwhile;

			echo '</ul>';

		endif;

		echo $args['after_widget'];
	}
}
add_action('widgets_init', function() {
	register_widget('mh_popular_posts_widget');
});



?>
