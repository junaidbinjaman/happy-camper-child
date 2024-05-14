(function ($) {
  'use strict';

  /**
   * All of the code for public-facing JavaScript source
   * should reside in this file.
   *
   * This enables to define handlers, for when the DOM is ready:
   */

  $(function () {
    handleMegaMenuVisibility($);
    mobileMegaMenuHandler($);
    moodSelectorHandler($);
    // happyCamperAgeChecker();
    storeEligibilityData($);
    searchToolTipHandler($);

    if (window.innerWidth >= 1024) {
      productFilterToggleHandler($);
    }

    // Change the add to cart btn text on single product page
    var btnText =
      'Add To Cart <span class="dashicons dashicons-arrow-right-alt"></span>';
    $('.single_add_to_cart_button').html(btnText);
  });

  $(document).on('elementor/popup/show', function (event, id, instance) {
    /**
     * Run productFilterToggleHandler function on mobile
     * when the popup opens on greenhouse page
     */
    if (id === 2281) {
      productFilterToggleHandler($);
    }

    /**
     * Run productFilterToggleHandler function on mobile
     * when the popup opens on all the shop page other than greenhouse
     */
    if (id === 2633) {
      productFilterToggleHandler($);
    }
  });
})(jQuery);

/**
 * UTILITY FUNCTIONS
 *
 * This section contains utility functions.
 * These functions do not directly implement any features on the frontend by themselves.
 * Rather, they support other functions by addressing common, smaller-scale problems,
 * thereby facilitating the compvarion of larger tasks.
 */

/**
 * Get the cookie value.
 *
 * The function accepts cookie name as an input
 * and returns the cookie value.
 *
 * @param {string} name cookie name;
 * @returns {string} cookie value
 */
function getCookie(name) {
  var cookieArray = document.cookie.split(';');
  for (var i = 0; i < cookieArray.length; i++) {
    var cookiePair = cookieArray[i].trim();
    if (cookiePair.startsWith(name + '=')) {
      cookiePair = cookiePair.substring(name.length + 1);
      return cookiePair.slice(0, -1);
    }
  }
  return null;
}

/**
 * FEATURE FUNCTIONS
 *
 * This section contains feature functions that are directly responsible for handling specific features on the frontend.
 * These functions implement the core functionality of user-facing elements, managing interactions and
 * ensuring a responsive and dynamic user experience. They often utilize utility functions to handle
 * sub-tasks, allowing for cleaner and more modular code structure.
 */

/**
 * The function toggle the mega menu
 *
 * @param {jQuery} $ jQuery reference
 */
function handleMegaMenuVisibility($) {
  var megaMenuContainer = $('.mega-menu-container');
  var mainNavbar = $('.main-navbar');
  var megaMenuNavItem = $('.menu-item-2749');

  megaMenuContainer.hide();

  megaMenuNavItem.on('mouseenter', function () {
    megaMenuContainer.show();
  });

  megaMenuContainer
    .on('mouseenter', function () {
      megaMenuContainer.show();
    })
    .on('mouseleave', function () {
      megaMenuContainer.hide();
    });

  mainNavbar.on('mouseleave', function () {
    megaMenuContainer.hide();
  });
}

/**
 * The function toggle the mega menu on mobile
 *
 * @param {jQuery} $ jQuery reference
 */
function mobileMegaMenuHandler($) {
  var mobileMegaMenu = 'mobile-mega-menu';
  var megaMenuClasses = [
    'greenhouse',
    'bodega',
    'spa',
    'vapes',
    'cannabinoid',
    'feeling',
  ];

  $(document).on('elementor/popup/show', function (event, id, instance) {
    if (id === 817) {
      for (let i = 0; i < megaMenuClasses.length; i++) {
        const menuClass = megaMenuClasses[i];
        onPopupOpen(menuClass);
      }
    }
  });

  function onPopupOpen(menuClass) {
    console.log(menuClass);
    $(`.${mobileMegaMenu}-${menuClass}`).hide();

    $(`.${mobileMegaMenu}-${menuClass}-btn`).on('click', function () {
      $(`.${mobileMegaMenu}`).hide();
      $(`.${mobileMegaMenu}-${menuClass}`).show();
    });

    $(`.${mobileMegaMenu}-${menuClass}-back-btn`).on('click', function () {
      $(`.${mobileMegaMenu}-${menuClass}`).hide();
      $(`.${mobileMegaMenu}`).show();
    });
  }
}

