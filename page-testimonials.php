<?php
/*
 * Template Name: Testimonials
 */
?>
<?php get_header(); ?>

    <!-- Page Content -->
    <div class="container full-page">

		<!-- Page Title -->
    	<div class="page-header"><h2><?php the_title(); ?></h2></div>

    	<!-- Breadcrumbs -->
        <?php print_breadcrumbs(); ?>

        <?php 

        	// Counter that will be used to determine when a new row needs
        	// to be printed to the screen.
        	$counter = 1;

        	$args = array(
				'post_type'        => 'testimonials',
				'nopaging'         => true,
			);
			
			$testimonial_query = new WP_Query( $args );

			if ( $testimonial_query->have_posts()) : while ( $testimonial_query->have_posts() ) : $testimonial_query->the_post();

				// Start a new row if the counter is 1.
				if ( $counter == 1 ) {
					?>
					<div class="row testimonial-content">
            		<?php
				}?>
        		
        		<div class="col-sm-6 col-md-4">
        			<div class="thumbnail">

        		<?php
				// Display a featured image if there is one
                if ( has_post_thumbnail() ) {
                    $img_id = get_post_thumbnail_id();
                    $img_alt = get_post_meta( $img_id, '_wp_attachement_image_alt', TRUE );
                    $img = wp_get_attachment_image_src( $img_id, 'full' ); ?>
                    <img src="<?php echo $img[0]; ?>" alt="<?php echo $img_alt; ?>">
                	<?php
                }?>

						<div class="caption">
							<h2><?php echo the_title(); ?></h2>
                            <blockquote class="testimonial">
							<?php echo the_content(); ?>
                            </blockquote>

						</div>
					</div>
				</div>
		    	
		    	<?php

		    		$counter++;

		    		// If counter = 4 we want to close the row and reset.
		    		if ( $counter == 4 ) {
		    			echo '</div><!-- /.row -->';
		    			$counter = 1;
		    		}
		    	?>

		    	<?php endwhile; else: ?>
					<p><?php _e( 'No posts were found.  Sorry!' ); ?></p>
				<?php endif; ?>		
			</div> <!-- /.col-md-12 -->

<?php get_footer(); ?>