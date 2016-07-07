<?php
/**
 * Class used to render all theme specific options.
 *
 * @since 1.0.0
 */
add_action( 'admin_menu', function() {
	if ( current_user_can( 'manage_options' ) ) {
		new OE_Theme_Settings();
	}
} );

class OE_Theme_Settings {

	public function __construct() {
		$this->add_menu_options_page();
		$this->init_theme_options();
	}

	/**
	 * Function to add an options menu to the left side administration panel menu.
	 * This will be a top level menu which reads "OE Settings".
	 *
	 * @since 1.0.0
	 * @uses WordPress add_menu_page function.
	 */
	public function add_menu_options_page() {

		add_menu_page('OE Settings', 'OE Settings', 'manage_options', 'oe-settings', array($this, 'render_menu_page'), 'dashicons-admin-generic', '61.2' );

	}

	/**
	 * CB function to render the menu page
	 */
	public function render_menu_page() {
		?>
		<!-- Header created in the default WordPress 'wrap' container -->
		<div class="wrap">

			<h2>One Eleven Wedding Photography Settings</h2>

			<form method="post" action="options.php">

				<?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'company_options'; // set default tab ?>

				<h2 class="nav-tab-wrapper">
	            	<a href="?page=oe-settings&tab=company_options" class="nav-tab <?php echo $active_tab == 'company_options' ? 'nav-tab-active' : ''; ?>">Contact Settings</a>
	            	<a href="?page=oe-settings&tab=post_options" class="nav-tab <?php echo $active_tab == 'post_options' ? 'nav-tab-active' : ''; ?>">Post Settings</a>
                    <a href="?page=oe-settings&tab=blog_options" class="nav-tab <?php echo $active_tab == 'blog_options' ? 'nav-tab-active' : ''; ?>">Blog Settings</a>
	        	</h2>

				<?php 
					if( $active_tab == 'company_options' ) {
						settings_fields( 'oewpt_contact_options' );
						do_settings_sections( 'oewpt-contact-page');
					} else if ( $active_tab == 'post_options' ) {
						settings_fields( 'oewpt_post_options');
						do_settings_sections( 'oewpt-post-page' );
					} else {
					    settings_fields( 'oewpt_blog_options');
                        do_settings_sections( 'oewpt-blog-page' );
					}
				?>
				<p class="submit">
					<input name="submit" type="submit" id="oewpt-save-options" class="button-primary" value="Save Changes" />
				</p>
			</form>

		</div> <!-- end .wrap -->
	<?php
	} // end render_menu_page

