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
if (! defined('WPINC')) {
    die;
}
require __DIR__ . '/vendor/autoload.php';

define('RAS_USER_FETCHER_VERSION', '1.0.0');


$PluginActivator = new Rasta\UserFetcher\Activator();

register_activation_hook(__FILE__, [$PluginActivator, 'activate']);
register_deactivation_hook(__FILE__, [$PluginActivator, 'deactivate']);
add_action('wp_enqueue_scripts', [$PluginActivator, 'loadScripts']);
