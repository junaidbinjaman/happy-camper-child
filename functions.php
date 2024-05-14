<?php
/**
 * The main function file of the theme
 *
 * @package    astra
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$theme   = wp_get_theme();
$version = $theme->get( 'Version' );

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below.

if ( ! function_exists( 'chld_thm_cfg_locale_css' ) ) :

	/**
	 * Enqueue parent style.
	 *
	 * @param string $uri the URL.
	 * @return string
	 */
	function chld_thm_cfg_locale_css( $uri ) {
		if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) ) {
			$uri = get_template_directory_uri() . '/rtl.css';
		}
		return $uri;
	}
endif;

add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

/**
 * Enqueue css and js
 *
 * @return void
 */
function child_theme_configurator_scripts() {
	wp_enqueue_style(
		'chld_thm_cfg_child',
		trailingslashit( get_stylesheet_directory_uri() ) . 'style.css',
		array(
			'astra-theme-css',
			'woocommerce-layout',
			'woocommerce-smallscreen',
			'woocommerce-general',
		),
		$GLOBALS['version'],
		'all'
	);

	wp_enqueue_script(
		'chld_thm_cfg_child_scripts',
		get_theme_file_uri() . '/scripts.js',
		array( 'jquery' ),
		'1.0.0',
		true
	);
	wp_localize_script(
		'chld_thm_cfg_child_scripts',
		'wp_ajax',
		array(
			'url'   => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'hc_nonce' ),
		)
	);
}

add_action( 'wp_enqueue_scripts', 'child_theme_configurator_scripts', 10 );

// END ENQUEUE PARENT ACTION.

/**
 * The function inits all the shortcodes
 *
 * @return void
 */
function init_short_code() {
	add_shortcode( 'happy_camper_url_mood_parameter', 'happy_camper_url_mood_parameter__callback' );

	add_shortcode( 'get_greenhouse_title_color', 'get_greenhouse_title_color__callback' );
	add_shortcode( 'get_greenhouse_title', 'get_greenhouse_title__callback' );

	add_shortcode( 'cart_count', 'get_cart_count' );
}

add_action( 'init', 'init_short_code' );

/**
 * Returns mood URL parameter
 *
 * @return mixed
 */
function happy_camper_url_mood_parameter__callback() {
	if ( isset( $_GET['mood'] ) ) { // phpcs:ignore
		return sanitize_text_field( wp_unslash( $_GET['mood'] ) ); // phpcs:ignore
	}
	return false;
}

/**
 * Get color code based on the category assigned to the greenhouse product title
 *
 * The function checks the green house product category
 * and echos the relevant color code.
 *
 * @return void
 */
function get_greenhouse_title_color__callback() {
	$product_id = get_the_ID();
	$terms      = get_the_terms( $product_id, 'product_cat' );
	$reserved   = '#1d1e19';
	$exotic     = '#919090';
	$premium    = '#607fa4';
	$house      = '#e8cb00';

	foreach ( $terms as $term ) {
		$term_id = $term->term_id;
		switch ( $term_id ) {
			case '103':
				echo esc_html( $reserved );
				break;
			case '104':
				echo esc_html( $exotic );
				break;
			case 105:
				echo esc_html( $premium );
				break;
			case 106:
				echo esc_html( $house );
				break;
		}
	}
}

/**
 * Get title based on the category assigned to the greenhouse product title
 *
 * The function checks the green house product category
 * and echos the relevant title.
 *
 * @return void
 */
function get_greenhouse_title__callback() {
	$product_id = get_the_ID();
	$terms      = get_the_terms( $product_id, 'product_cat' );

	foreach ( $terms as $term ) {
		$term_id = $term->term_id;
		switch ( $term_id ) {
			case '103':
				echo 'Reserved';
				break;
			case '104':
				echo 'Exotic';
				break;
			case 105:
				echo 'Premium';
				break;
			case 106:
				echo 'House';
				break;
		}
	}
}

/**
 * Get the cart items total counts
 *
 * @return int
 */
function get_cart_count() {
	if ( WC()->cart ) {
		return WC()->cart->get_cart_contents_count();
	}
	return 0;
}

/**
 * Shorten the woocommerce product title on archive boxes
 *
 * @param string $title The product title.
 * @param int    $id The product id.
 * @return string
 */
function shorten_woo_product_title( $title, $id ) {
	if ( get_post_type( $id ) !== 'product' ) {
		return $title;
	}

	if ( is_singular() ) {
		return $title;
	}

	return wp_trim_words( $title, 3 );
}

add_filter( 'the_title', 'shorten_woo_product_title', 10, 2 );

// phpcs:disable
function foobar($wp) {
	$current_page = $wp->request;

	if ( $current_page === 'age-check' ) {
		return;
	}

	if ( $current_page === 'page-for-under-21' ) {
		return;
	}

	if ( ! isset( $_COOKIE['is_eligible'] ) ) {
		wp_safe_redirect( 'age-check' );
	}
}

add_action( 'parse_request', 'foobar' );

function age_checker_redirects() {
	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'hc_nonce' ) ) {
		wp_die( 'nonce validation failed ' );
		exit;
	}
	setcookie( 'is_eligible', true, 0, '/', );
	exit;
}

add_action( 'wp_ajax_nopriv_age_checker_redirects', 'age_checker_redirects' );
add_action( 'wp_ajax_age_checker_redirects', 'age_checker_redirects' );

add_filter('pre_set_site_transient_update_themes', 'automatic_GitHub_updates', 100, 1);
function automatic_GitHub_updates($data) {
  // Theme information
  $theme   = get_stylesheet(); // Folder name of the current theme
  $current = wp_get_theme()->get('Version'); // Get the version of the current theme
  // GitHub information
  $user = 'junaidbinjaman'; // The GitHub username hosting the repository
  $repo = 'happy-camper-child'; // Repository name as it appears in the URL
  // Get the latest release tag from the repository. The User-Agent header must be sent, as per
  // GitHub's API documentation: https://developer.github.com/v3/#user-agent-required
  $file = @json_decode(@file_get_contents('https://api.github.com/repos/'.$user.'/'.$repo.'/releases/latest', false,
      stream_context_create(['http' => ['header' => "User-Agent: ".$user."\r\n"]])
  ));
  if($file) {
	$update = filter_var($file->tag_name, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    // Only return a response if the new version number is higher than the current version
    if($update > $current) {
  	  $data->response[$theme] = array(
	      'theme'       => $theme,
	      // Strip the version number of any non-alpha characters (excluding the period)
	      // This way you can still use tags like v1.1 or ver1.1 if desired
	      'new_version' => $update,
	      'url'         => 'https://github.com/'.$user.'/'.$repo,
	      'package'     => $file->assets[0]->browser_download_url,
      );
    }
  }
  return $data;
}