	/**
	 * Render the options onto the theme menu page.
	 *
	 * @since 1.0.0
	 *
	 * @uses WordPress admin_init action hook.
	 */
	function init_theme_options() {

		add_action( 'admin_init', function() {

			// If options do not yet exist, create them.
			if ( false == get_option( 'oewpt_contact_options' ) ) {
				add_option( 'oewpt_contact_options' );
			}
			if ( false == get_option( 'oewpt_social_options' ) ) {
				add_option( 'oewpt_social_options' );
			}
			if ( false == get_option( 'oewpt_post_options' ) ) {
				add_option( 'oewpt_post_options' );
			}
            if ( false== get_option( 'oewpt_blog_options' ) ) {
                add_option( 'oewpt_blog_options' );
            }


			/* ------------------------------------------------------------------------ *
	 		* Register Settings Sections
	 		* ------------------------------------------------------------------------ */
			add_settings_section(
				'contact_settings_section',								// String used in the 'id' attribute tags
				'Contact Settings',									 	// Title of the section
				array( $this, 'contact_settings_section_callback' ), 	// Callback function to render message in section
				'oewpt-contact-page'									// The menu page on which to display the section
			);

			add_settings_section(
				'social_settings_section',							
				'Social Settings',									
				array( $this, 'social_settings_section_callback' ),
				'oewpt-contact-page'						
			);

			add_settings_section( 
				'post_settings_section',
				'Post Settings',
				array( $this, 'post_settings_section_callback' ),
				'oewpt-post-page'
			);
            add_settings_section(
                'category_settings_section',
                'Category Settings',
                array( $this, 'category_settings_section_callback' ),
                'oewpt-blog-page'
            );

			/* ------------------------------------------------------------------------ *
	 		* Add Settings Fields
	 		* ------------------------------------------------------------------------ */
	 		/* *******************
	 		 * Contact Settings
	 		 * *******************/
			add_settings_field(
				'address',							// String used in the 'id' attribute tags
				'Street Address',					// Label for the setting
				array( $this, 'address_callback' ),	// Fills the field with the desired input; passed single param of $args array
				'oewpt-contact-page',				// The page on which this option will be displayed
				'contact_settings_section'			// The name of the section to which this field belongs
			);

			add_settings_field(
				'city',							
				'City',					
				array( $this, 'city_callback' ),	
				'oewpt-contact-page',				
				'contact_settings_section'			
			);

			add_settings_field(
				'state',							
				'State',					
				array( $this, 'state_callback' ),	
				'oewpt-contact-page',				
				'contact_settings_section'			
			);

			add_settings_field(
				'zipcode',							
				'Zipcode',					
				array( $this, 'zipcode_callback' ),	
				'oewpt-contact-page',				
				'contact_settings_section'			
			);

			add_settings_field(
				'phone',							
				'Phone',					
				array( $this, 'phone_callback' ),	
				'oewpt-contact-page',				
				'contact_settings_section'			
			);

            add_settings_field(
                'sms',
                'SMS Number',
                array( $this, 'sms_callback' ),
                'oewpt-contact-page',
                'contact_settings_section'
            );

			/* *******************
	 		 * Social Settings
	 		 * *******************/
			add_settings_field(
				'facebook',							
				'Facebook',					
				array( $this, 'facebook_callback'),	
				'oewpt-contact-page',				
				'social_settings_section'			
			);

			add_settings_field(
				'twitter',							
				'Twitter',					
				array( $this, 'twitter_callback'),	
				'oewpt-contact-page',				
				'social_settings_section'			
			);

			add_settings_field(
				'instagram',							
				'Instagram',					
				array( $this, 'instagram_callback'),	
				'oewpt-contact-page',				
				'social_settings_section'			
			);

			add_settings_field(
				'pinterest',							
				'Pinterest',					
				array( $this, 'pinterest_callback'),	
				'oewpt-contact-page',				
				'social_settings_section'			
			);

			add_settings_field(
				'linkedin',							
				'Linkedin',					
				array( $this, 'linkedin_callback'),	
				'oewpt-contact-page',				
				'social_settings_section'			
			);

			add_settings_field(
				'googleplus',							
				'Google+',					
				array( $this, 'googleplus_callback'),	
				'oewpt-contact-page',				
				'social_settings_section'			
			);

			/* *******************
	 		 * Post Settings
	 		 * *******************/
			add_settings_field(	
				'disable_image_links',
				'Disable Image Links',
				array( $this, 'disable_image_links_callback' ),
				'oewpt-post-page',
				'post_settings_section',
				array( 'Activate this setting to disable image links within posts.' )
			);

			add_settings_field(	
				'vendor_types',
				'Vendor Classifications',
				array( $this, 'vendor_types_callback' ),
				'oewpt-post-page',
				'post_settings_section',
				array( 'Add multiple vendor types separated by a semi-colon (;).  For example: cake; music.' )
			);
            /* *******************
	 		 * Blog Settings
	 		 * *******************/
             add_settings_field(
                'weddings_blog_title',
                'Weddings Blog Title',
                array( $this, 'category_blog_title_callback' ),
                'oewpt-blog-page',
                'category_settings_section',
                array( 'cat_name' => 'weddings' )
             );
             add_settings_field(
                'weddings_blog_excerpt',
                'Weddings Blog Excerpt',
                array( $this, 'category_blog_excerpt_callback' ),
                'oewpt-blog-page',
                'category_settings_section',
                array( 'cat_name' => 'weddings' )
             );
             add_settings_field(
                'engagements_blog_title',
                'Engagements Blog Title',
                array( $this, 'category_blog_title_callback' ),
                'oewpt-blog-page',
                'category_settings_section',
                array( 'cat_name' => 'engagements' )
             );
             add_settings_field(
                'engagements_blog_excerpt',
                'Engagements Blog Excerpt',
                array( $this, 'category_blog_excerpt_callback' ),
                'oewpt-blog-page',
                'category_settings_section',
                array( 'cat_name' => 'engagements' )
             );
             add_settings_field(
                'bridals_blog_title',
                'Bridals Blog Title',
                array( $this, 'category_blog_title_callback' ),
                'oewpt-blog-page',
                'category_settings_section',
                array( 'cat_name' => 'bridals' )
             );
             add_settings_field(
                'bridals_blog_excerpt',
                'Bridals Blog Excerpt',
                array( $this, 'category_blog_excerpt_callback' ),
                'oewpt-blog-page',
                'category_settings_section',
                array( 'cat_name' => 'bridals' )
             );
             add_settings_field(
                'articles_blog_title',
                'Articles Blog Title',
                array( $this, 'category_blog_title_callback' ),
                'oewpt-blog-page',
                'category_settings_section',
                array( 'cat_name' => 'articles' )
             );
             add_settings_field(
                'articles_blog_excerpt',
                'Articles Blog Excerpt',
                array( $this, 'category_blog_excerpt_callback' ),
                'oewpt-blog-page',
                'category_settings_section',
                array( 'cat_name' => 'articles' )
             );

			/* --------------------------------------------- *
			 * Register settings
			 * --------------------------------------------- */
			register_setting(
				'oewpt_contact_options',
				'oewpt_contact_options',
				array( $this, 'oewpt_sanitize_text' )
			);

			register_setting(
				'oewpt_post_options',
				'oewpt_post_options',
				array( $this, 'oewpt_sanitize_text' )
			);

            register_setting(
                'oewpt_blog_options',
                'oewpt_blog_options',
                ''
            );

		}); // end admin_init

	} // end init_theme_options

