<?php
/*-----------------------------------------------
	Partners
-------------------------------------------------*/
add_action( 'init', function() {
	register_post_type( 'partners', 
		array (
			'labels' => array(
				'name'				 => 'Partners',
				'singular_name'		 => 'Partner',
				'add_new'			 => 'Add New Partner',
				'add_new_item'		 => 'Add New Partner',
				'edit_item'			 => 'Edit Partner',
				'view_item'			 => 'View Partners',
				'search_items'		 => 'Search Partners',
				'not_found'			 => 'No Partners Found',
				'not_found_in_trash' => 'No Partners Found in Trash',
			),
			'query_var'	=> 'partners',
			'rewrite'	=> array(
				'slug'	=> 'parnters-view'
			),
			'public'		=> true,
			'menu_position'	=> 7,
			'menu_icon'		=> 'dashicons-admin-links',
			'supports'		=> array(
				'title',
				'thumbnail',
				'excerpt'
			),
			'register_meta_box_cb' => 'add_partner_url_metabox',
		) // end partners array
	);

	register_taxonomy( 'partner-category', array( 'partners' ),
		array(
			'hierarchical'		=> true,
			'query_var'			=> 'partner_category',
			'rewrite'			=> array(
				'slug' => 'partner-category',
			),
			'labels' => array(
				'name'							=> 'Categories',
				'singular_item'					=> 'Category',
				'edit_item'						=> 'Edit Category',
				'update_item'					=> 'Update Category',
				'add_new_item'					=> 'Add New Category',
				'all_items'						=> 'All Categories',
				'search_items'					=> 'Search Categories',
				'popular_items'					=> 'Popular Categories',
				'separate_items_with_commas'	=> 'Separate categories with commas',
				'add_or_remove_items'			=> 'Add or Remove Category',
				'choose_from_most_used'			=> 'Choose from most used categories',
			) // end labels array
		)// end partner-category array
	);
});
/* -------------------
	Partner Metaboxes
--------------------- */
function add_partner_url_metabox() {
	add_meta_box( 'oewpt_partner_url', 'Website', 'render_partner_url', 'partners' );
}

// cb function to draw metaboxes to screen
function render_partner_url( $post ) {

	// Generate nonce for validation on post
	wp_nonce_field( 'oewpt_partner_url', 'oewpt_partner_url_nonce' );

	// Retrieve any previously stored partner url associated with the post
	$partner_url = get_post_meta( $post->ID, 'oewpt_partner_url', true );
	?>
	<p>
		<label for="oewpt_partner_url">Website: </label>
		<input type="text" class="widefat" name="oewpt_partner_url" id="oewpt_partner_url" value="<?php echo esc_attr( $partner_url ); ?>" />
	</p>
	<?php
} // end render_partner_url

// Save metabox data to the post.
add_action( 'save_post', function() {

	// Only continue if the post id exists
	if ( isset( $_POST['post_ID'] ) ) {

	    $post_id = $_POST['post_ID'];

	    // Check if our nonce is set.
	    if ( ! isset( $_POST['oewpt_partner_url_nonce'] ) )
	        return $post_id;

	    $nonce = $_POST['oewpt_partner_url_nonce'];

	    // Verify that the nonce is valid.
	    if ( ! wp_verify_nonce( $nonce, 'oewpt_partner_url' ) )
	        return $post_id;

	    // If this is an autosave, our form has not been submitted,
	    // so we don't want to do anything.
	    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
	        return $post_id;

	    // Check the user's permissions.
	    if ( 'oewpc_partners' == $_POST['post_type'] ) {

	        if ( ! current_user_can( 'edit_page', $post_id ) )
	            return $post_id;

	    } else {

	        if ( ! current_user_can( 'edit_post', $post_id ) )
	            return $post_id;
	    }

	    /* OK, its safe for us to save the data now. */
	    $parner_url = $_POST['oewpt_partner_url'];
	    update_post_meta( $post_id, 'oewpt_partner_url', $parner_url );
	}

}); // end save_post

/*-----------------------------------------------
	Testimonials
-------------------------------------------------*/
add_action( 'init', function() {
	register_post_type( 'testimonials', 
		array (
			'labels' => array(
				'name'				 => 'Testimonials',
				'singular_name'		 => 'Testimonial',
				'add_new'			 => 'Add New Testimonial',
				'add_new_item'		 => 'Add New Testimonial',
				'edit_item'			 => 'Edit Testimonial',
				'view_item'			 => 'View Testimonials',
				'search_items'		 => 'Search Testimonials',
				'not_found'			 => 'No Testimonials Found',
				'not_found_in_trash' => 'No Testimonials Found in Trash',
			),
			'query_var'	=> 'testimonials',
			'rewrite'	=> array(
				'slug'	=> 'testimonials-view'
			),
			'public'		=> true,
			'menu_position'	=> 4,
			'menu_icon'		=> 'dashicons-format-quote',
			'supports'		=> array(
				'title',
				'thumbnail',
				'editor'
			),
		) // end testimonials array
	);
});

?>