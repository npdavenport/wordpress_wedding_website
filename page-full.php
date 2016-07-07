<?php
/*
 * Template Name: Full Width
 */
?>
<?php get_header(); ?>

    <!-- Page Content -->
    <div class="container full-page">

		<!-- Page Title -->
    	<div class="page-header"><h2><?php the_title(); ?></h2></div>

    	<!-- Breadcrumbs -->
        <?php print_breadcrumbs(); ?>

        <div class="row page-content">
            <div class="col-md-12">

		    	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		    
		    		<div class="row">

		    	    	<?php the_content(); ?>
			
		    		</div> <!-- /.row-->

		    	<?php endwhile; else: ?>
					<p><?php _e( 'No posts were found.  Sorry!' ); ?></p>
				<?php endif; ?>		
			</div> <!-- /.col-md-12 -->

<?php get_footer(); ?>