	/* ------------------------------------------------------------------------ *
	 * Section Callbacks
	 * ------------------------------------------------------------------------ */
	/**
	 * Contact Settings
	 */
	public function contact_settings_section_callback() {
		echo '<p>Please fill in contact information.</p>';
	}

	/**
	 * Social Settings
	 */
	public function social_settings_section_callback() {
		echo '<p>Provide the URL to the social networks you\'d like to display.</p>';
	}

	/**
	 * Post Settings
	 */
	public function post_settings_section_callback() {
		echo '<p>Provide information to customize the functionality of posts.</p>';
	}
    /**
     * Category Settings
     */
     public function category_settings_section_callback() {
         echo '<p>Customize category pages that aggregate blog entries.</p>';
     }

	/* ------------------------------------------------------------------------ *
	 * Contact Settings Field Callbacks
	 * ------------------------------------------------------------------------ */
	 /**
	  * Address Setting
	  */
	 public function address_callback() {

	 	// First, we read the contact options collection
	 	$options = get_option( 'oewpt_contact_options' );

	 	// Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
 		$value = '';
 		if( isset( $options[ 'address' ] ) ) {
 			$value = $options[ 'address' ];
 		}

 		// Render the output
 		echo '<input type="text" id="address" name="oewpt_contact_options[address]" value="' . $value . '" size="25" />';
	 }

	 /**
	  * City Setting
	  */
	 public function city_callback() {

	 	// First, we read the contact options collection
	 	$options = get_option( 'oewpt_contact_options' );

	 	// Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
 		$value = '';
 		if( isset( $options[ 'city' ] ) ) {
 			$value = $options[ 'city' ];
 		}

 		// Render the output
 		echo '<input type="text" id="city" name="oewpt_contact_options[city]" value="' . $value . '" size="20" />';
	 }

