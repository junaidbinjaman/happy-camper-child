(function( $ ) {
	'use strict';

	window.bvatc_ajaxurl = wp_ajax_object.ajax_url;
	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );

function bvatc_addToCartHandler($, productID, quantity = 1, callback) {
    $.ajax({
        type: 'POST',
        url: window.bvatc_ajaxurl,
        data: {
            action: 'bvatc_foobar',
            productID: productID,
            quantity: quantity
        },
        success: function(response) {
            response = JSON.parse(response);
            callback(null, response);
        },
        error: function(xhr, status, error) {
            callback(error, null);
        }
    });
}

bvatc_addToCartHandler($, productID, quantity, function(error, response) {
    if (error) {
        console.error('Error:', error);
    } else {
        console.log('Response:', response);
    }
});

