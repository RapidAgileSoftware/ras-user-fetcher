<?php

/**
 * @link              rasta.online
 * @since             1.0.0
 * @package           Ras_User_Fetcher
 *
 * @wordpress-plugin
 * Plugin Name:       RasUserFetcher
 * Plugin URI:        rasta.online
 * Description:       this plugin creates a custom user fetcher endpoint to retrieve external user data
 * Version:           1.0.0
 * Author:            Jens Krause
 * Author URI:        rasta.online
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'RAS_USER_FETCHER_VERSION', '1.0.0' );
define( 'RAS_USER_FETCHER_ENDPOINT', 'rastapasta');
define( 'RAS_USER_FETCHER_PAGETITLE', 'Users table');
define( 'RAS_USER_FETCHER_SNIPPET', '<div id="ras-user-fetcher"></div>');

require_once plugin_dir_path( __FILE__ ) . 'includes/class-ras-user-fetcher-activator.php';

$PluginActivator = new Ras_User_Fetcher_Activator();

register_activation_hook( __FILE__, [$PluginActivator, 'activate'] );
register_deactivation_hook( __FILE__, [$PluginActivator, 'deactivate'] );
add_action('wp_enqueue_scripts', [$PluginActivator, 'load_scripts']);


