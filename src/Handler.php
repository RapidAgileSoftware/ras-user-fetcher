<?php
namespace Rasta\UserFetcher;

/**
 * This class holds all direct actions with wordpress which need mocking
 * for the unit tests
 */
class Handler
{

    /**
     * @param  string $fetch_url url to retrieve data
     * @return array|bool fetched data or false on failure
     */
    protected static function fetch(string $fetch_url)
    {
        // reusable curl based fetch function
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $fetch_url);
        $result = curl_exec($ch);
        curl_close($ch);

        return ($result === false) ? false : json_decode($result);
    }

    /**
     * returns array if page exists, null otherwise
     * @param  string $page_path path to the page
     * @return array|null
     */
    public static function getPageByPath(string $page_path): ?array
    {
        // we want to get associative array back
        return get_page_by_path($page_path, ARRAY_A);
    }

    /**
     * Get the filesystem directory path (with trailing slash) for the plugin __FILE__ passed in
     * @param  string
     * @return string
     */
    public static function pluginDirPath(string $file):string
    {
        return plugin_dir_path($file);
    }

    /**
     * deletes a wordpress post
     * @param  int id of the
     * @return bool success status
     */
    public static function deletePost(int $post_id):bool
    {
        $result = wp_delete_post($post_id);

        return ($result === false) ? false : true;
    }

    /**
     * enqueues a list of scripts into wordpress
     * it need to have the form:
     * $script_list = [
     *     ['handle'=> 'my_script_handle', 'src'=>'my_first.js'],
     *     ['handle'=> 'my_other_script_handle', 'src'=>'my_second.js']
     * ]
     * @param  array $script_list
     * @param bool $jquery_dependend : do these scripts need jquery?
     * @return void
     */
    public static function enqueueScripts(array $script_list, bool $jquery_dependend = true):void
    {
        $dependencies = ($jquery_dependend) ? ['jquery'] : [];

        foreach ($script_list as $script) {
            wp_enqueue_script($script['handle'], $script['src'], $dependencies);
        }
    }

    /**
     * inserts/updates a post with wordpress
     * @param  array properties of the new post
     * @return [int] id of created post, 0 on failure
     */
    public static function insertPost(array $post_config):int
    {
        // insert current user id
        $post_config['post_author'] = get_current_user_id();
        // enforce int as return value
        return intval(wp_insert_post($post_config));
    }

    /**
     * used to pass php data into javascript
     * @param  string
     * @param  string
     * @param  array
     * @return void
     */
    public static function localizeScript(string $handle, string $var_name, array $l10n):void
    {
        wp_localize_script($handle, $var_name, $l10n);
    }

    /**
     * cache buster for wp posts
     * @return void
     */
    public static function resetPostData():void
    {
        wp_reset_postdata();
    }
}
