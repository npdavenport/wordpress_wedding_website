<?php
/**
 * This function will display vendor information to the post when 
 * using the shortcode [vendors].
 *
 * @since 1.0.0
 */
add_action( 'template_redirect', function() {

	add_shortcode( 'vendors', function() {

		global $post;

		// Retrieve saved vendor information (data is saved as multi-dimension array)
		$saved_vendors = get_post_meta( $post->ID, '_oe_saved_vendors', true );

		$html = '<p class="vendor-title">This special day was made possible with the help of:</p>';
		$html .= '<div class="vendor-list">';
		$html .= '<ul>';

		// Loop through and print results to the post screen.
		foreach ( $saved_vendors as $vendors ) {

			$vendor_type = $vendors['vendor_type'];
			$vendor_name = $vendors['vendor_name'];
			$vendor_url = $vendors['vendor_url'];

			$html .= '<li>' . $vendor_type . ' - <a href="' . $vendor_url .'" class="vendor-link" target="_blank" rel="nofollow">' . $vendor_name . '</a></li>';
		}

		$html .= '</ul></div><br />';

		return $html;

	} ); // end add_shortcode('vendors')
} ); // end add_action('template_redirect')

?>