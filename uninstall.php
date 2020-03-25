<?php
// If uninstall not called from WordPress, then exit.
if (! defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

require __DIR__ . '/vendor/autoload.php';

$PluginActivator = new Rasta\UserFetcher\Activator()->deactivate;
