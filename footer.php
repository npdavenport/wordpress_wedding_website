<?php
    /* Main footer file for the theme */
?>

    </div> <!-- ./container -->

   <!-- Markup for scroll to top arrow -->
    <div class="scroll-top-wrapper">
        <span class="scroll-top-inner">
            <i class="glyphicon glyphicon-arrow-up"></i>
        </span>
    </div>

<!-- Footer -->
        <footer>
            <div class="row">
                <div class="container">
                    <div class="col-sm-8 footer-left">
                        <?php
                            // Fetch user contact options
                            $options = get_option( 'oewpt_contact_options' );
                        ?>
                        <p>Contact Information</p>
                        <ul class="footer-contact">
                            <?php 
                                if ( array_key_exists( 'phone', $options ) ) {
                                    echo '<li><span class="glyphicon glyphicon-phone-alt"></span> &nbsp; Phone: ' . $options['phone'] . '</li>';
                                }
                                if ( array_key_exists( 'sms', $options ) ) {
                                    echo '<li><span class="glyphicon glyphicon-phone"></span> &nbsp; Text: ' . $options['sms'] . '</li>';
                                }
                                echo '<li><span class="glyphicon glyphicon-envelope"></span> &nbsp; Email: ' . '<a href="mailto:' . get_option( 'admin_email' ) .'" target="_blank">' . get_option( 'admin_email' ) . '</a></li>';
                            ?>
                        </ul>
                        
                        </p>
                        <p>Ready to book or find out more? Use the <a href="<?php echo home_url(); ?>/contact/">contact page.</a></p>
                        <p>&copy; <?php bloginfo( 'name' ); ?>, <?=date( 'Y' ); ?>. All Rigts Reserved.</p>
                    </div>

                    <?php
                        if ( $options ) {
                            // Check if any social media links exist before continuing.
                            if ( array_key_exists( 'facebook', $options ) ||
                                 array_key_exists( 'twitter', $options ) ||
                                 array_key_exists( 'pinterest', $options ) ||
                                 array_key_exists( 'instagram', $options ) ||
                                 array_key_exists( 'linkedin', $options ) ||
                                 array_key_exists( 'googleplus', $options ) ) {

                                // At least one social media link exists, start building the list
                                ?>
                                <div class="col-sm-4 social-col-xs"> <?php

                                // Loop through each possible social media link
                                foreach( $options as $name => $url ) {

                                    // Write out to screen if there is a social media link
                                    if( 
                                        strcasecmp( $name, 'facebook' ) == 0 ||
                                        strcasecmp( $name, 'twitter' ) == 0 ||
                                        strcasecmp( $name, 'pinterest' ) == 0 ||
                                        strcasecmp( $name, 'instagram' ) == 0 ||
                                        strcasecmp( $name, 'linkedin' ) == 0 ||
                                        strcasecmp( $name, 'googleplus' ) == 0
                                        ) {
                                        ?>
                                            <a href="<?php echo $url; ?>" target="_blank"><div class="social-slide" id="<?php echo $name . '-slide';?>"></div></a>
                                        <?php
                                    } // end if
                                } // end foreach

                                echo '</div>';

                            } // end if
                        } // end if $options
                        
                    ?>
                </div>
            </div> <!-- /.row -->
        </footer>
    </div>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="<?php print SCRIPTS . "bootstrap.min.js"; ?>"></script>

        <?php wp_footer(); ?> <!-- this is used by many Wordpress features and for plugins to work properly -->
    </body>
</html>