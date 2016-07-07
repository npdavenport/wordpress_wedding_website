<?php get_header(); ?>

        <!-- Page Content -->
        <div class="container default-page">
            
            <!-- Breadcrumbs -->
            <?php print_breadcrumbs(); ?>

            <div class="row">
                <div class="col-md-8 col-sm-7 index-content">

                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                    <!-- Panels for blog entries -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="archive-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        </div>
                        <div class="panel-body">
                            <?php
                                // Display a featured image if there is one
                                if ( has_post_thumbnail() ) {
                                    $img_id = get_post_thumbnail_id();
                                    $img_alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
                                    $img = wp_get_attachment_image_src( $img_id, 'full' ); ?>
                                    <img src="<?php echo $img[0]; ?>" alt="<?php echo $img_alt; ?>" class="img-responsive blog-feat-img">
                                    <?php
                                }
                                ?>
                                <p><?php echo the_excerpt(); ?></p>
                            <a href="<?php the_permalink(); ?>"><button type="button" class="btn btn-default">More Images</button></a>
                        </div>
                    </div>

                    <?php endwhile; else: ?>
                    <p><?php _e( 'No posts were found.  Sorry!'); ?></p>
                    <?php endif; ?>
                    
                    <!-- Pagination -->
                    <?php oewpt_pagination(); ?>
                    
                </div> <!-- /.col-md-8 -->

                <?php get_sidebar(); ?>

        

<?php get_footer(); ?>
