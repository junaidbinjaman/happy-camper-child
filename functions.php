<?php
/**
 * Register all actions and filters for the plugin
 *
 * @link       https://junaidbinjaman.com
 * @since      1.0.0
 *
 * @package    Scew
 * @subpackage Scew/includes
 *
 * * phpcs:disabled
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( ! function_exists( 'chld_thm_cfg_locale_css' ) ) :
	function chld_thm_cfg_locale_css( $uri ) {
		if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) ) {
			$uri = get_template_directory_uri() . '/rtl.css';
		}
		return $uri;
	}
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );


function child_theme_configurator_scripts() {
	wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'astra-theme-css', 'woocommerce-layout', 'woocommerce-smallscreen', 'woocommerce-general' ) );
	wp_enqueue_script( 'chld_thm_cfg_child_scripts', get_theme_file_uri() . '/scripts.js', array( 'jquery' ), '1.0.0', true );
}

add_action( 'wp_enqueue_scripts', 'child_theme_configurator_scripts', 10 );

// END ENQUEUE PARENT ACTION
//

function happy_camper_url_mood_parameter__callback() {
	if ( isset( $_GET['mood'] ) ) {
		return sanitize_text_field( $_GET['mood'] );
	}
	return false;
}

function init_short_code() {
	add_shortcode( 'happy_camper_url_mood_parameter', 'happy_camper_url_mood_parameter__callback' );
}

add_action( 'init', 'init_short_code' );

function shorten_woo_product_title( $title, $id ) {
	if ( get_post_type( $id ) === 'product' ) {
		if ( ! is_single() ) {
			return wp_trim_words( $title, 2 );
		} else {
			return $title;
		}
	} else {
		return $title;
	}
}

add_filter( 'the_title', 'shorten_woo_product_title', 10, 2 );

// Add this code to your theme's functions.php file or a custom plugin

function get_cart_count() {
	if ( WC()->cart ) {
		return WC()->cart->get_cart_contents_count();
	}
	return '0'; // Return '0' when there is no item in the cart or if WC()->cart is not available
}

// Register the shortcode in WordPress
add_shortcode( 'cart_count', 'get_cart_count_shortcode' );
function get_cart_count_shortcode() {
	return get_cart_count();
}

function greenhouse_color() {
	add_shortcode( 'get_greenhouse_title_color', 'get_greenhouse_title_color__callback' );
	add_shortcode( 'get_greenhouse_title', 'get_greenhouse_title__callback' );
}

function get_greenhouse_title_color__callback() {
	$product_id = get_the_ID();
	$terms    = get_the_terms( $product_id, 'product_cat' );
	$reserved   = '#1d1e19';
	$exotic     = '#919090';
	$premium    = '#607fa4';
	$house      = '#e8cb00';

    foreach( $terms as $term ) {
        $term_id = $term->term_id;
        switch ( $term_id ) {
            case '103':
                echo $reserved;
                break;
            case '104':
                echo $exotic;
                break;
            case 105:
                echo $premium;
                break;
            case 106:
                echo $house;
                break;
        }
    }
}


function get_greenhouse_title__callback() {
	$product_id = get_the_ID();
	$terms    = get_the_terms( $product_id, 'product_cat' );

    foreach( $terms as $term ) {
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

add_action( 'init', 'greenhouse_color' );
