<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://junaidbinjaman.com
 * @since             1.0.0
 * @package           Learn_Plugin_Dev
 *
 * @wordpress-plugin
 * Plugin Name:       Lear Plugin Dev
 * Plugin URI:        https://junaidbinjaman.com
 * Description:       This plugin is developed learning purpose. I have already learned how to send authenticated post request to wp rest apis from wordpress. so now I will revise that concept again.
 * Version:           1.0.0
 * Author:            Junaid Bin Jaman
 * Author URI:        https://junaidbinjaman.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       learn-plugin-dev
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'LEARN_PLUGIN_DEV_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-learn-plugin-dev-activator.php
 */
function activate_learn_plugin_dev() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-learn-plugin-dev-activator.php';
	Learn_Plugin_Dev_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-learn-plugin-dev-deactivator.php
 */
function deactivate_learn_plugin_dev() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-learn-plugin-dev-deactivator.php';
	Learn_Plugin_Dev_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_learn_plugin_dev' );
register_deactivation_hook( __FILE__, 'deactivate_learn_plugin_dev' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-learn-plugin-dev.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_learn_plugin_dev() {

	$plugin = new Learn_Plugin_Dev();
	$plugin->run();

}
run_learn_plugin_dev();


/**
 * calling user activity admin menu class
 */
require plugin_dir_path(__FILE__) . 'admin/partials/class-admin-menu-page.php';

/**
 * Enqueuing react js file from built folder
 */


 add_action( 'admin_enqueue_scripts', 'jobplace_admin_enqueue_scripts' );

 function jobplace_admin_enqueue_scripts() {
		 // Enqueue the CSS file
		 wp_enqueue_style( 'jobplace-style', plugin_dir_url( __FILE__ ) . 'build/index.css' );
 
		 // Enqueue the JavaScript file with dependencies
		 wp_enqueue_script( 'jobplace-script', plugin_dir_url( __FILE__ ) . 'build/index.js', array( 'wp-element', 'jquery' ), wp_rand(), true );
 
		 // Localize the script with data
		 wp_localize_script( 'jobplace-script', 'jobplace_script_data', [
					'apiUrl' => home_url('/wp-json'),
				 	'nonce' => wp_create_nonce('wp_rest')
		 ]);
 }
 