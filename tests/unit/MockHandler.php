<?php

namespace Rasta\UserFetcher\Tests\Unit;

use Rasta\UserFetcher\Handler as Handler;

class MockHandler extends Handler
{
    /**
    *   mocked page fetch
    *   returns array with page info on the page_path == valid-path
    *   returns null otherwise
    **/
    public static function getPageByPath(string $page_path): ?array
    {
        if ($page_path === 'valid-path') {
            return [
                'id' => 1,
                'title' => 'Valid page title',
                'body' => 'some body text'
            ];
        }
        
        return null;
    }

    /**
    *   mocked insert post
    *   returns 42 for valid-path and 0 otherwise
    **/
    public static function insertPost(array $post_config):int
    {
        return ($post_config['post_name'] === 'invalid-post-path')? 0 : 42;
    }
}
