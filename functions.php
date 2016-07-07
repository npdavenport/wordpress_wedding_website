<?php
        
    // Enable thumbnail support
    add_theme_support( 'post-thumbnails' );

    // Define theme constants
    define( 'THEMEDIR', get_bloginfo( 'stylesheet_directory' ) );
    define( 'IMAGES', THEMEDIR . "/images/" );
    define( 'SCRIPTS', THEMEDIR . "/js/" );
    define( 'FONTS', THEMEDIR . "/fonts/" );
    define( 'CSS', THEMEDIR . "/css/" );

    // Include custom functionality from other files.
    include_once( 'includes/admin-functionality.php' );
    include_once( 'includes/custom-post-types.php' );
    include_once( 'includes/custom-post-user-data.php' );
    include_once( 'includes/posts-redirect.php' );
    include_once( 'includes/testimonial-widget.php' );
    include_once( 'includes/theme-options.php' );

    /* ----------------------------------------
        Add Scripts
    ------------------------------------------ */
    add_action( 'wp_enqueue_scripts', function() {
        wp_enqueue_script( 'scroll-to-top', SCRIPTS . 'scroll-to-top.js', array( 'jquery' ), '1.0', true );
    });

    // Add script below only on FAQ page.
    add_action( 'wp_enqueue_scripts', function() {
       
       // Enqueue script only on faq page.
       if ( is_page_template( 'page-faq.php' ) ) {
           wp_enqueue_script( 'page-faq', SCRIPTS . 'page-faq.js', array( 'jquery' ), '1.0', true );
       } 
    });
    
    // Google Analytics
    add_action( 'wp_footer', function() {
    	?>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-58622626-1', 'auto');
	  ga('send', 'pageview');
	
	</script>
	<?php
    });

    /* ----------------------------------------
        Registrations
    ------------------------------------------ */
    // Main Navigation Manu
    add_action( 'after_setup_theme', 'oewpt_setup' );
    if( ! function_exists( 'oewpt_setup' ) ):
        function oewpt_setup() {
            register_nav_menu( 'primary', __( 'Primary navigation', 'oewptmenu' ) );
        } endif;

    // Custom navigation walker
    require_once( 'wp_bootstrap_navwalker.php' );

    // Add support for a sidebar
    if ( function_exists( 'register_sidebar' ) ) {
        register_sidebar(
            array(
                'name' => __( 'Primary Sidebar', 'primary-sidebar' ),
                'id' => 'primary-widget-area',
                'description' => __( 'The primary widget area', 'dir' ),
                'before_widget' => '<div class="list-group"><div class="list-group-item sidebar-group">',
                'after_widget' => '</div></div>',
                'before_title' => '<h4 class="list-group-item-handling">',
                'after_title' => '</h4>'
            )
        );   
    }

    /* ----------------------------------------
        Custom Functions
    ------------------------------------------ */
    /**
     * This function will add the class "img-responsive" to any images uploaded
     * to a post.  This class is part of the bootstrap framework the theme
     * uses and thus needed to maintain proper image alignment.
     *
     * @since 1.0.0
     *
     * @param Document Object $content WordPress content from post.
     * @return Document Object $html Newly saved HTML after changes.
     */
     add_filter( 'the_content', function( $content ) {
       
         $content = mb_convert_encoding( $content, 'HTML-ENTITIES', "UTF-8");

         // Proceed if content is available
         if ( !empty( $content ) ) {

            $document = new DOMDocument();
             libxml_use_internal_errors( TRUE );
             $document->loadHTML( utf8_decode( $content ) );

             $imgs = $document->getElementsByTagName( 'img' );
             foreach ( $imgs as $img ) {
                 $existing_class = $img->getAttribute( 'class' );
                 $img->setAttribute( 'class', 'img-responsive ' . $existing_class );
             }

             $html = $document->saveHTML();
             return $html;
         }

         return;
         
     });

     /**
      * Functionality to include breadcrumbs at the top of a page.
      * This function echos out HTML directly to the page it is called
      * from so there are no return parameters.
      *
      * @since 1.0.0
      */
     if ( !function_exists( 'print_breadcrumbs' ) ) {
        function print_breadcrumbs() {

            $show_on_home   = 1;                            // 1 - show "breadcrumbs" on home page, 0 - hide
            $delimiter      = ''; //<li class="divider"></li>';  // divider
            $home           = get_bloginfo( 'name' );       // text for link "Home"
            $show_current   = 1;                            // 1 - show title current post/page, 0 - hide
            $before         = '<li class="active">';        // open tag for active breadcrumb
            $after          = '</li>';                      // close tag for active breadcrumb

            global $post;
            $homeLink = home_url();

            if ( is_front_page() ) {
                if ( $show_on_home == 1 )
                    echo '<div class="row">';
                    echo '<ol class="breadcrumb"><li><a href="' . $homeLink . '">' . $home . '</a><li></ol></div>';
                } else {
                    echo '<div class="row">';
                    echo '<ol class="breadcrumb"><li><a href="' . $homeLink . '">' . $home . '</a></li>' . $delimiter;

                    if ( is_home() ) {
                        $blog_text = of_get_option( 'blog_text' );
                        if ( $blog_text == '' || empty( $blog_text ) ) {
                            echo theme_locals( "blog" );
                        }
                        echo $before . $blog_text . $after;
                    }
                    elseif ( is_category() ) {

                        $this_cat = get_category( get_query_var( 'cat' ), false );
                        if ( $this_cat->parent != 0 ) {
                            echo '<li>' . get_category_parents( $this_cat->parent, TRUE, ' ' . '</li>' . ' ' );
                        } 
                        echo $before . 'Category Archives: ' . single_cat_title( '', false ) . $after;
                    }
                    elseif ( is_search() ) {
                        echo $before . 'Search For: ' . get_search_query() . $after;
                    }
                    elseif ( is_day() ) {
                        echo '<li><a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a></li> ' . $delimiter . ' ';
                        echo '<li><a href="' . get_month_link( get_the_time( 'Y' ),get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a></li> ' . $delimiter . ' ';
                        echo $before . get_the_time( 'd' ) . $after;
                    }
                    elseif ( is_month() ) {
                        echo '<li><a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a></li> ' . $delimiter . ' ';
                        echo $before . get_the_time( 'F' ) . $after;
                    }
                    elseif ( is_year() ) {
                        echo $before . get_the_time( 'Y' ) . $after;
                    }
                    elseif ( is_tax( get_post_type() . '_category' ) ) {
                        $post_name = get_post_type();
                        echo $before . ucfirst( $post_name ) . ' Category: ' . single_cat_title( '', false ) . $after;
                    }
                    elseif ( is_single() && !is_attachment() ) {
                        if ( get_post_type() != 'post' ) {
                            $post_id = get_the_ID();
                            $post_name = get_post_type();
                            $post_type = get_post_type_object( get_post_type() );

                            $terms = get_the_terms( $post_id, $post_name .'_category' );
                            if ( $terms && ! is_wp_error( $terms ) ) {
                                echo '<li><a href="' .get_term_link( current( $terms )->slug, $post_name.'_category') .'">' . current( $terms )->name.'</a></li>';
                                echo ' ' . $delimiter . ' ';
                            }

                            if ( $show_current == 1 )
                                echo $before . get_the_title() . $after;
                        } else {
                            $cat = get_the_category();
                            if ( !empty( $cat ) ) {
                                $cat  = $cat[0];
                                $cats = get_category_parents( $cat, TRUE, '</li>' . $delimiter . '<li>' );
                                if ( $show_current == 0 )
                                    $cats = preg_replace( "#^(.+)\s$delimiter\s$#" , "$1", $cats );
                                echo '<li>' . substr( $cats, 0, strlen( $cats ) -4 );
                            }
                            if ( $show_current == 1 )
                                echo $before . get_the_title() . $after;
                        }
                    }
                    elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
                        $post_type = get_post_type_object( get_post_type() );
                        if ( isset( $post_type ) ) {
                            echo $before . $post_type->labels->singular_name . $after;
                        }
                    }
                    elseif ( is_attachment() ) {
                        $parent = get_post( $post->post_parent );
                        $cat    = get_the_category( $parent->ID );
                        if ( isset( $cat ) && !empty( $cat )) {
                            $cat    = $cat[0];
                            echo get_category_parents( $cat, TRUE, ' ' . $delimiter . ' ' );
                            echo '<li><a href="' . get_permalink( $parent ) . '">' . $parent->post_title . '</a></li>';
                        }
                        if ( $show_current == 1 )
                            echo $before . get_the_title() . $after;
                    }
                    elseif ( is_page() && !$post->post_parent ) {
                        if ( $show_current == 1 )
                            echo $before . get_the_title() . $after;
                    }
                    elseif ( is_page() && $post->post_parent ) {
                        $parent_id  = $post->post_parent;
                        $breadcrumbs = array();
                        while ($parent_id) {
                            $page          = get_page( $parent_id );
                            $breadcrumbs[] = '<li><a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a></li>';
                            $parent_id     = $page->post_parent;
                        }
                        $breadcrumbs = array_reverse( $breadcrumbs );
                        for ( $i = 0; $i < count($breadcrumbs); $i++ ) {
                            echo $breadcrumbs[$i];
                            if ( $i != count($breadcrumbs)-1 ) echo ' ' . $delimiter . ' ';
                        }
                        if ( $show_current == 1 )
                            echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
                    }
                    elseif ( is_tag() ) {
                        echo $before . 'Tag Archives: ' . single_tag_title( '', false ) . $after;
                    }
                    elseif ( is_author() ) {
                        global $author;
                        $userdata = get_userdata( $author );
                        echo $before . 'by ' . $userdata->display_name . $after;
                    }
                    elseif ( is_404() ) {
                        echo $before . '404' . $after;
                    }
                echo '</ol></div>'; // end breadcrums
            }

        } // end print_breadcrumbs()
     } // end function exists check

     /**
      * Function adds pagination support using boostrap theme.
      *
      * @since 1.0.0
      *
      * @param String $pages Description
      * @param int $range Number of items before pagination
      */
     if ( !function_exists( 'oewpt_pagination' ) ) {
        function oewpt_pagination( $pages = '', $range = 1 ) {

            $show_items = ( $range * 2 ) + 1;

            global $paged;

            if ( empty( $paged ) ) $paged = 1;

            // If pages aren't set, use wp_query find the total number of pages.
            if ( $pages == '' ) {

                global $wp_query;
                $pages = $wp_query->max_num_pages;
                if ( !$pages ) $pages = 1; // default to 1 if not set by now
            }

            // If multiple pages, paginate
            if ( $pages != 1 ) {

                echo '<div class="text-center">';
                echo '<nav><ul class="pagination"><li class="disabled hidden-xs">';
                echo '<span><span aria-hidden="true">Page ' . $paged . 'of' .$pages . '</span>';

                if ( $paged > 2 && $paged > $range+1 && $show_items < $pages ) {
                    echo "<li><a href='".get_pagenum_link(1)."' aria-label='First'>&laquo;<span class='hidden-xs'> First</span></a></li>";
                } 

                if ( $paged > 1 && $show_items < $pages ) {
                    echo "<li><a href='".get_pagenum_link($paged - 1)."' aria-label='Previous'>&lsaquo;<span class='hidden-xs'> Previous</span></a></li>";
                }

                for ( $i = 1; $i <= $pages; $i++ ) {
                    if ( $pages != 1 &&( !( $i >= $paged+$range+1 || $i <= $paged-$range-1 ) || $pages <= $show_items ) ) {
                        echo ( $paged == $i ) ? "<li class=\"active\"><span>" . $i . " <span class=\"sr-only\">(current)</span></span></li>":"<li><a href='".get_pagenum_link($i)."'>".$i."</a></li>";
                    }
                }

                if ( $paged < $pages && $show_items < $pages ) {
                    echo "<li><a href=\"".get_pagenum_link( $paged + 1 ) . "\"  aria-label='Next'><span class='hidden-xs'>Next </span>&rsaquo;</a></li>";    
                } 

                if ( $paged < $pages-1 &&  $paged+$range-1 < $pages && $show_items < $pages ) {
                    echo "<li><a href='".get_pagenum_link( $pages ) . "' aria-label='Last'><span class='hidden-xs'>Last </span>&raquo;</a></li>";
                }

                echo "</ul></nav>";
                echo "</div>";

            } // end pagination if

        } // end oewpt_pagination
     } // end function exists check

     /**
      * Add social media sharing buttons to the bottom of posts.
      *
      * @since 1.0.0
      * @param Document Object $content WordPress content from post.
      * @return Document Object $html Newly saved HTML after changes.
      */
     add_filter( 'the_content', function( $content ) {

        // Only show on specific pages
        if ( ( !is_page() && 'testimonials' != get_post_type() ) || is_single() ) {

            $content .= '<div class="social-share">';
            $content .= '<span class="st_facebook_hcount" displayText="Facebook"></span>';
            $content .= '<span class="st_twitter_hcount" displayText="Tweet"></span>';
            $content .= '<span class="st_linkedin_hcount" displayText="LinkedIn"></span>';
            $content .= '<span class="st_pinterest_hcount" displayText="Pinterest"></span>';
            $content .= '<span class="st_email_hcount" displayText="Email"></span>';
            $content .= '</div>';
            return $content;

        } else {
            // if not post/page then don't include sharing button
            return $content;
        }
     }); // end oewpt_social_sharing

    /**
     * Use this function to obtain all taxonomies associated with a post type.
     *
     * @since 1.0.0
     * @param int $post_identity The post id being processed.
     * @return array $taxonomies An array contianing all taxonomies associated
     *         with the post type.
     */
    function get_custom_taxonomies( $post_identity ) {

        // Get the post by ID
        $post = get_post( $post_identity );

        // Get the post type
        $post_type = $post->post_type;

        // Get taxonomies related to the post type
        $taxonomies = get_object_taxonomies( $post_type, 'objects' );

        $out = array();
        // Loop through taxonomies and put the terms in an array
        foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {

            $terms = get_the_terms( $post_identity, $taxonomy_slug );
            //var_dump($terms); die;

            if ( !empty( $terms ) ) {
                
                foreach ( $terms as $term ) {
                    $out[] .= $term->name;
                }
            }
        }

        return $out;
    }