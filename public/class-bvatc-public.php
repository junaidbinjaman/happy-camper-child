<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://junaidbinjaman.com
 * @since      1.0.0
 *
 * @package    Bvatc
 * @subpackage Bvatc/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Bvatc
 * @subpackage Bvatc/public
 * @author     Junaid Bin Jaman <me@junaidbinjaman.com>
 */
class Bvatc_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bvatc_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bvatc_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bvatc-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bvatc_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bvatc_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/bvatc-public.js', array( 'jquery' ), $this->version, false );

		wp_localize_script( $this->plugin_name, 'wp_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}

	/**
	 * Create custom post types.
	 *
	 * @since    1.0.0
	 */
	public function create_cpt() {

		// Bulk variation product add to cart cpt.
		$labels = array(
			'name'                  => _x( 'Bulk Variations', 'Post Type General Name', 'bvatc' ),
			'singular_name'         => _x( 'Bulk Variation', 'Post Type Singular Name', 'bvatc' ),
			'menu_name'             => _x( 'Bulk Variations', 'Admin Menu text', 'bvatc' ),
			'name_admin_bar'        => _x( 'Bulk Variation', 'Add New on Toolbar', 'bvatc' ),
			'archives'              => __( 'Bulk Variation Archives', 'bvatc' ),
			'attributes'            => __( 'Bulk Variation Attributes', 'bvatc' ),
			'parent_item_colon'     => __( 'Parent Bulk Variation:', 'bvatc' ),
			'all_items'             => __( 'All Bulk Variations', 'bvatc' ),
			'add_new_item'          => __( 'Add New Bulk Variation', 'bvatc' ),
			'add_new'               => __( 'Add New', 'bvatc' ),
			'new_item'              => __( 'New Bulk Variation', 'bvatc' ),
			'edit_item'             => __( 'Edit Bulk Variation', 'bvatc' ),
			'update_item'           => __( 'Update Bulk Variation', 'bvatc' ),
			'view_item'             => __( 'View Bulk Variation', 'bvatc' ),
			'view_items'            => __( 'View Bulk Variations', 'bvatc' ),
			'search_items'          => __( 'Search Bulk Variation', 'bvatc' ),
			'not_found'             => __( 'Not found', 'bvatc' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'bvatc' ),
			'featured_image'        => __( 'Featured Image', 'bvatc' ),
			'set_featured_image'    => __( 'Set featured image', 'bvatc' ),
			'remove_featured_image' => __( 'Remove featured image', 'bvatc' ),
			'use_featured_image'    => __( 'Use as featured image', 'bvatc' ),
			'insert_into_item'      => __( 'Insert into Bulk Variation', 'bvatc' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Bulk Variation', 'bvatc' ),
			'items_list'            => __( 'Bulk Variations list', 'bvatc' ),
			'items_list_navigation' => __( 'Bulk Variations list navigation', 'bvatc' ),
			'filter_items_list'     => __( 'Filter Bulk Variations list', 'bvatc' ),
		);
		$args   = array(
			'label'               => __( 'Bulk Variation', 'bvatc' ),
			'description'         => __( 'Product bulk variation add to cart', 'bvatc' ),
			'labels'              => $labels,
			'menu_icon'           => 'dashicons-products',
			'supports'            => array( 'title', 'revisions', 'author', 'page-attributes', 'post-formats', 'thumbnail' ),
			'taxonomies'          => array(),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'hierarchical'        => false,
			'exclude_from_search' => false,
			'show_in_rest'        => true,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
		);
		register_post_type( 'bulkvariation', $args );
	}

	/**
	 * Handle the visibility of single bulk variation
	 *
	 * @param mixed $template single post template path.
	 * @return string
	 */
	public function single_bulk_variation_handler( $template ) {
		global $post;
		$template = plugin_dir_path( __DIR__ ) . 'public/partials/single-bulk-variation.php';

		if ( isset( $post->post_type ) && 'bulkvariation' === $post->post_type ) {
			return $template;
		}
	}
}
