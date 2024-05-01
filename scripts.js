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
    happyCamperAgeChecker();
    storeEligibilityData($);
    searchToolTipHandler($);

    if (window.innerWidth >= 1024) {
      productFilterToggleHandler($);
    }

    var btnText =
      'Add To Cart <span class="dashicons dashicons-arrow-right-alt"></span>';
    $('.single_add_to_cart_button').html(btnText);
  });

  $(document).on('elementor/popup/show', function (event, id, instance) {
    // Run the function for mobile filter
    if (id === 2281) {
      // Greenhouse filter
      productFilterToggleHandler($);
    }

    if (id === 2633) {
      // Product filter
      productFilterToggleHandler($);
    }
  });
})(jQuery);

function getCookie(name) {
  let cookieArray = document.cookie.split(';');
  for (let i = 0; i < cookieArray.length; i++) {
    let cookiePair = cookieArray[i].trim();
    if (cookiePair.startsWith(name + '=')) {
      cookiePair = cookiePair.substring(name.length + 1);
      return cookiePair.slice(0, -1);
    }
  }
  return null;
}

function handleMegaMenuVisibility($) {
  let megaMenuContainer = $('.mega-menu-container');

  megaMenuContainer.hide();

  $('.menu-item-2749').on('mouseenter', function () {
    megaMenuContainer.show();
  });

  megaMenuContainer
    .on('mouseenter', function () {
      megaMenuContainer.show();
    })
    .on('mouseleave', function () {
      megaMenuContainer.hide();
    });

  $('.main-navbar').on('mouseleave', function () {
    megaMenuContainer.hide();
  });
}

function mobileMegaMenuHandler($) {
  const megaMenuClasses = [
    'greenhouse',
    'bodega',
    'spa',
    'vapes',
    'cannabinoid',
    'feeling',
  ];

  for (let i = 0; i < megaMenuClasses.length; i++) {
    const menuClass = megaMenuClasses[i];

    $(document).on('elementor/popup/show', function (event, popupData) {
      if (popupData === 817) {
        onPopupOpen(menuClass);
      }
    });
  }

  function onPopupOpen(menuClass) {
    $(`.mobile-mega-menu-${menuClass}`).hide();
    $(`.mobile-mega-menu-${menuClass}-btn`).on('click', function () {
      $('.mobile-mega-menu').hide();
      $(`.mobile-mega-menu-${menuClass}`).show();
    });

    $(`.mobile-mega-menu-${menuClass}-back-btn`).on('click', function () {
      $(`.mobile-mega-menu-${menuClass}`).hide();
      $('.mobile-mega-menu').show();
    });
  }
}

function moodSelectorHandler($) {
  $('.mood-selector-btn').on('click', function () {
    let selectedMood = $(this).attr('data-mood');
    localStorage.setItem('selectedModeOnHomePage', selectedMood);
  });

  let selectedMood = localStorage.getItem('selectedModeOnHomePage');

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

function happyCamperAgeChecker() {
  let isEligible = getCookie('isEligible');
  let path = location.pathname;

  if (isEligible) {
    let currentURL = sessionStorage.getItem('currentURL');
    sessionStorage.removeItem('currentURL');
    currentURL && (location.href = currentURL);
    return;
  }

  if (path !== '/age-check/' && path !== '/page-for-under-21/') {
    sessionStorage.setItem('currentURL', location.href);
    location.href = '/age-check/';
  }
}

function storeEligibilityData($) {
  $('.happy-camper-eligible-customer-btn').on('click', function () {
    document.cookie = 'isEligible=true; path=/; samesite=strict';
  });
}

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

function productFilterToggleHandler($) {
  var filterCLassNamePrefix = ['tier', 'cannabinoid', 'vibe'];

  for (let i = 0; i < filterCLassNamePrefix.length; i++) {
    const prefix = filterCLassNamePrefix[i];

    $(`.${prefix}-filter`)
      .find('.product-filter-head ul > li:nth-child(1)')
      .toggle();

    $(`.${prefix}-filter .product-filter-head`).on('click', function () {
      $(this).find('ul > li:nth-child(1)').toggle();
      $(this).find('ul > li:nth-child(2)').toggle();

      $(`.${prefix}-filter .product-filter-body`).toggle();
    });
  }
}
