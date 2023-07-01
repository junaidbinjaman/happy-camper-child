<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://junaidbinjaman.com
 * @since      1.0.0
 *
 * @package    Learn_Plugin_Dev
 * @subpackage Learn_Plugin_Dev/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Learn_Plugin_Dev
 * @subpackage Learn_Plugin_Dev/includes
 * @author     Junaid Bin Jaman <me@junaidbinjaman.com>
 */
class Learn_Plugin_Dev_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'learn-plugin-dev',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
