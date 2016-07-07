<?php
/**
 * Function removes the default WordPress setting of adding links
 * to media files in blogs when attached.
 *
 * @since 1.0.0
 */
add_action( 'init', function() {

	// Retrieve options related to the post.
	$options = get_option( 'oewpt_post_options' );

	$disable_links = '';
	// If option is set, retrieve it
	if( isset( $options[ 'disable_image_links' ] ) ) {
		$disable_links = $options[ 'disable_image_links' ];
	}	

	if ( $disable_links ) {
		update_option( 'image_default_link_type', 'none' );
	} else {
		update_option( 'image_default_link_type', 'file' );
	}

} ); // end add_action('init')

/**
 * Use to create an array out of a delimited string.  Useful in some
 * admin related code.
 *
 * @since 1.0.0
 *
 * @param string $delimiter  The type of delimiter being used to in the
 * supplied string.
 * @param string $string  The supplied string to turn into an array
 *
 * @return array $return_array  An array returned to calling application.
 */
function fetch_array_from_string( $delimiter, $string ) {

	// Break the string into an array for processing
	$return_array = explode( $delimiter, $string );

	// Remove any whitespace in the string
	foreach ( $return_array as $val ) {
		$val = trim( $val );
	}

	return $return_array;
} // end fetch_array_from_string

?>