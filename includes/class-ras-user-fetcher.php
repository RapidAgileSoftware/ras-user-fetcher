<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       rasta.online
 * @since      1.0.0
 *
 * @package    Ras_User_Fetcher
 * @subpackage Ras_User_Fetcher/includes
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
 * @package    Ras_User_Fetcher
 * @subpackage Ras_User_Fetcher/includes
 * @author     Jens Krause <jens@rasta.online>
 */
class Ras_User_Fetcher {

	protected $endpoint;

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Ras_User_Fetcher_Loader    $loader    Maintains and registers all hooks for the plugin.
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
	public function __construct(string $endpoint) {
		$this->endpoint=$endpoint;
		$this->loadDependencies();
		$this->defineHooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Ras_User_Fetcher_Loader. Orchestrates the hooks of the plugin.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function loadDependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ras-user-fetcher-loader.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ras-user-fetcher-public.php';


	}

	/**
	 * Register the hooks of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 */

	protected function defineHooks(){
		$plugin = new Ras_User_Fetcher_Public( $this->get_plugin_name(), $this->get_version() );
		$loader = $this->getLoader();
		$loader->add_action( 'wp_enqueue_scripts', $plugin, 'enqueue_styles' );
		$loader->add_action( 'wp_enqueue_scripts', $plugin, 'enqueue_scripts' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
	    $loader=$this->getLoader();
		$loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {

		return $this->plugin_name ?? 'ras-user-fetcher';
	}


	public function getLoader() {

		if (!isset($this->loader)){
		  $this->setLoader(new Ras_User_Fetcher_Loader());
		}
		return $this->loader;

	}

	/**
	 * Setter fir Loader instance
	 *
	 * @since     1.0.0
	 * @return    instance of Ras_User_Fetcher
	 */
	public function setLoader($loader) {

		$this->loader = $loader;
		return $this;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {

		return $this->version ?? RAS_USER_FETCHER_VERSION ?? '1.0.0';
	}

    public function get_endpoint(){

    	return $this->endpoint ?? RAS_USER_FETCHER_ENDPOINT ?? 'ras-user-fetcher';
    }



}
