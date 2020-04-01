<?php

$config = [
    'Caching Time' => 3600,
    'Endpoint' => 'wp-demo-endpoint',
    'Fetch Url' => 'https://jsonplaceholder.typicode.com/users',
    'Page Title' => 'Users Table',
];

if (file_exists('config.local.php')) {
    include 'config.local.php';
}
