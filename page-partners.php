<?php
/*
 * Template Name: Partners
 */
?>

<?php get_header(); ?>

    <!-- Page Content -->
    <div class="container full-page">

        <!-- Page Title -->
        <div class="page-header"><h2><?php the_title(); ?></h2></div>

        <!-- Breadcrumbs -->
        <?php print_breadcrumbs(); ?>

        <div class="row">
            
            <?php

                // Get partner post types.
                $args = array(
                    'post_type'        => 'partners',
                    'nopaging'         => true,
                );
                $partners_query = new WP_Query( $args );

                // Create arrays needed to store custom taxonomy information
                $cat_names = array();

                // Loop through all partners post and retreive all taxonomy category names
                if ( $partners_query->have_posts() ) : while ( $partners_query->have_posts() ) : $partners_query->the_post();

                    $cat_names[] = get_custom_taxonomies( $post->ID );

                endwhile; endif;

                // Remove duplicate category names
                $unique_cat_names = array_unique( $cat_names, SORT_REGULAR );

                foreach ( $unique_cat_names as $cat_name ) {

                    // Convert to string lowercase
                    $val = strtolower($cat_name[0]);

                    // Get parnter posts associated with the category name
                    $args = array(
                        'post_type' => 'partners',
                        'tax_query' => array(
                            array(
                                'taxonomy'  => 'partner-category',
                                'field'     => 'name',
                                'terms'     => $val,
                            ),
                        ),
                    );
                    $tax_query = new WP_Query( $args );

                    // If any posts exist, write out a category title to the screen
                    if ( $tax_query->have_posts() ) {
                        ?>
                        <!-- <div class="partner-cat col-sm-10 offset-2"> -->
                        <div class="col-md-8 col-sm-7 partner">
                            <h3 class="post-title"><?php echo $cat_name[0]; ?></h3>
                            <hr />
                        </div>
                        <?php
                    }

                    // Loop through all posts that were returned
                    if ( $tax_query->have_posts() ) : while ( $tax_query->have_posts() ) : $tax_query->the_post();

                        // Retrieve the image and metadata if an image is present
                        if ( has_post_thumbnail() ) {
                            $img_id = get_post_thumbnail_id();
                            $img_alt = get_post_meta( $img_id, '_wp_attachement_image_alt', true );
                            $img = wp_get_attachment_image_src( $img_id, 'full' );
                            $img_data = wp_get_attachment_metadata( $img_id );
                            $img_width = $img_data['width'];
                        }

                        // Retrieve the partner url.
                        $partner_url = get_post_meta( $post->ID, 'oewpt_partner_url', true );

                        // Choose correct image formatting based on image size.
                        if ( $img_width < 400 ) {
                            ?>
                                <!-- <div class="col-sm-9 offset-3 partner"> -->
                                <div class="col-md-8 col-sm-7 partner">
                                    <div class="media thumbnail">
                                        <span class="media-left">
                                            <img src="<?php echo $img[0]; ?>" alt="<?php echo $img_alt; ?>">
                                        </span>
                                        <div class="media-body">
                                            <h4 class="media-heading"><?php echo the_title(); ?></h4>
                                            <?php echo the_excerpt(); ?>
                                            <p><a href="<?php echo $partner_url; ?>" target="_blank" rel="nofollow" class="btn btn-primary" role="button">Visit Site</a></p>
                                        </div>
                                    </div>
                                </div>
                            <?php
                        } else {
                            ?>
                            <!-- <div class="col-sm-9 offset-3 partner"> -->
                            <div class="col-md-8 col-sm-7 partner">
                                <div class="thumbnail" >
                                    <img src="<?php echo $img[0]; ?>" alt="<?php echo $img_alt; ?>" class="pull-left">
                                    <div class="clearfix"></div>
                                    <div class="caption">
                                        <h4 class="media-heading"><?php echo the_title(); ?></h4>
                                        <?php echo the_excerpt(); ?>
                                        <p><a href="<?php echo $partner_url; ?>" target="_blank" rel="nofollow" class="btn btn-primary" role="button">Visit Site</a></p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }

                        ?>

                    <?php endwhile; else: ?>
                        <p><?php _e( 'No posts were found.  Sorry!' ); ?></p>
                    <?php endif;

                } // end foreach

            ?>


        </div> <!-- /. row -->

<?php get_footer(); ?>