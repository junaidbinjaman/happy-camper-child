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

	/**
	 * Finds a variation id based on term id.
	 *
	 * @param array   $products associative array contains product id and qty.
	 * @param integer $term_id return id.
	 * @return array;
	 */
	public function variation_finder( $products, $term_id = null ) {
		if ( ! empty( $product ) ) {
			return array(
				'status'  => 'error',
				'message' => 'invalid products',
			);
		}

		if ( ! $term_id ) {
			return array(
				'status'  => 'error',
				'message' => 'invalid products',
			);
		}

		$variations = array();

		foreach ( $products as $product ) {
			$product_id   = $product['id'];
			$product_qty  = $product['qty'];
			$variation_id = $this->get_variation_id_by_term( $product_id, $term_id );

			if ( $variation_id ) {
				array_push(
					$variations,
					array(
						'product_id'   => $product_id,
						'variation_id' => $variation_id,
						'qty'          => $product_qty,
					)
				);
			}
		}

		return $variations;
	}

	/**
	 * Undocumented function
	 *
	 * @param integer $product_id the id of the main product.
	 * @param integer $term_id the term id.
	 * @return mixed
	 */
	private function get_variation_id_by_term( $product_id, $term_id ) {
		$product = wc_get_product( $product_id );

		if ( ! $product || ! $product->is_type( 'variable' ) ) {
			return false;
		}

		foreach ( $product->get_children() as $variation_id ) {
			$variation  = wc_get_product( $variation_id );
			$attributes = $variation->get_attributes();

			$term_ids = array();

			foreach ( $attributes as $attribute ) {
				$term = get_term_by( 'slug', $attribute, 'pa_color' );

				if ( $term ) {
					array_push( $term_ids, $term->term_id );
				}
			}

			// Check if the term ID is in the term IDs array for this variation.
			if ( in_array( $term_id, $term_ids ) ) {
				return $variation_id; // Return the variation ID if the term ID is found.
			}
		}

		return false; // Return false if no variation is found with the specified term ID.
	}
}
