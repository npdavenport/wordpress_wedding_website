<?php
/*
Template Name: Home Page
*/
?>

<?php get_header(); ?>

    <!-- Page Content -->
    <div class="container-fluid">

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    
    <div class="row">

        <?php the_content(); ?>

    </div> <!-- /.row-->

    <?php endwhile; else: ?>
			<p><?php _e( 'No posts were found.  Sorry!' ); ?></p>
		<?php endif; ?>		

<?php get_footer(); ?>