	 /**
	  * State Setting
	  */
	 public function state_callback() {

	 	// First, we read the contact options collection
	 	$options = get_option( 'oewpt_contact_options' );

	 	// Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
 		$value = '';
 		if( isset( $options[ 'state' ] ) ) {
 			$value = $options[ 'state' ];
 		}

 		// Render the output
 		echo '<input type="text" id="state" name="oewpt_contact_options[state]" value="' . $value . '" size="2" />';
	 }

	 /**
	  * Zipcode Setting
	  */
	 public function zipcode_callback() {

	 	// First, we read the contact options collection
	 	$options = get_option( 'oewpt_contact_options' );

	 	// Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
 		$value = '';
 		if( isset( $options[ 'zipcode' ] ) ) {
 			$value = $options[ 'zipcode' ];
 		}

 		// Render the output
 		echo '<input type="text" id="zipcode" name="oewpt_contact_options[zipcode]" value="' . $value . '" size="5" />';
	 }

	 /**
	  * Phone Setting
	  */
	 public function phone_callback() {

	 	// First, we read the contact options collection
	 	$options = get_option( 'oewpt_contact_options' );

	 	// Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
 		$value = '';
 		if( isset( $options[ 'phone' ] ) ) {
 			$value = $options[ 'phone' ];
 		}

 		// Render the output
 		echo '<input type="text" id="phone" name="oewpt_contact_options[phone]" value="' . $value . '" size="15" />';
	 }

     /**
	  * SMS Setting
	  */
	 public function sms_callback() {

	 	// First, we read the contact options collection
	 	$options = get_option( 'oewpt_contact_options' );

	 	// Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
 		$value = '';
 		if( isset( $options[ 'sms' ] ) ) {
 			$value = $options[ 'sms' ];
 		}

 		// Render the output
 		echo '<input type="text" id="sms" name="oewpt_contact_options[sms]" value="' . $value . '" size="15" />';
	 }

	 /* ------------------------------------------------------------------------ *
	 * Social Settings Field Callbacks
	 * ------------------------------------------------------------------------ */
	 /**
	  * Facebook Setting
	  */
	 public function facebook_callback() {

	 	// First, we read the contact options collection
	 	$options = get_option( 'oewpt_contact_options' );

	 	// Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
 		$value = '';
 		if( isset( $options[ 'facebook' ] ) ) {
 			$value = $options[ 'facebook' ];
 		}

 		// Render the output
 		echo '<input type="text" id="facebook" name="oewpt_contact_options[facebook]" value="' . $value . '" size="35" />';
	 }

	 /**
	  * Twitter Setting
	  */
	 public function twitter_callback() {

	 	// First, we read the contact options collection
	 	$options = get_option( 'oewpt_contact_options' );

	 	// Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
 		$value = '';
 		if( isset( $options[ 'twitter' ] ) ) {
 			$value = $options[ 'twitter' ];
 		}

 		// Render the output
 		echo '<input type="text" id="twitter" name="oewpt_contact_options[twitter]" value="' . $value . '" size="35" />';
	 }

	 /**
	  * Instagram Setting
	  */
	 public function instagram_callback() {

	 	// First, we read the contact options collection
	 	$options = get_option( 'oewpt_contact_options' );

	 	// Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
 		$value = '';
 		if( isset( $options[ 'instagram' ] ) ) {
 			$value = $options[ 'instagram' ];
 		}

 		// Render the output
 		echo '<input type="text" id="instagram" name="oewpt_contact_options[instagram]" value="' . $value . '" size="35" />';
	 }

	 /**
	  * Pinterest Setting
	  */
	 public function pinterest_callback() {

	 	// First, we read the contact options collection
	 	$options = get_option( 'oewpt_contact_options' );

	 	// Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
 		$value = '';
 		if( isset( $options[ 'pinterest' ] ) ) {
 			$value = $options[ 'pinterest' ];
 		}

 		// Render the output
 		echo '<input type="text" id="pinterest" name="oewpt_contact_options[pinterest]" value="' . $value . '" size="35" />';
	 }

