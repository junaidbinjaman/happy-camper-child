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
 * @package           Bvatc
 *
 * @wordpress-plugin
 * Plugin Name:       WC Bulk Variation Add To Cart
 * Plugin URI:        https://https://https://github.com/junaidbinjaman/wc-bulk-variation-add-to-cart
 * Description:       WC Bulk Variation Add to Cart" is a powerful WooCommerce plugin designed to streamline the shopping experience for both customers and store owners. With intuitive features, it allows users to effortlessly add multiple product variations to their cart in bulk, saving time and effort. By seamlessly integrating with WooCommerce, this plugin enhances product customization options, simplifies inventory management, and boosts conversion rates, ultimately enhancing the overall e-commerce experience
 * Version:           1.0.0
 * Author:            Junaid Bin Jaman
 * Author URI:        https://junaidbinjaman.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bvatc
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 */
define( 'BVATC_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bvatc-activator.php
 */
function activate_bvatc() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bvatc-activator.php';
	Bvatc_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bvatc-deactivator.php
 */
function deactivate_bvatc() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bvatc-deactivator.php';
	Bvatc_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_bvatc' );
register_deactivation_hook( __FILE__, 'deactivate_bvatc' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-bvatc.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_bvatc() {

	$plugin = new Bvatc();
	$plugin->run();
}
run_bvatc();

/**
 * Define the third-party libs and frameworks
 */

require_once plugin_dir_path( __FILE__ ) . 'includes/bvatc-tgm-config.php';
require_once plugin_dir_path( __FILE__ ) . 'libs/codestar-framework/codestar-framework.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/bvatc-codestar-config.php';


// phpcs:disable

require plugin_dir_path( __FILE__ ) . 'includes/class-bvatc-utility.php';

function bvatc_foobar() {
	$product_id = $_POST['productID'] ? $_POST['productID'] : 0;
	$quantity = $_POST['quantity'] ? $_POST['quantity'] : 0;

	$utility = new Bvatc_Utility();
	$result = $utility->add_to_cart( $product_id, $quantity );

	echo wp_json_encode( $result );
	wp_die();
}

add_action( 'wp_ajax_bvatc_foobar', 'bvatc_foobar' );
