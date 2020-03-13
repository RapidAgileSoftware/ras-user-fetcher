<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       rasta.online
 * @since      1.0.0
 *
 * @package    Ras_User_Fetcher
 * @subpackage Ras_User_Fetcher/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ras_User_Fetcher
 * @subpackage Ras_User_Fetcher/public
 * @author     Jens Krause <jens@rasta.online>
 */
class Ras_User_Fetcher_Public {

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

	protected $endpoint = 'rastapasta';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

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
		 * defined in Ras_User_Fetcher_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ras_User_Fetcher_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ras-user-fetcher-public.css', array(), $this->version, 'all' );

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
		 * defined in Ras_User_Fetcher_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ras_User_Fetcher_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ras-user-fetcher-public.js', ['jquery'], $this->version, false );

	}

	public function change_template( $template ) {

	  	global $wp_query;
		var_dump($wp_query->query_vars);

        if( get_query_var( 'rastapasta' , false ) !== false ) {

            //Check plugin directory next
            $newTemplate = plugin_dir_path( __FILE__ ) . 'partials/ras-user-fetcher-public.php';
            if( file_exists( $newTemplate ) )
                return $newTemplate;

        }
        //Fall back to original template
        return $template;

    }

    public function get_endpoint(){

    	return $this->endpoint;
    }

}
