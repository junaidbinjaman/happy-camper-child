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
		fileatime( get_stylesheet_directory() . '/style.css' ),
		'all'
	);

	wp_enqueue_script(
		'chld_thm_cfg_child_scripts',
		get_theme_file_uri() . '/scripts.js',
		array( 'jquery' ),
		fileatime( get_stylesheet_directory() . '/scripts.js' ),
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
	add_shortcode( 'is_user_logged_in', 'is_user_logged_in__callback' );
	add_shortcode( 'selected_mood_products', 'selected_mood_products__callback' );
}

add_action( 'init', 'init_short_code' );

/**
 * Returns mood URL parameter
 *
 * @return mixed
 */
function happy_camper_url_mood_parameter__callback() {
	$url     = '/product-category/bodega/?jsf=jet-engine&tax=feeling:';
	$mood    = isset( $_GET['mood'] ) ? sanitize_text_field( wp_unslash( $_GET['mood'] ) ) : 'happy';
	$feeling = array(
		'happy'    => 125,
		'creative' => 126,
		'relaxed'  => 127,
		'aroused'  => 129,
		'soothed'  => 128,
	);

	return $url . $feeling[ strtolower( $mood ) ];
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
				echo 'Reserve';
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

	return wp_trim_words( $title, 6 );
}

add_filter( 'the_title', 'shorten_woo_product_title', 10, 2 );

/**
 * Removes dashboard and download menu.
 *
 * @param array $menu the menu listing.
 * @return array
 */
function edit_woocommerce_account_menu_items( $menu ) {
	$menu = array(
		'orders'          => __( 'Orders', 'astra' ),
		'edit-address'    => __( 'Address', 'astra' ),
		'edit-account'    => __( 'Account Details', 'astra' ),
		'customer-logout' => __( 'Logout', 'astra' ),
	);

	return $menu;
}

add_filter( 'woocommerce_account_menu_items', 'edit_woocommerce_account_menu_items' );

/**
 * The function skips the account dashboard and redirects to order listing tab
 *
 * @param Object $wp The wp object.
 * @return void
 */
function skip_customer_dashboard( $wp ) {
	if ( is_admin() ) {
		return;
	}

	if ( 'my-account' === $wp->request ) {
		wp_safe_redirect( site_url( 'my-account/orders' ) );
		exit;
	}
}

add_action( 'parse_request', 'skip_customer_dashboard' );

/**
 * The function rephrase the "Lost your password?" text
 *
 * @param string $translated_text The translated text.
 * @param string $text The text to replace.
 * @param string $domain The text domain.
 * @return string
 */
function change_lost_your_password_text( $translated_text, $text, $domain ) {
	if ( 'Lost your password?' === $text && 'woocommerce' === $domain ) {
		$translated_text = 'Forgot your password?';
	}

	return $translated_text;
}

add_filter( 'gettext', 'change_lost_your_password_text', 20, 3 );

/**
 * The shortcode callback that returns My account
 * if the current user is logged in. Otherwise, it returns Log In
 *
 * @return void
 */
function is_user_logged_in__callback() {
	if ( is_user_logged_in() ) {
		echo 'My Account';
		return;
	}

	echo 'Log In';
	return; //phpcs:ignore
}

/**
 * Undocumented function
 *
 * @return void
 */
function selected_mood_products__callback() {
	$selected_mood = isset( $_GET['mood'] ) ? sanitize_text_field( wp_unslash( $_GET['mood'] ) ) : 'happy'; // phpcs:ignore

	$all_options = get_option( 'options', array() );
	$meta_key    = "select-product-for-mood-selector-{$selected_mood}-section";

	$products_in_the_mood = isset( $all_options[ $meta_key ] ) ? $all_options[ $meta_key ] : false;

	if ( ! $products_in_the_mood ) {
		echo 0;
		return;
	}

	echo esc_html( implode( ',', $products_in_the_mood ) );
}


/**
 * Handle Password length
 *
 * @param array  $params Param.
 * @param string $handle Handler.
 * @return array
 */
function pwd_strength_meter_settings( $params, $handle ) {

	if ( 'wc-password-strength-meter' === $handle ) {

		$params = array_merge(
			$params,
			array(

				'min_password_strength' => 2,
				'i18n_password_error'   => 'Do not you want to be protected? Make it stronger!',
				'i18n_password_hint'    => ' Please make your password <strong>at least 8 characters</strong> long , For more security use a mix of <strong>UPPER</strong> and <strong>lowercase</strong> letters, <strong>numbers</strong>, and <strong>symbols</strong>',
			)
		);

	}
	return $params;
}

add_filter( 'woocommerce_get_script_data', 'pwd_strength_meter_settings', 20, 2 );

/**
 * The function creates a new custom tab on single product page besides description
 * to display the additional information in it
 *
 * @param array $tabs The array contains the current tab data.
 * @return array
 */
function custom_additional_tab_on_single_product_page( $tabs ) {
	$tabs['custom_tab'] = array(
		'title'    => __( 'Additional Info', 'hc_child' ),
		'priority' => '20',
		'callback' => 'populate_custom_additional_tab_data',
	);

	return $tabs;
}

/**
 * The callback to populate the data inside additional info tab
 *
 * @return void
 */
function populate_custom_additional_tab_data() {
	echo do_shortcode( '[elementor-template id="3573"]' );
}

add_filter( 'woocommerce_product_tabs', 'custom_additional_tab_on_single_product_page' );

add_filter( 'wc_product_has_unique_sku', '__return_false' );
