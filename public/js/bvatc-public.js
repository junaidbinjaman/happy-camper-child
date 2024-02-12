(function ($) {
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

  $(document).ready(function () {
    $('.bvatc-color-selector-option').on('click', function () {
      $('.bvatc-color-selector-option').removeClass(
        'bvatc-color-selector-option-selected'
      );
      $(this).addClass('bvatc-color-selector-option-selected');
    });

    $('.bvatc-product-add-to-cart').on('click', function () {
      bvatc_userSelection($);
    });
  });
})(jQuery);

function bvatc_addToCartHandler($, productID, quantity = 1) {
  $.ajax({
    type: 'POST',
    url: window.bvatc_ajaxurl,
    data: {
      action: 'bvatc_foobar',
      productID: productID,
      quantity: quantity,
    },
    success: function (response) {
      response = JSON.parse(response);
      console.log(response);
    },
    error: function (xhr, status, error) {
      console.log(error);
    },
  });
}

function bvatc_userSelection($) {
  const termID = $('.bvatc-color-selector-option-selected').data('term-id');
  const products = []; // contains product and and qty

  $('.bvatc-size-selector-input-boxes').each(function () {
    let productID = $(this).find('span').data('product-id');
    let quantity = $(this).find('input').val();
    quantity = Number(quantity);

    if (quantity >= 1) {
      products.push({id: productID, qty: quantity});
    }
  });

  $.ajax({
    type: 'POST',
    url: window.bvatc_ajaxurl,
    data: {
      action: 'bvatc_variation_id_generator',
      products: products,
      term_id: termID,
    },
    success: function (response) {
      response = JSON.parse(response);
      handleAddToCart($, response)
    },
    error: function (xhr, status, error) {
      console.log(error);
    },
  });

  function handleAddToCart($, response) {
    console.log(response);
    for (let i = 0; i <= response.length; i++) {
      const product = response[i];
      bvatc_addToCartHandler($, product.variation_id, product.qty);
    }
  }
}
