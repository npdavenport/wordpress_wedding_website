<?php
    /* Main header file for theme */
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">  

        <title><?php bloginfo( 'name' ); ?> | <?php wp_title(); ?></title>
        
        <!-- Favicon -->        
        <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />

        <!-- Stylesheets -->
        <link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

        <!-- Custom Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Arimo' rel='stylesheet' type='text/css'>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        
        <!-- WordPress Pingback Support -->   
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

        <?php wp_head(); ?> <!-- this is used by many Wordpress features and for plugins to work properly -->

        <script type="text/javascript">var switchTo5x=true;</script>
        <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
        <script type="text/javascript">stLight.options({publisher: "5dfdf426-51ce-4b9d-832f-9000a6db8d02", doNotHash: true, doNotCopy: true, hashAddressBar: false});</script>

    </head>
    <body>

        <!-- Fixed Navbar -->
        <nav class="navbar navbar-default navbar-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="<?php echo home_url(); ?>" class="navbar-brand"><img src="<?php print IMAGES . "logo.png"; ?>" alt="One Eleven Wedding Photography Logo" class="img-responsive" width="300" height="83"></a>
                </div><!-- /.navbar-header -->
                <div id="navbar" class="navbar-collapse collapse">
                     <?php /* Primary navigation */
                            wp_nav_menu( array(
                                'menu' => 'primary',
                                'theme_location' => 'primary',
                                'depth' => 2,
                                'container' => false,
                                'menu_class' => 'nav navbar-nav',
                                'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
                                //Process nav menu using our custom nav walker
                                'walker' => new wp_bootstrap_navwalker())
                            );
                        ?>
                </div> <!-- /.navbar-collapse -->
            </div><!-- /.container -->
        </nav> <!-- /.navbar -->

