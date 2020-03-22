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
                'ID' => 1,
                'post_title'  => 'Valid Post Title',
                'post_name'   => 'valid-path',
                'post_content' => '<span id="something" />',
                'post_status' => 'publish',
                'post_type'   => 'page'
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
        return ($post_config['post_name'] === 'invalid-post-path') ? 0 : 42;
    }
    /**
    *   mocked delete post
    *   returns false for id 666, true otherwise
    **/
    public static function deletePost(int $post_id):bool
    {
        return (!($post_id === 666)) ? true : false;
    }
    /**
    *   mocked reset post data
    *   does nothing at all
    **/
    public static function resetPostData():void
    {
        // insert funny joke here or do nothing
    }

    public static function enqueueScripts(string $endpoint, array $script_list, bool $jquery_dependend = true):bool
    {
        return ($endpoint === 'valid-path') ? true : false;
    }
}
