<?php get_header(); ?>

        <!-- Page Content -->
        <div class="container default-page">

            <!-- Page Title -->
            <?php
                
                // Retrieve options for blog categories.
                $options = get_option( 'oewpt_blog_options' );

                // Render the title.
                if ( is_category( 'weddings' ) ) {
                    if( isset( $options[ 'weddings_blog_title' ] ) ) {
                        ?>             
                            <div class="page-header"><h2><?php echo $options[ 'weddings_blog_title' ];?></h2></div>
                        <?php
                    } else {
                         ?>             
                            <div class="page-header"><h2>Wedding Pictures</h2></div>
                        <?php
                    }
                } elseif ( is_category( 'engagements' ) ) {
                    if( isset( $options[ 'engagements_blog_title' ] ) ) {
                        ?>             
                            <div class="page-header"><h2><?php echo $options[ 'engagements_blog_title' ];?></h2></div>
                        <?php
                    } else {
                         ?>             
                            <div class="page-header"><h2>Engagement Photos</h2></div>
                        <?php
                    }
                } elseif ( is_category( 'bridals' ) ) {
                    if( isset( $options[ 'bridals_blog_title' ] ) ) {
                        ?>             
                            <div class="page-header"><h2><?php echo $options[ 'bridals_blog_title' ];?></h2></div>
                        <?php
                    } else {
                         ?>             
                            <div class="page-header"><h2>Bridal Portraits</h2></div>
                        <?php
                    }
                } elseif ( is_category( 'articles' ) ) {
                    if( isset( $options[ 'articles_blog_title' ] ) ) {
                        ?>             
                            <div class="page-header"><h2><?php echo $options[ 'articles_blog_title' ];?></h2></div>
                        <?php
                    } else {
                         ?>             
                            <div class="page-header"><h2>Articles</h2></div>
                        <?php
                    }
                }

            ?>
    	
            
            <!-- Breadcrumbs -->
            <?php print_breadcrumbs(); ?>

            <div class="row">
                <div class="col-md-8 col-sm-7 index-content">

                <?php 

                    // Set the text to use for buttons.
                    if ( is_category( 'articles' ) ) {
                        $btn_text = 'Read More';
                    } else {
                        $btn_text = 'More Images';
                    }
 
                    // Render the excerpt if on the first page only.
                    if ( $paged < 2 ) :
                        if ( is_category( 'weddings' ) ) {

                            if( isset( $options[ 'weddings_blog_excerpt' ] ) ) {
                                ?>             
                                    <div class="category-about"><?php echo $options[ 'weddings_blog_excerpt' ];?></div>
                                <?php
                            }
                        } elseif ( is_category( 'engagements' ) ) {

                            if( isset( $options[ 'engagements_blog_excerpt' ] ) ) {
                                ?>             
                                    <div class="category-about"><?php echo $options[ 'engagements_blog_excerpt' ];?></div>
                                <?php
                            }
                        } elseif ( is_category( 'bridals' ) ) {

                            if( isset( $options[ 'bridals_blog_excerpt' ] ) ) {
                                ?>             
                                    <div class="category-about"><?php echo $options[ 'bridals_blog_excerpt' ];?></div>
                                <?php
                            }
                        } elseif ( is_category( 'articles' ) ) {

                            if( isset( $options[ 'articles_blog_excerpt' ] ) ) {
                                ?>             
                                    <div class="category-about"><?php echo $options[ 'articles_blog_excerpt' ];?></div>
                                <?php
                            }
                        } // end category check
                        endif; // end paged check

                    if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

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
                            <a href="<?php the_permalink(); ?>"><button type="button" class="btn btn-default"><?php echo $btn_text; ?></button></a>
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
