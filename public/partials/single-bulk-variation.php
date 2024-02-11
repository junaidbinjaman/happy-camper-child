<?php
/**
 * The single post page of bulk variation.
 *
 * @link       https://junaidbinjaman.com
 * @since      1.0.0
 *
 * @package    Bvatc
 * @subpackage Bvatc/public
 */

get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		$bvatc_product_meta = get_post_meta( get_the_ID(), 'my_post_options', true );
		?>

		<div>
			<img class="bvatc-image" src="<?php echo esc_html( get_the_post_thumbnail_url() ); ?>" alt="">
		</div>
		<div>
			<h2 class="bvatc-title">
				<?php echo esc_html( get_the_title() ); ?>
			</h2>
			<div class="bvatc-bulk-variation-color-selector">
				<p>Select a color: </p>
				<?php
				$bvatc_product_meta_colors      = $bvatc_product_meta['bvatc-color-selector'];
				$bvatc_product_meta_color_count = count( $bvatc_product_meta_colors );

				for ( $i = 0; $i < $bvatc_product_meta_color_count; $i++ ) {
					$color = $bvatc_product_meta_colors[ $i ];
					?>
						<p style="background: <?php echo esc_html( $color['bvatc-color-code'] ); ?>; color: #fff">
							<?php echo esc_html( $color['bvatc-color-name'] ); ?>
						</p>
						<?php
				}
				?>
			</div>
			<div class="bvatc-bulk-variation-size-selector">
				<p>Sizes:</p>
				<?php
				$bvatc_product_meta_size       = $bvatc_product_meta['bvatc-size-selector'];
				$bvatc_product_meta_size_count = count( $bvatc_product_meta_size );

				for ( $i = 0; $i < $bvatc_product_meta_size_count; $i++ ) {
					$size = $bvatc_product_meta_size[ $i ];
					?>
						<label for="<?php echo esc_html( $size['bvatc-size-name'] ); ?>">
							<?php echo esc_html( $size['bvatc-size-name'] ); ?>
							<br />
							<input type="number" id="<?php echo esc_html( $size['bvatc-size-name'] ); ?>">
						</label>
						<br />
						<?php
				}
				?>
			</div>
			<div class="bvatc-bulk-variation-available-stock">
				<p>Available stock:</p>
				<?php
				$bvatc_product_meta_size       = $bvatc_product_meta['bvatc-size-selector'];
				$bvatc_product_meta_size_count = count( $bvatc_product_meta_size );

				for ( $i = 0; $i < $bvatc_product_meta_size_count; $i++ ) {
					$product = $bvatc_product_meta_size[ $i ];
					$product = wc_get_product( $product['bvatc-size-product'] );
					?>
						<p>
							<?php echo esc_html( $product->get_stock_quantity() ); ?>
						</p>
						<?php
				}
				?>
			</div>
			<div class="price">
				<p>
					Per unit price: 
					<?php echo esc_html( get_woocommerce_currency_symbol() . $bvatc_product_meta['bvatc_unit_price'] ); ?>
				</p>

			</div>
			<div class="action">
				<button>Add to cart</button>
			</div>
		</div>
		<?php
endwhile;
endif;

get_footer();
