<?php get_header(); ?>

        <!-- Page Content -->
        <div class="container single-blog">

            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

            <h1 class="post-title"><?php the_title(); ?></h1>
            
            <!-- Breadcrumbs -->
            <?php print_breadcrumbs(); ?>

            <div class="row post-content">
                <div class="col-md-8 col-sm-7">

                    <?php
                        // Display a featured image if there is one
                        if ( has_post_thumbnail() ) {
                            $img_id = get_post_thumbnail_id();
                            $img_alt = get_post_meta( $img_id, '_wp_attachement_image_alt', TRUE );
                            $img = wp_get_attachment_image_src( $img_id, 'full' ); ?>
                            <img src="<?php echo $img[0]; ?>" alt="<?php echo $img_alt; ?>" class="img-responsive blog-feat-img">
                            <?php
                        }
                    ?>

                    <div class="the-content">
                        <?php
                            // First print out the text without images
                            echo the_content();                            
                         ?>
                    </div>
                    <?php endwhile; else: ?>
                    <p><?php _e( 'No posts were found.  Sorry!'); ?></p>
                    <?php endif; ?>
                    
                </div> <!-- /.col-md-8 -->

                <?php get_sidebar(); ?>

        

<?php get_footer(); ?>