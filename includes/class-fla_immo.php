<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://flashsama.me
 * @since      1.0.0
 *
 * @package    Fla_immo
 * @subpackage Fla_immo/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Fla_immo
 * @subpackage Fla_immo/includes
 * @author     salaheddine El Ahoubi <flashsama@gmail.com>
 */
class Fla_immo {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Fla_immo_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'FLA_IMMO_VERSION' ) ) {
			$this->version = FLA_IMMO_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'fla_immo';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Fla_immo_Loader. Orchestrates the hooks of the plugin.
	 * - Fla_immo_i18n. Defines internationalization functionality.
	 * - Fla_immo_Admin. Defines all hooks for the admin area.
	 * - Fla_immo_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-fla_immo-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-fla_immo-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fla_immo-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-fla_immo-public.php';

		$this->loader = new Fla_immo_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Fla_immo_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Fla_immo_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Fla_immo_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		

		//create new user role 'immo manager' 
		$this->loader->add_action( 'init', $plugin_admin, 'fla_immo_add_role' );
		$this->loader->add_action( 'init', $plugin_admin, 'create_agence_immo_post_type' );
		$this->loader->add_action( 'init', $plugin_admin, 'create_annonce_immo_post_type' );
		$this->loader->add_action( 'init', $plugin_admin, 'generate_acf_for_agencies_and_annonces' );
		

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Fla_immo_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		//filter
		$this->loader->add_filter('single_template', $plugin_public, 'fla_immo_single_custom_post_template', 10, 3);
		$this->loader->add_filter('posts_where', $plugin_public, 'fla_immo_title_filter', 10, 2);

		//widgets shortcode
		$this->loader->add_action( 'init', $plugin_public, 'fla_immo_register_shortcodes' );
		//routing
		$this->loader->add_action( 'template_include', $plugin_public, 'fla_immo_routing' );

		//ajax hooks
		$this->loader->add_action( 'wp_ajax_update_annonce_immo', $plugin_public, 'fla_immo_update_annonce_immo' );
		$this->loader->add_action( 'wp_ajax_add_new_annonce_immo', $plugin_public, 'fla_immo_add_new_annonce_immo' );
		$this->loader->add_action( 'wp_ajax_update_agence_immo', $plugin_public, 'fla_immo_update_agence_immo' );
		$this->loader->add_action( 'wp_ajax_delete_offre_immo', $plugin_public, 'fla_immo_delete_offre_immo' );
		$this->loader->add_action( 'wp_ajax_archive_offre_immo', $plugin_public, 'fla_immo_archive_offre_immo' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Fla_immo_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