	 /**
	  * Linkedin Setting
	  */
	 public function linkedin_callback() {

	 	// First, we read the contact options collection
	 	$options = get_option( 'oewpt_contact_options' );

	 	// Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
 		$value = '';
 		if( isset( $options[ 'linkedin' ] ) ) {
 			$value = $options[ 'linkedin' ];
 		}

 		// Render the output
 		echo '<input type="text" id="linkedin" name="oewpt_contact_options[linkedin]" value="' . $value . '" size="35" />';
	 }

	 /**
	  * Google+ Setting
	  */
	 public function googleplus_callback() {

	 	// First, we read the contact options collection
	 	$options = get_option( 'oewpt_contact_options' );

	 	// Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
 		$value = '';
 		if( isset( $options[ 'googleplus' ] ) ) {
 			$value = $options[ 'googleplus' ];
 		}

 		// Render the output
 		echo '<input type="text" id="googleplus" name="oewpt_contact_options[googleplus]" value="' . $value . '" size="35" />';
	 }

	 /* ------------------------------------------------------------------------ *
	 * Post Settings Field Callbacks
	 * ------------------------------------------------------------------------ */
	/**
	 * Disable Image Links
	 */
	public function disable_image_links_callback( $args ) {

		// Read the options collection
		$options = get_option( 'oewpt_post_options' );

		// Default setting to off and check for actual setting (avoids undefined index error)
		$image_link = "0";
		if( isset( $options[ 'disable_image_links' ] ) ) {
			$image_link = $options[ 'disable_image_links' ];
		}

		// Update the attribute with what is in the database based on the name
		$html = '<input type="checkbox" id="disable_image_links" name="oewpt_post_options[disable_image_links]" value="1" ' . checked(1, $image_link, false ) . '/>';

		// Take the first argument of the array and add it to a label next to checkbox.
		$html .= '<label for="disable_image_links"> ' . $args[0] . '</label>';

		echo $html;
	} // end disable_image_links_callback

	/**
	 * Vendor Classifications
	 */
	public function vendor_types_callback( $args ) {

		// Read the options collection
		$options = get_option( 'oewpt_post_options' );

		// Retrieve vendor types if they exist, otherwise we initialize empty string.
		$vendor_types = '';
		if( isset( $options['vendor_types'] ) ) {
			$vendor_types = $options['vendor_types'];
		}

		// Render the output
		echo '<textarea rows="10" cols="75" id="vendor_types" name="oewpt_post_options[vendor_types]">'. $vendor_types . '</textarea><br />';

		// Take the first argument of the array and add it to a label next to checkbox.
		echo '<label for="vendor_types"> ' . $args[0] . '</label>';
	} // end vendor_types_callback

    /* ------------------------------------------------------------------------ *
	 * Post Settings Field Callbacks
	 * ------------------------------------------------------------------------ */
    /**
	  * Category Title Callback
	  */
	 public function category_blog_title_callback( $args ) {

	 	// First, we read the contact options collection
	 	$options = get_option( 'oewpt_blog_options' );

        // Retrieve the category name being supplied.
        $cat_name = $args[ 'cat_name' ];

	 	// Next, we need to make sure the element is defined in the options.
 		$value = '';
        
        if ( $cat_name == 'weddings' ) {
            if( isset( $options[ 'weddings_blog_title'] ) ) {
                $value = $options[ 'weddings_blog_title' ];
            }
            echo '<input type="text" id="weddings_blog_title" name="oewpt_blog_options[weddings_blog_title]" value="' . $value . '" size="35" />';

        } elseif ( $cat_name == 'engagements' ) {
            if( isset( $options[ 'engagements_blog_title'] ) ) {
                $value = $options[ 'engagements_blog_title' ];
            }
            echo '<input type="text" id="engagements_blog_title" name="oewpt_blog_options[engagements_blog_title]" value="' . $value . '" size="35" />';

        } elseif ( $cat_name == 'bridals' ) {
            if( isset( $options[ 'bridals_blog_title'] ) ) {
                $value = $options[ 'bridals_blog_title' ];
            }
            echo '<input type="text" id="bridals_blog_title" name="oewpt_blog_options[bridals_blog_title]" value="' . $value . '" size="35" />';

        } elseif ( $cat_name == 'articles' ) {
            if( isset( $options[ 'articles_blog_title'] ) ) {
                $value = $options[ 'articles_blog_title' ];
            }
            echo '<input type="text" id="articles_blog_title" name="oewpt_blog_options[articles_blog_title]" value="' . $value . '" size="35" />';
        }
	 }

