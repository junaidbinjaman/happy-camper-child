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

		<div class="bvatc-wrapper">
			<div class="bvatc-thumbnail">
				<img class="bvatc-image" src="<?php echo esc_html( get_the_post_thumbnail_url() ); ?>" alt="">
			</div>
			<div class="bvatc-content">
				<h2 class="bvatc-title">
					<?php echo esc_html( get_the_title() ); ?>
				</h2>
				<div class="bvatc-bulk-variation-color-selector">
					<p class="bvatc-color-selector-title">Select a color: </p>
				<?php
				$bvatc_product_meta_colors      = $bvatc_product_meta['bvatc-color-selector'];
				$bvatc_product_meta_color_count = count( $bvatc_product_meta_colors );

				for ( $i = 0; $i < $bvatc_product_meta_color_count; $i++ ) {
					$color = $bvatc_product_meta_colors[ $i ];
					?>
					<p 
					class="bvatc-color-selector-option" 
					style="background: <?php echo esc_html( $color['bvatc-color-code'] ); ?>; color: #fff"
					data-term-id="<?php echo esc_html( $color['bvatc-color-attr-term'] ); ?>"
					>
						<?php echo esc_html( $color['bvatc-color-name'] ); ?>
					</p>
					<?php
				}
				?>
				</div>
				<div class="bvatc-bulk-variation-size-selector">
					<p class="bvatc-size-selector-title">Sizes:</p>
					<div>
					<?php
					$bvatc_product_meta_size       = $bvatc_product_meta['bvatc-size-selector'];
					$bvatc_product_meta_size_count = count( $bvatc_product_meta_size );

					for ( $i = 0; $i < $bvatc_product_meta_size_count; $i++ ) {
						$size = $bvatc_product_meta_size[ $i ];
						?>
						<label class="bvatc-size-selector-input-boxes" for="<?php echo esc_html( $size['bvatc-size-name'] ); ?>">
							<span data-product-id="<?php echo esc_html( $size['bvatc-size-product'] ); ?>"> <?php echo esc_html( $size['bvatc-size-name'] ); ?> </span>
							<br />
							<input type="text" id="<?php echo esc_html( $size['bvatc-size-name'] ); ?>" value="00">
						</label>
						<br />
						<?php
					}
					?>
					</div>
				</div>
				<div class="bvatc-bulk-variation-available-stock">
					<p class="bvatc-available-stock-selector-title">Available stock:</p>
					<div>
					<?php
					$bvatc_product_meta_size       = $bvatc_product_meta['bvatc-size-selector'];
					$bvatc_product_meta_size_count = count( $bvatc_product_meta_size );

					for ( $i = 0; $i < $bvatc_product_meta_size_count; $i++ ) {
						$product = $bvatc_product_meta_size[ $i ];
						$product = wc_get_product( $product['bvatc-size-product'] );
						?>
						<p class="bvatc-available-stock-input-boxes">
							<?php echo esc_html( $product->get_stock_quantity() ); ?>
						</p>
						<?php
					}
					?>
					</div>
				</div>
				<div class="price">
					<p class="bvatc-per-unit-price">
						Per unit price: 
						<b><?php echo esc_html( get_woocommerce_currency_symbol() . $bvatc_product_meta['bvatc_unit_price'] ); ?></b>
					</p>
				</div>
				<div class="action">
					<button class="bvatc-product-add-to-cart">Add to cart</button>
				</div>
			</div>
		</div>
		<?php
endwhile;
endif;

get_footer();