/**
 * The function handles click events on mood selector btn on the home page
 *
 * @param {jQuery} $ jQuery reference
 */
function moodSelectorHandler($) {
  $('.mood-selector-btn').on('click', function () {
    var selectedMood = $(this).attr('data-mood');
    localStorage.setItem('selectedModeOnHomePage', selectedMood);
  });

  var selectedMood = localStorage.getItem('selectedModeOnHomePage');

  $(`.${selectedMood}-mood-selector-btn`).css({
    'background-color': '#c3c1c0',
    'border-radius': '50px',
  });

  $(`.${selectedMood}-mood-selector-btn img`).css({
    border: '2px solid #005477',
    'border-radius': '100%',
    opacity: '1',
  });
}

/**
 * The function redirects user to age-check page when a users visit the site
 * to ensures, the user is over 21.
 *
 * @returns void
 */
function happyCamperAgeChecker() {
  var isEligible = getCookie('isEligible');
  var path = location.pathname;

  if (isEligible) {
    var currentURL = sessionStorage.getItem('currentURL');
    sessionStorage.removeItem('currentURL');
    currentURL && (location.href = currentURL);
    return;
  }

  if (path !== '/age-check/' && path !== '/page-for-under-21/') {
    sessionStorage.setItem('currentURL', location.href);
    location.href = '/age-check/';
  }
}

/**
 * The function make the user eligible to browse the website 
 * when whe user clicks on the eligible btn
 *
 * @param {jQuery} $ jQuery reference
 */
function storeEligibilityData($) {
  var eligibleCustomerBtn = $('.happy-camper-eligible-customer-btn')

  eligibleCustomerBtn.on('click', function () {
    document.cookie = 'isEligible=true; path=/; samesite=strict';
  });
}

/**
 * The function handles the search container and buttons toggle
 *
 * @param {jQuery} $ jQuery reference
 */
function searchToolTipHandler($) {
  var searchBtn = $('.header-secondary-menu ul > li:nth-child(1)');
  var closeBtn = $('.header-secondary-menu ul > li:nth-child(2)');
  var searchContainer = $('.search-form-container');

  closeBtn.hide();
  searchContainer.hide();

  searchBtn.on('click', toggleVisibility);
  closeBtn.on('click', toggleVisibility);

  function toggleVisibility() {
    searchBtn.toggle();
    closeBtn.toggle();
    searchContainer.toggle();
  }

  $(document).mouseup(function (e) {
    if (
      !searchContainer.is(e.target) &&
      searchContainer.has(e.target).length === 0 &&
      !searchBtn.is(e.target) &&
      searchBtn.has(e.target).length === 0 &&
      !closeBtn.is(e.target) &&
      closeBtn.has(e.target).length === 0
    ) {
      searchBtn.show();
      closeBtn.hide();
      searchContainer.hide();
    }
  });
}

/**
 * The function handles the product filter body toggle
 *
 * When a user clicks on the filter title/label or the icons,
 * it toggles the filter listing 
 *
 * @param {jQuery} $ jQuery reference
 */
function productFilterToggleHandler($) {
  var filterCLassNamePrefix = ['tier', 'cannabinoid', 'vibe'];

  for (let i = 0; i < filterCLassNamePrefix.length; i++) {
    var prefix = filterCLassNamePrefix[i];
    console.log(prefix)

    $(`.${prefix}-filter`)
      .find('.product-filter-head ul > li:nth-child(1)')
      .toggle();

    $(`.${prefix}-filter .product-filter-head`).on('click', function () {
      $(this).find('ul > li:nth-child(1)').toggle();
      $(this).find('ul > li:nth-child(2)').toggle();

      $(this).siblings().toggle();
    });
  }
}

function ageCheckerAjaxHandler($) {
  $.ajax({
    type: 'POST',
    url: wp_ajax.url,
    data: {
      action: 'age_checker_redirects',
      nonce: wp_ajax.nonce
    },
    success: function(res) {
      console.log(res);
    },
    error: function(xhr, status, error) {
      console.log(error);
    }
  })
}
