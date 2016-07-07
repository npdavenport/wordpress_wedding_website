jQuery( document ).ready( function( $ ) {

	/**
	 * This function is responsible for adding vendor information to
	 * the table displaying current vendors.
	 *
	 * @package One Eleven Wedding Photography Customization
	 * @subpackage includes/js
	 * @since 1.0.0
	 */
	 $( '#oe-add-vendor-button' ).click( function() {

	 	var valid = false;

	 	// Retrieve and trim user input
	 	var vendorType = $.trim( $( '#oe-vendor-type-select' ).val() );
	 	var vendorName = $.trim( $( '#oe-vendor-name' ).val() );
	 	var vendorUrl = $.trim( $( '#oe-vendor-url' ).val() );

	 	// Validate Vendor Type
	 	valid = validateUserInput( vendorType );
	 	if( valid === false ) {
	 		$( '#oe-vendor-type-select' ).css( {"color" : "red", "border-color" : "red" } );
	 		return;
	 	}

	 	// Validate Vendor Name
	 	valid = validateUserInput( vendorName );
	 	if( valid === false ) {
	 		$( '#oe-vendor-name' ).css( {"color" : "red", "border-color" : "red" } );
	 		return;
	 	}

	 	// Validate Vendor URL
	 	valid = validateUserInput( vendorUrl );
	 	if( valid === false ) {
	 		$( '#oe-vendor-url' ).css( {"color" : "red", "border-color" : "red" } );
	 		return;
	 	}

	 	// Create lowercase vlaues with no spaces for HTML markup
	 	vendorTypeSafe = vendorType.replace(" ", "-").toLowerCase();
	 	vendorNameSafe = vendorName.replace(" ", "-").toLowerCase();

	 	// Count the number of existing vendors are in our table.  This is needed for iteration.
	 	var count = $("tr[class*='vendor-count']").length;

		for (var i = 0; i <= count; i++ ) {

	 		// Create the new HTML
	 		var html = '<tr class="vendor-count" style="display: hidden;"></tr>' +
	 					'<tr id="oe-' + vendorTypeSafe + '-row">' + 
	 						'<td class="oe-left">' +
	 							'<input type="text" name="_oe_saved_vendors[' + i + '][vendor_type]" value="' + vendorType + '" readonly />' +
	 						'</td>' +
	 						'<td>' +
	 							'<input type="text" name="_oe_saved_vendors[' + i + '][vendor_name]" id="oe-' + vendorNameSafe + '" value="' + vendorName + '" readonly />' +
	 						'</td>' +
	 					'</tr>' +
	 					'<tr id="oe-' + vendorTypeSafe + '-del-row">' +
	 						'<td class="oe-left">' +
	 							'<div class="oe-submit">' +
	 								'<input type="button" value="Delete" name="oe-del-button" id="oe-del-button" class="button button-small" ' +
	 									'remove_row="#oe-' + vendorTypeSafe + '-row:#oe-' + vendorTypeSafe + '-del-row"/>' +
	 							'</div>' +
	 						'</td>' +
	 						'<td>' +
	 							'<input type="text" name="_oe_saved_vendors[' + i + '][vendor_url]" id="oe-' + vendorUrl + '" value="' + vendorUrl + '" readonly />' +
	 						'</td>' +
	 					'</tr>';
	 		}

	 	// Append html to the DOM
	 	$( '#oe-current-vendors-table tbody' ).append(html);

	 	// Change visibility of table element
	 	$( '#oe-current-vendors-table ').show();

	 	// Reset
	 	$( '#oe-vendor-type-select' ).val("#NONE#");
	 	$( '#oe-vendor-name' ).val('');
	 	$( '#oe-vendor-url' ).val('');

	 });

	/**
	 * Function used to delete a vendor from the list. Items in the same two <tr> 
	 * elements as the button  will be removed.
	 *
	 * jQuery note - Using .on() because delete buttons are dynamically generated.
	 * 
	 * @package One Eleven Wedding Photography Customization
	 * @subpackage includes/admin
	 * @since 1.0.0
	 */
	$( 'tbody' ).on( "click", '#oe-del-button', function() {
		
		// Retreive the id of the rows to delete
		var delRowId = $( this ).attr( 'remove_row' );

		// Iterate over rows and delete
		var delRows = delRowId.split(":");
		$.each( delRows, function( index, value ) {
			$( value ).remove();
		});

	});

	/**
	 * Very basic form validation
	 */
	function validateUserInput( $input ) {

		var input = $input;

		// Check string for #NONE# indicating no vendor type selected
		if( input === '#NONE#' ) {
			return false;
		}

		// Check for empty or null values
		if( !input.trim() ) {
			return false;
		}
		
		return true;
	}

	/**
	 * This function will reset any error decoration
	 * on the vendor type select field.
	 */
	 $( '#oe-vendor-type-select' ).focusin( function() {
	 	$(this).css( {"color" : "", "border-color" : "" });
	 });

	 /**
	 * This function will reset any error decoration
	 * on the vendor name text field.
	 */
	 $( '#oe-vendor-name' ).focusin( function() {
	 	$(this).css( {"color" : "", "border-color" : "" });
	 });

	 /**
	 * This function will reset any error decoration
	 * on the vendor url text field.
	 */
	 $( '#oe-vendor-url' ).focusin( function() {
	 	$(this).css( {"color" : "", "border-color" : "" });
	 });

	 /**
	 * This function will perform validation at the time of
	 * the user clicking off of the vendor type select box.
	 */
	 $( '#oe-vendor-type-select' ).focusout( function() {
	 	var valid = false;
	 	var input = $.trim( $( '#oe-vendor-type-select' ).val() );

	 	// Validate Vendor Type
	 	valid = validateUserInput( input );
	 	if( valid === false ) {
	 		$( '#oe-vendor-type-select' ).css( {"color" : "red", "border-color" : "red" } );
	 	}

	 });

	 /**
	 * This function will perform validation at the time of
	 * the user clicking off of the vendor name text box.
	 */
	 $( '#oe-vendor-name' ).focusout( function() {
	 	var valid = false;
	 	var input = $.trim( $( '#oe-vendor-name' ).val() );

	 	valid = validateUserInput( input );
	 	if( valid === false ) {
	 		$( '#oe-vendor-name' ).css( {"color" : "red", "border-color" : "red" } );
	 	}	 	
	 });

	 /**
	 * This function will perform validation at the time of
	 * the user clicking off of the vendor url text box.
	 */
	 $( '#oe-vendor-url' ).focusout( function() {
	 	var valid = false;
	 	var input = $.trim( $( '#oe-vendor-url' ).val() );

	 	valid = validateUserInput( input );
	 	if( valid === false ) {
	 		$( '#oe-vendor-url' ).css( {"color" : "red", "border-color" : "red" } );
	 	}	 	
	 });

});