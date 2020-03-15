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

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'RAS_USER_FETCHER_VERSION', '1.0.0' );
define( 'RAS_USER_FETCHER_ENDPOINT', 'rastapasta_lecker');

require_once plugin_dir_path( __FILE__ ) . 'includes/class-ras-user-fetcher-activator.php';

$PluginActivator = new Ras_User_Fetcher_Activator(RAS_USER_FETCHER_ENDPOINT);

register_activation_hook( __FILE__, [$PluginActivator, 'activate'] );
register_deactivation_hook( __FILE__, [$PluginActivator, 'deactivate'] );

/**
 * Begins execution of the plugin.
 * @since    1.0.0
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ras-user-fetcher-server.php';
$PluginServer = new Ras_User_Fetcher_Server();
$PluginServer->run();


//require plugin_dir_path( __FILE__ ) . 'includes/class-ras-user-fetcher.php';
//$userFetcher = new Ras_User_Fetcher(RAS_USER_FETCHER_ENDPOINT);
//$userFetcher->run();
