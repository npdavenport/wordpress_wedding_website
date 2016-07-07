<?php
/**
 * Class used for extending the default WP_Widget plass.
 * Any class specific widgets will be included here.
 */
add_action( 'widgets_init', function() {
	register_widget( 'OE_Testimonial_Widget');
});


class OE_Testimonial_Widget extends WP_Widget {

	function __construct() {

		$params = array(
			'description'		=> 'Widget that displays testimonials added to the theme.',
			'name'				=> 'OE Testimonials'
		);

		// invoke parent constructor
		parent::__construct( 'OE_Testimonial_Widget', '', $params );
	}

	/**
	 * Override super method.
	 * Prints form to admin panel.
	 */
	public function form($instance) {

		// Extract array in order to reference fields by name.
		extract( $instance );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' );?>">Title;</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' );?>" name="<?php echo $this->get_field_name( 'title' );?>" value="<?php if( isset( $title ) ) echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'num_testimonials' );?>">Number of Testimonials;</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'num_testimonials' );?>" name="<?php echo $this->get_field_name( 'num_testimonials' );?>" value="<?php if( isset( $num_testimonials ) ) echo esc_attr( $num_testimonials ); ?>" />
		</p>
		<?php

	}

	/**
	 * Override super method.
	 * Prints form to website page in sidebar.
	 */
	public function widget( $args, $instance ) {
		//print_r($args);
		// Extract array in order to reference fields by name.
		extract( $args );
		extract( $instance );

		// Apply filters
		$title = apply_filters( 'widget_title', $title );
		$num_testimonials = apply_filters( 'widget_text', $num_testimonials );

		// Provide widget defaults;
		if ( empty( $title ) ) $title = 'Testimonials';
		if ( empty( $title ) ) $num_testimonials = '2';

		// Convert string to positive integer
		$num = (int)preg_replace('/[^\-\d]*(\-?\d*).*/','$1',$num_testimonials);

		// Retrieve testimonials.
		$testimonials = $this->get_testimonials( $num );

		// Print to sidebar
		echo $before_widget;
			echo $before_title . $title . $after_title;
			echo $testimonials;
		echo $after_widget;

	}

	private function get_testimonials( $num ) {

		// Create the query to retreive testimonials
		$args = array(
			'post_type'     	=> 'testimonials',
			'posts_per_page'	=> $num,
		);

		// Query the database
		$testimonial_query = new WP_Query( $args );
		$html = '';

		// Loop through the testimonials and build the HTMl return object
		if ( $testimonial_query->have_posts()) : while ( $testimonial_query->have_posts() ) : $testimonial_query->the_post();

			// Retrieve values needed from the post.
			$excerpt = get_the_excerpt();
			$title = get_the_title();

			$html .= '<blockquote class="testimonial-quote">' . $excerpt . '<small>' . $title . '</small>' . '</blockquote>'; ?>
		
		<?php endwhile; else: ?>
			<p><?php _e( 'No testimonials were found.  Sorry!' ); return; ?></p>
		<?php endif;

		return $html;

	}
}

?>