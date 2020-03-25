<?php
// If uninstall not called from WordPress, then exit.
if (! defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// make sure we dont include outoload twice (wp-config)
require_once(__DIR__ . '/vendor/autoload.php');

$PluginActivator = new Rasta\UserFetcher\Activator();
$PluginActivator->deactivate();
