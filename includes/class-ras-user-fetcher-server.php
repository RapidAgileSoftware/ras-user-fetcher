<?php

/**
 * A class definition that includes attributes and functions used on the
 * public-facing side of the site
 *
 * @link       rasta.online
 * @since      1.0.0
 *
 * @package    Ras_User_Fetcher
 * @subpackage Ras_User_Fetcher/includes
 */


class Ras_User_Fetcher_Server {

	protected $endpoint;

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
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {

		return $this->plugin_name ?? 'ras-user-fetcher';
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

    public function load_scripts()
    {
    	global $post;

    	//if( is_page() && $post->post_name === $this->get_endpoint() )
    	if(true)
    	{
    		$plugin_path=plugin_dir_url( __FILE__ ) .'../public/';

    		wp_enqueue_script( $this->plugin_name, $plugin_path . 'js/ras-user-fetcher.js', ['jquery'], $this->version, false );
    	}


    }

    public function run(){
    	add_action('wp_enqueue_scripts', [$this,'load_scripts']);
    }



}
