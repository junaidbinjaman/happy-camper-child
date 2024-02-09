<?php
/**
 * Codestar framework configuration file.
 *
 * @link       https://junaidbinjaman.com
 * @since      1.0.0
 *
 * @package    Bvatc
 * @subpackage Bvatc/includes
 */

// Control core classes for avoid errors.
if ( class_exists( 'CSF' ) ) {

	//
	// Set a unique slug-like ID.
	$prefix = 'my_post_options';

	//
	// Create a metabox.
	CSF::createMetabox(
		$prefix,
		array(
			'title'              => 'Bulk variation options',
			'post_type'          => 'bulkvariation',
			'data_type'          => 'serialize',
			'context'            => 'advanced',
			'priority'           => 'default',
			'exclude_post_types' => array(),
			'page_templates'     => '',
			'post_formats'       => '',
			'show_restore'       => false,
			'enqueue_webfont'    => true,
			'async_webfont'      => false,
			'output_css'         => true,
			'nav'                => 'normal',
			'theme'              => 'light',
			'class'              => '',
		)
	);

	//
	// Create a section.
	CSF::createSection(
		$prefix,
		array(
			'title'  => '',
			'fields' => array(

				// Select with AJAX search Pages.
				array(
					'id'          => 'bvatc-product-selector',
					'type'        => 'select',
					'title'       => 'Select a product',
					'placeholder' => 'No product selected',
					'chosen'      => true,
					'ajax'        => true,
					'options'     => 'posts',
					'query_args'  => array(
						'post_type' => 'product',
					),
				),

				array(
					'id'           => 'bvatc-color-selector',
					'type'         => 'group',
					'title'        => 'Colors',
					'button_title' => 'Add a New Color',
					'fields'       => array(
						array(
							'id'    => 'bvatc-color-name',
							'type'  => 'text',
							'title' => 'Color Name',
							'desc'  => 'PLEASE NOTE: Color name must match with woocommerce product attribute name',
						),
						array(
							'id'    => 'bvatc-color-code',
							'type'  => 'color',
							'title' => 'Color Code',
						),
					),
					'default'      => array(
						array(
							'bvatc-color-name' => 'Default color',
							'bvatc-color-code' => '#d1d1d1',
						),
					),
				),

				array(
					'id'           => 'bvatc-color-selector',
					'type'         => 'group',
					'title'        => 'Sizes',
					'button_title' => 'Add a New Size',
					'fields'       => array(
						array(
							'id'    => 'bvatc-size-name',
							'type'  => 'text',
							'title' => 'Size Name',
							'desc'  => 'PLEASE NOTE: Size name must match with woocommerce product attribute name',
						),
					),
					'default'      => array(
						array(
							'bvatc-size-name' => 'Default size',
						),
					),
				),

			),
		)
	);

}
