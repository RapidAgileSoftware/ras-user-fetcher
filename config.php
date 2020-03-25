<?php

$config = [
    'Caching Time' => 3600,
    'Endpoint' => 'ras-user-fetcher',
    'Fetch Url' => 'https://jsonplaceholder.typicode.com/users',
    'Page Title' => 'Users Table',
];

if (file_exists('config.local.php')) {
    include 'config.local.php';
}
