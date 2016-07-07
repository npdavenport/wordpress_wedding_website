<?php
/**
 * This class is used to add vendor functionality to posts.
 * Users may wish to add vendor information directly into a post.
 * Using this functionality allows for correct application and
 * consistent styling when compared to other posts.
 *
 * @since 1.0.0
 */
// Intantiate class if user has permission
if ( is_admin() ) {
	add_action( 'load-post.php', 'oe_load_custom_user_data' );
	add_action( 'load-post-new.php', 'oe_load_custom_user_data' );
}

function oe_load_custom_user_data() {
	new OE_Custom_User_Data();
}

class OE_Custom_User_Data {

	public function __construct() {

		$this->init_stylesheet();
		$this->init_admin_script();
		$this->vendor_metabox();
		$this->save_vendor_data();
	}

	/**
	 * Function used to initialize stylesheet for the editor
	 *
	 * @package One Eleven Wedding Photography Customization
 	 *
	 * @uses admin_print_styles-post.php WP action hook.
	 * @uses admin_print_styles-post-new.php WP action hook.
	 */
	public function init_stylesheet() {

		add_action( 'admin_print_styles-post.php', function() {
			wp_enqueue_style( 'style.css', CSS . 'admin.css', '', '1.0', false );
		});

		add_action( 'admin_print_styles-post-new.php', function() {
			wp_enqueue_style( 'style.css', CSS . 'admin.css', '', '1.0', false );
		});		
	}

	/**
	 * Function used to initialize admin script for the editor
	 *
 	 * @since 1.0.0
 	 *
	 * @uses admin_enqueue_scripts WP action hook.
	 */
	public function init_admin_script() {

		add_action( 'admin_enqueue_scripts', function() {
			wp_enqueue_script( 'oe-posts-screen', SCRIPTS . 'custom-post-user-data.js', array( 'jquery' ), '1.0', true );
		});		
	} // end init_admin_script()

	/**
	 * Function used to render the metabox to the screen.
	 *
 	 * @since 1.0.0
 	 *
	 * @uses add_meta_boxes WP action hook.
	 */
	public function vendor_metabox() {

		add_action( 'add_meta_boxes', function() {

			add_meta_box(
				'oe-vendor-metabox',
				'Vendors List',
				array( $this, 'render_vendor_metabox' ),
				'post',
				'normal',
				'high'
			);

		}); // end add_meta_boxes
	} // end vendor_metabox

	/**
	 * This function will render the metabox to the page.  This metabox contains two
	 * table elements for our data.  The first table will be used for displaying
	 * current vendors contained within the post.  The second table will be provide
	 * an interface for adding vendors to the page.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Post $post_id The post_id in which to reference
	 * the correct post.
	 */
	public function render_vendor_metabox( $post ) {

		// Generate a nonce field that we will use later for validation purposes.
		wp_nonce_field( 'oe_vendor_metabox', 'oe_vendor_metabox_nonce' );

		// Retrieve options that relate to the post
		$options = get_option( 'oewpt_post_options' );

		// Now get a list of vendor classifications. These are stored as semi-colon
		// separated string in the database.
		$vendor_type_string = $options[ 'vendor_types' ];

		// Use a utility to generate an array from the string
		$vendor_type_array = fetch_array_from_string( ';', $vendor_type_string );

		// Generate an initial table to display vendors related to the post if they exist.
		$this->init_vendor_table( $post->ID );

		// Build the html to be used.
		echo '<p><strong>Please fill out any vendor information you have:</strong></p>';

		?>
			<table class="oe-vendor-table">
				<thead>
					<tr>
						<th class="oe-left">
							<span>Vendor Type</span>
						</th>
						<th>
							<span>Vendor Information</span>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="oe-left">
							<select name="oe-vendor-type" id="oe-vendor-type-select">

						<?php
							echo '<option value="#NONE#">&#8212; Select &#8212;</option>';

							// Loop through all vendor types and display them in the select box
							foreach ( $vendor_type_array as $value ) {
								echo '<option value="' . $value . '">'. $value .'</option>';
							}

						?>
							</select>
						</td>
						<td>
							<input type="text" id="oe-vendor-name" name="oe-vendor-name" placeholder="Name">
						</td>
					</tr>
					<tr>
						<td class="oe-left">
							<div class="oe-submit">
								<input type="button" name="add-vendor" id="oe-add-vendor-button" class="button" value="Add Vendor" />
							</div>
						</td>
						<td>
							<input type="text" id="oe-vendor-url" name="oe-vendor-url" placeholder="Website">
						</td>
					</tr>
				</tbody>
			</table>
		<?php

	} // end render_vendor_metabox

