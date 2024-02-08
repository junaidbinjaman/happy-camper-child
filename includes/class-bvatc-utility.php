<?php
/**
 * This file contains all the utility function used across the plugin
 *
 * @link       https://junaidbinjaman.com
 * @since      1.0.0
 *
 * @package    Bvatc
 * @subpackage Bvatc/includes
 */

/**
 * Utility function wrapper class.
 *
 * This class defines all the utility functions necessary to run the plugin.
 *
 * @since      1.0.0
 * @package    Bvatc
 * @subpackage Bvatc/includes
 * @author     Junaid Bin Jaman <me@junaidbinjaman.com>
 */
class Bvatc_Utility {

	/**
	 * Add product to cart
	 *
	 * The function accepts product id and quantity.
	 * Then add the product to cart if the parameters are valid.
	 *
	 * @since    1.0.0
	 *
	 * @param number $product_id The product ID.
	 * @param number $quantity The product ID.
	 * @return array
	 */
	public static function add_to_cart( $product_id, $quantity = 1 ) {
		$product_id = intval( $product_id );
		$quantity   = intval( $quantity );

		if ( ! is_numeric( $product_id ) ) {
			return array(
				'status'      => 'error',
				'status_code' => 500,
				'message'     => 'Invalid product id',
			);
		}

		if ( ! is_numeric( $quantity ) ) {
			return array(
				'status'      => 'error',
				'status_code' => 500,
				'message'     => 'Invalid quantity',
			);
		}

		$cart    = wc()->cart;
		$product = wc_get_product( $product_id );

		if ( ! $product ) {
			return array(
				'status'      => 'error',
				'status_code' => 500,
				'message'     => 'Product not found',
			);
		}

		if ( $product->get_stock_status() !== 'instock' ) {
			return array(
				'status'      => 'error',
				'status_code' => 500,
				'message'     => 'Product out of stock',
			);
		}

		$result = $cart->add_to_cart( $product_id, $quantity );

		if ( $result ) {
			return array(
				'status'        => 'success',
				'status_code'   => 200,
				'message'       => 'Product added to cart successfully',
				'cart_item_key' => $result,
			);
		}

		return array(
			'status'      => 'error',
			'status_code' => 500,
			'message'     => 'Failed to add product to cart',
		);
	}
}
