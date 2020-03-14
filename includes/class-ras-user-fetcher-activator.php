<?php

/**
 * Fired during plugin activation
 *
 * @link       rasta.online
 * @since      1.0.0
 *
 * @package    Ras_User_Fetcher
 * @subpackage Ras_User_Fetcher/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Ras_User_Fetcher
 * @subpackage Ras_User_Fetcher/includes
 * @author     Jens Krause <jens@rasta.online>
 */
class Ras_User_Fetcher_Activator {

	/**
	 * runs once while plugin activation
	 * adds rewrite endpoint
	 * flushes rewrite rules
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		register_activation_hook(__FILE__, self::create_uf_page());
		add_rewrite_endpoint( 'rastapasta', EP_ROOT  );
        flush_rewrite_rules();
	}

	/**
	 * runs on plugin deactivation
	 * to remove rewrite endpoint flush rewrite rules
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		flush_rewrite_rules();
	}

	protected function create_uf_page()
    {
    	$post_details = [
			'post_title'    => 'User Fetcher',
  			'post_content'  => 'include my funky code here',
  			'post_status'   => 'publish',
  			'post_author'   => 1,
  			'post_type' => 'page'
    	];

   		wp_insert_post( $post_details );
    }


}