	/**
	 * This function is used to create a table displaying any vendor information
	 * related to the post.
	 *
	 * @package One Eleven Wedding Photography Customization
	 * @subpackage includes/posts
	 * @since 1.0.0
	 *
	 * @param WP_Post $post_id The post_id in which to reference
	 * the correct post.
	 */
	public function init_vendor_table( $post_id ) {

		// Check if any vendor have been saved to the post previously.
		$current_vendors = get_post_meta( $post_id, '_oe_saved_vendors', true );

		// Hide the table if no vendors were found.  This is done because jQuery
		// relies on the table to exist in order to add vendors later.
		if ( $current_vendors ) {
			echo '<table id="oe-current-vendors-table" class="oe-vendor-table" >';
		} else {
			echo '<table id="oe-current-vendors-table" class="oe-vendor-table" style="display: none;" >';
		}

		?>
			<thead>
				<tr>
					<th class="oe-left">
						<span>Vendor Type</span>
					</th>
					<th>
						<span>Vendor Information</span>
					</th>
				</tr>
			</thead>
			<tbody>
			<?php
				// Add any existing vendors to the page before continuing
				$this->render_current_vendors( $post_id, $current_vendors );
			?>
			</tbody>
		</table>
		<?php

	} // end init_vendor_table

	/**
	 * This function will retrieve any currently saved vendorsthat the post may have 
	 * and render them to the screen.
	 *
	 * @package One Eleven Wedding Photography Customization
	 * @subpackage includes/posts
	 * @since 1.0.0
	 *
	 * @param WP_Post $post_id  The post_id in which to reference
	 * the correct post.
	 * @param unknown $current_vendors An array of any vendors saved to the
	 * current post.
	 */
	public function render_current_vendors( $post_id, $current_vendors ) {

		// Check if we have vendors before proceeding
		if ( $current_vendors ) {

			$i = 0;

			foreach ( $current_vendors as $vendors ) {

				$vendor_type = $vendors['vendor_type'];
				$vendor_name = $vendors['vendor_name'];
				$vendor_url = $vendors['vendor_url'];

				// Santizie user data
				sanitize_text_field( $vendor_name );
				esc_url( $vendor_url );
				$vendor_name_safe = str_replace( " ", "-", $vendor_name );
				$vendor_type_safe = str_replace( " ", "-", $vendor_type );

				// Print out entry to screen
				echo '<tr class="vendor-count" style-"display: hidden;"></tr>';
				echo '<tr id="oe-' . $vendor_type_safe . '-row">';
				echo '<td class="oe-left">';
				echo '<input type="text" name="_oe_saved_vendors[' . $i . '][vendor_type]" value="' . $vendor_type . '" />';
				echo '</td>';
				echo '<td>';
				echo '<input type="text" name="_oe_saved_vendors[' . $i . '][vendor_name]" id="oe-' . $vendor_name_safe . '"
								value="' . $vendor_name . '" />';
				echo '</td>';
				echo '</tr>';
				echo '<tr id="oe-' . $vendor_type_safe . '-del-row">';
				echo '<td class="oe-left">';
				echo '<div class="oe-submit">';
				echo '<input type="button" value="Delete" name="oe-del-button" id="oe-del-button" class="button button-small"' .
					'remove_row="#oe-' . $vendor_type_safe . '-row:#oe-' . $vendor_type_safe . '-del-row" />';
				echo '</div>';
				echo '</td>';
				echo '<td>';
				echo '<input type="text" name="_oe_saved_vendors[' . $i . '][vendor_url]" id="oe-' . $vendor_url . '" ' .
					'value="' . $vendor_url . '" />';
				echo '</td>';
				echo '</tr>';

				$i++;
			} // end for
		} // end if

	} // end render_current_vendors

	/**
	 * This function is responsible for saving post meta data.  This function will be 
	 * called when the 'save_post' action hook it triggered.
	 *
	 * @package One Eleven Wedding Photography Customization
	 * @subpackage includes/posts
	 * @since 1.0.0
	 *
	 * @param WP_Post $post_id The post_id in which to reference
	 * the correct post.
	 */
	public function save_vendor_data() {

		add_action( 'save_post', function( $post_id ) {

			/*
			 * We need to verify this came from the our screen and with proper authorization,
			 * because save_post can be triggered at other times.
			 */

			// Check if our nonce is set.
			if ( ! isset( $_POST['oe_vendor_metabox_nonce'] ) )
				return $post_id;

			$nonce = $_POST['oe_vendor_metabox_nonce'];

			// Verify that the nonce is valid.
			if ( ! wp_verify_nonce( $nonce, 'oe_vendor_metabox' ) )
				return $post_id;

			// If this is an autosave, our form has not been submitted,
			//     so we don't want to do anything.
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return $post_id;

			// Check the user's permissions.
			if ( 'page' == $_POST['post_type'] ) {

				if ( ! current_user_can( 'edit_page', $post_id ) )
					return $post_id;

			} else {

				if ( ! current_user_can( 'edit_post', $post_id ) )
					return $post_id;
			}

			/* OK, its safe for us to save the data now. */

			// First, retrieve any vendors added by the user.
			$new_vendors = $_POST['_oe_saved_vendors'];

			// Then save post meta data to the database.
			update_post_meta( $post_id, '_oe_saved_vendors', $new_vendors );

		}); // end save_post

	} // end save_vendor_data

} // end OE_Custom_User_Data

?>