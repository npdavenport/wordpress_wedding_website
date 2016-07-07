<?php get_header(); ?>

    <!-- Page Content -->
    <div class="container">

		<!-- Page Title -->
    	<div class="page-header"><h2><?php the_title(); ?></h2></div>

    	<!-- Breadcrumbs -->
        <?php print_breadcrumbs(); ?>

        <div class="row">
            <div class="col-md-8 col-sm-7 page-content">

		    	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		    
		    		<div class="row">

		    	    	<?php the_content(); ?>
			
		    		</div> <!-- /.row-->

		    	<?php endwhile; else: ?>
					<p><?php _e( 'No posts were found.  Sorry!' ); ?></p>
				<?php endif; ?>		
			</div> <!-- /.col-md-8 -->

		<?php get_sidebar(); ?>

<?php get_footer(); ?>