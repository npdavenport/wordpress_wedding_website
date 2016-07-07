<?php
/*
 * Template Name: Archives
 */
?>
<?php get_header(); ?>

    <!-- Page Content -->
    <div class="container default-page">

		<!-- Page Title -->
    	<div class="page-header"><h2><?php the_title(); ?></h2></div>

    	<!-- Breadcrumbs -->
        <?php print_breadcrumbs(); ?>

        <div class="row post-content">
            <div class="col-md-8">

		    	<h4>Archives by Month:</h4>
		    	<ul class="archives">
		    		<?php wp_get_archives( 'type=monthly' ); ?>
		    	</ul>

		    	<h4>Acrhives by Subject:</h4>
		  		<ul class="archives">
		  			<?php wp_list_categories( 'hierarchical=0&title_li=' ); ?>
		  		</ul>

			</div> <!-- /.col-md-8 -->

		<?php get_sidebar(); ?>

<?php get_footer(); ?>