     public function category_blog_excerpt_callback( $args ) {
         
         // Read the options collection
		$options = get_option( 'oewpt_blog_options' );

        // Retrieve the category name being supplied.
        $cat_name = $args[ 'cat_name' ];

	 	// Next, we need to make sure the element is defined in the options.
 		$value = '';

         if ( $cat_name == 'weddings' ) {
            if( isset( $options[ 'weddings_blog_excerpt'] ) ) {
                $value = $options[ 'weddings_blog_excerpt' ];
            }
            echo '<textarea rows="10" cols="100" id="weddings_blog_excerpt" name="oewpt_blog_options[weddings_blog_excerpt]">'. $value . '</textarea><br />';

        } elseif ( $cat_name == 'engagements' ) {
            if( isset( $options[ 'engagements_blog_excerpt'] ) ) {
                $value = $options[ 'engagements_blog_excerpt' ];
            }
            echo '<textarea rows="10" cols="100" id="engagements_blog_excerpt" name="oewpt_blog_options[engagements_blog_excerpt]">'. $value . '</textarea><br />';

        } elseif ( $cat_name == 'bridals' ) {
            if( isset( $options[ 'bridals_blog_excerpt'] ) ) {
                $value = $options[ 'bridals_blog_excerpt' ];
            }
            echo '<textarea rows="10" cols="100" id="bridals_blog_excerpt" name="oewpt_blog_options[bridals_blog_excerpt]">'. $value . '</textarea><br />';

        } elseif ( $cat_name == 'articles' ) {
            if( isset( $options[ 'articles_blog_excerpt'] ) ) {
                $value = $options[ 'articles_blog_excerpt' ];
            }
            echo '<textarea rows="10" cols="100" id="articles_blog_excerpt" name="oewpt_blog_options[articles_blog_excerpt]">'. $value . '</textarea><br />';
        }
		
     }
	 

	 /* ------------------------------------------------------------------------ *
	 * Sanitize Functions
	 * ------------------------------------------------------------------------ */
	/**
	 * Standard text sanitization.  This function prevents malicious attacks
	 * done via JS and SQL.
	 *
	 * @package One Eleven Wedding Photography Customization
	 * @subpackage includes/admin
	 * @since 1.0.0
	 */
	public function oewpt_sanitize_text( $input ) {

		// Define the array for the updated options
		$output = array();

		// Loop through each of the options sanitizing the data
		foreach( $input as $key => $val ) {

			if( isset( $input[$key] ) ) {
				$output[$key] = strip_tags( stripslashes( $input[$key] ) );
			}
		}

		// Return the new collection
		return apply_filters( 'oewpt_sanitize_text', $output, $input );
		
	} // end oewpt_sanitize_text

	/**
	 * Standard url text sanitization.  This function prevents malicious attacks
	 * done via JS and SQL.
	 *
	 * @package One Eleven Wedding Photography Customization
	 * @subpackage includes/admin
	 * @since 1.0.0
	 */
	public function oewpt_sanitize_url( $input ) {

		// Define the array for the updated options
		$output = array();

		// Loop through each of the options sanitizing the data
		foreach( $input as $key => $val ) {

			if( isset( $input[$key] ) ) {
				$output[$key] = esc_url_raw( strip_tags( stripslashes( $input[$key] ) ) );
			}
		}

		// Return the new collection
		return apply_filters( 'oewpt_sanitize_url', $output, $input );
		
	} // end oewpt_sanitize_url

} // end Theme_Settings

?>