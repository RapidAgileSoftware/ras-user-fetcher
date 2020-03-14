<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              rasta.online
 * @since             1.0.0
 * @package           Ras_User_Fetcher
 *
 * @wordpress-plugin
 * Plugin Name:       RasUserFetcher
 * Plugin URI:        rasta.online
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Jens Krause
 * Author URI:        rasta.online
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ras-user-fetcher
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
define( 'RAS_USER_FETCHER_VERSION', '1.0.0' );

require_once plugin_dir_path( __FILE__ ) . 'includes/class-ras-user-fetcher-activator.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ras-user-fetcher-activator.php
 */
function activate_ras_user_fetcher() {
	// register endpoint and flush rewrite rules
	Ras_User_Fetcher_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ras-user-fetcher-activator.php
 */
function deactivate_ras_user_fetcher() {
	// flush rewrite rules
	Ras_User_Fetcher_Activator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ras_user_fetcher' );
register_deactivation_hook( __FILE__, 'deactivate_ras_user_fetcher' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ras-user-fetcher.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

$userFetcher = new Ras_User_Fetcher();
$userFetcher->run();
