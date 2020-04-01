<?php

/**
 * @link              rasta.online
 * @since             1.0.0
 * @package           WP Demo Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Wordpress Demo Plugin
 * Plugin URI:        https://github.com/RapidAgileSoftware/wp-demo-plugin
 * Description:       This demo plugin uses a jTable extension to retrieve external user data
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

// make sure we dont include outoload twice (wp-config)
require_once(__DIR__ . '/vendor/autoload.php');

define('__version__', '1.0.0');

// make the Pluging configurable via config.local.php
require_once('config.php');

/**
 * Plugin Activator
 * is responsible for getting the Plugin up and running
 * or shutting it down in a clean way
 **/

$PluginActivator = new Rasta\UserFetcher\Activator($config['Endpoint'], $config['Page Title']);

register_activation_hook(__FILE__, [$PluginActivator, 'activate']);
register_deactivation_hook(__FILE__, [$PluginActivator, 'deactivate']);
add_action('wp_enqueue_scripts', [$PluginActivator, 'loadScripts']);

/**
 * Plugin Api
 * manages the Plugins needs while active
 * contains all fetch data requests
 **/

$PluginApi = new Rasta\UserFetcher\Api($config['Caching Time'], $config['Fetch Url']);
//add_action('wp_ajax_nopriv_list-users', [$PluginApi, 'fetchUserRequest']);
add_action('wp_ajax_list-users', [$PluginApi, 'fetchUserRequest']);
add_action('wp_ajax_user-details', [$PluginApi, 'fetchUserDetails']);
add_action('wp_ajax_user-posts', [$PluginApi, 'fetchUserPosts']);
add_action('wp_ajax_user-todos', [$PluginApi, 'fetchUserTodos']);
add_action('wp_ajax_user-albums', [$PluginApi, 'fetchUserAlbums']);

// let's expose it to public users too
add_action('wp_ajax_nopriv_list-users', [$PluginApi, 'fetchUserRequest']);
add_action('wp_ajax_nopriv_user-details', [$PluginApi, 'fetchUserDetails']);
add_action('wp_ajax_nopriv_user-posts', [$PluginApi, 'fetchUserPosts']);
add_action('wp_ajax_nopriv_user-todos', [$PluginApi, 'fetchUserTodos']);
add_action('wp_ajax_nopriv_user-albums', [$PluginApi, 'fetchUserAlbums']);
