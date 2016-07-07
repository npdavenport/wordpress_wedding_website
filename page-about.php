<?php/* * Template Name: About Page */
?>
<?php get_header(); ?>
    <!-- Page Content -->
    <div class="container default-page">
        <!-- Page Title -->
        <div class="page-header"><h2><?php the_title(); ?></h2></div>
        <!-- Breadcrumbs -->
        <?php print_breadcrumbs(); ?>
        <div class="row page-content">
            <div class="col-md-8 col-sm-7">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>            
                    <div class="row" id="about-content">
                        <?php the_content(); ?>            
                    </div> <!-- /.row-->
                <?php endwhile; else: ?>
                    <p><?php _e( 'No posts were found.  Sorry!' ); ?></p>
                <?php endif; ?>     
            </div> <!-- /.col-sm-8 -->
            <aside class="col-md-4 col-sm-5" id="about-sidebar">
                <div class="list-group">
                    <div class="list-group-item sidebar-group">
                <?php
                    // Create the query to retreive testimonials
                    $args = array(
                        'post_type'         => 'testimonials',
                        'posts_per_page'    => 2,
                    );
                    // Query the database
                    $testimonial_query = new WP_Query( $args );
                    // If testimonials exist, write framework to page
                    if ( $testimonial_query->have_posts() ) {
                        ?>
                        <div class="list-group">
                            <h4 class="list-group-item-handling">Love Letters</h4>                        
                        <?php
                    }
                    // Loop through the testimonials and build the HTMl return object
                    if ( $testimonial_query->have_posts()) : while ( $testimonial_query->have_posts() ) : $testimonial_query->the_post();
                        // Retrieve values needed from the post.
                        $excerpt = get_the_excerpt();
                        $title = get_the_title();
                        ?>
                        <blockquote class="testimonial-quote"><?php echo $excerpt;?><small><?php echo $title; ?></small></blockquote>
                    <?php endwhile; else: ?>
                        <p><?php _e( 'No testimonials were found.  Sorry!' ); return; ?></p>
                    <?php endif; ?>
                    </div> <!-- /.list-group -->
                <!-- memeberships & awards -->
                <div class="list-group">
                    <div class="col-lg-12">
                        <h4 class="list-group-item-handling" style="text-align: center; margin-bottom: 20px;">Memberships & Awards</h4>   
                    </div>
                    <div class="col-lg-12" style="margin-bottom: 20px;">
                        <link href='//www.weddingwire.com/assets/global/widget.css' rel='stylesheet' type='text/css'>
                        <div class='ww-bca-2016 ww-reset'>
                            <a title="ONE ELEVEN WEDDING PHOTOGRAPHY Reviews" class="ww-bca" href="http://www.weddingwire.com/reviews/one-eleven-wedding-photography-holly-springs/a3c37ead145ffda8.html"><img alt="ONE ELEVEN WEDDING PHOTOGRAPHY Reviews" src="//www.weddingwire.com/assets/badges/BCA-2016/BCA2016-logo_2x.png" />
                            </a>
                            <div class='ww-clear'>
                                &nbsp;
                                <img width="1" height="1" alt="" src="http://www.weddingwire.com/apis/v3/tracker?partner_key=163r5mm3&amp;target_id=a3c37ead145ffda8&amp;type=bca_2016" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12" style="margin-bottom: 20px; font-size:  10px;">
                        <a href="http://www.theknot.com/marketplace/one-eleven-wedding-photography-holly-springs-nc-846532">
                    <img src="//www.xoedge.com/myaccount/2012/bow-2016/71_71_gray.png" width="90" height="90" alt="The Knot Best of Weddings - 2016 Pick" border="0" style="margin:0 auto; display:block;"></a>
                    </div>
                     <div class="col-lg-12" style="margin-bottom: 20px;">
                        <script src='//www.weddingwire.com/assets/vendor/widgets/ww-rated-2013.js' type='application/javascript'></script><div id='ww-widget-wwrated-2013'><a class="ww-top" href="http://www.weddingwire.com" target="_blank" title="Weddings, Wedding, Wedding Venues"></a><a class="ww-bottom" href="http://www.weddingwire.com/reviews/one-eleven-wedding-photography-fuquay-varina/a3c37ead145ffda8.html" target="_blank" title="ONE ELEVEN WEDDING PHOTOGRAPHY Reviews, Raleigh - Triangle, Greensboro - Triad Photography"></a></div><script>  WeddingWire.ensureInit(function() {WeddingWire.createWWRated2013({"vendorId":"a3c37ead145ffda8" }); });</script>
                    </div>
                    <div class="col-lg-12">
                        <div style="padding-left: 33%; margin-bottom: 20px;">

                            <a href="https://www.thumbtack.com/nc/charlotte/local-photography/" id="thumbtack-medallion" target="_blank"><img src="https://static.thumbtack.com/media/widgets/featured-pro.png" alt="Thumbtack Best Pro of 2015"></a><script src="https://static.thumbtack.com/media/widgets/medallion-links.js"></script>                        </div>
                    </div>
                    <div class="col-lg-12">
                        <a href="http://www.fearlessphotographers.com/photographers.cfm?photogID=5288&shannon-davenport" class="thumbnail member-thumbnail"  target="_blank">
                            <img src="<?php echo IMAGES; ?>fearless-photographers.png" alt="fearless photogrpahers image">
                        </a>
                    </div>
                    <div class="col-lg-12">
                       <a href="http://www.ppa.com" class="thumbnail member-thumbnail" target="_blank">
                            <img title="Member, Professional Photographers of America" src="http://www.ppa.com/files/images/logos/memberlogo/ppa_logo_small.png" alt="Member, Professional Photographers of America" width="95" height="32" />
                        </a>
                    </div>
                </div><!-- /.list-group -->
                    </div> <!-- /.list-group-item sidebar-group -->
                </div> <!-- /.list-group -->
            </aside>
<?php get_footer(); ?>