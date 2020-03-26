<?php
namespace Rasta\UserFetcher;

/**
 * the Api class is responsible for all action while Plugin is active
 * mostly serves the ajax requests
 * formating the output in the expected way 
 */
class Api
{
    /**
     * time to cache fetched results in seconds
     * @var int
     */
    public $cacheTime;
    /**
     * uri we are getting data from
     * @var string
     */
    public $fetchUrl;
    /**
     * Dependency Handler class name
     * Dependency handlers offer an abstraction level for
     * direct interactions with the host system (wp) or other dependencies (curl)
     * using this approach allows us two main benefits:
     * - we just need to mock this static class for testing, the rest is supposed to be system agnostic
     * - we can replace even critical modules if the environment requires (no curl available)
     * @var string
     */
    protected $handler;
    /**
     * to avoids conflics with other plugings: prefix transients names
     * @var string
     */
    public $transientPrefix = 'RASTA_USER_';

    /**
     * constructor
     * all parameters are optional
     * @param int $caching   time to cache fetched results in seconds
     * @param string $fetch_url uri we are getting data from
     * @param string $handler  name of dependecy handler class
     */
    public function __construct($caching = null, $fetch_url = null, $handler = null)
    {
        $this->setCacheTime($caching)
            ->setFetchUrl($fetch_url)
            ->setHandler($handler);
    }

    /**
     * @param ?int Time in seconds befor fetch cache expires
     * [default] 3600 = 1h
     * @return self
     */
    public function setCacheTime($time):self
    {
        $this->cacheTime = $time;
        
        return $this;
    }

    /**
     * validates if time is set and in the correct form
     * @return int cache exiration time
     */
    public function getCacheTime():int
    {
        if (!isset($this->cacheTime) || !is_int($this->cacheTime)) {
            $this->cacheTime = 3600;
        }
        
        return $this->cacheTime;
    }

    /**
     * @return string Url to fetch data
     */
    public function getFetchUrl():string
    {
        if (!isset($this->fetchUrl)) {
             $this->fetchUrl = 'https://jsonplaceholder.typicode.com/users';
        }

        return $this->fetchUrl;
    }

    /**
     * @param string Url to fetch data
     * @return self
     */
    public function setFetchUrl(?string $fetchUrl):self
    {
        $this->fetchUrl = $fetchUrl;

        return $this;
    }

    /**
     * getter handler propert
     * @return string name of dependency handler class
     */
    public function getHandler():string
    {
        if (!isset($this->handler)) {
             $this->handler = 'Rasta\UserFetcher\Handler';
        }

        return $this->handler;
    }

    /**
     * @param string Name of the static Handler class
     * @return self
     */
    public function setHandler(?string $handler):self
    {
        $this->handler = $handler;

        return $this;
    }

    /**
     * fetches all users from the given url
     * hooked to admin_ajax
     * renders the Api output expected by jTable
     * @return void
     */
    public function fetchUserRequest()
    {
        $users = $this->getHandler()::fetch($this->getFetchUrl(), $this->getCacheTime());

        if (!$users) {
            print self::errorResponse("Sorry, we couldn't connect to the users data server. Please scream in anger now.");
        }
        else {
            print self::okResponse($users);
        }
        die();
    }
    
    /**
     * fetches users details
     * expects user id as GET parameter or renders error result
     * @return void
     */
    public function fetchUserDetails()
    {
        $id = intval($_GET['id']);
        if ($id > 0) {
            $records = $this->getHandler()::fetch($this->getFetchUrl() . '/' . $id, $this->getCacheTime());

            if ($records) {
                print self::okResponse([$records]);
                die();
            }
        }
        print self::errorResponse("Sorry, we couldn't fetch the Users details");
        die();
    }

    /**
     * fetches a users posts
     * expects user id as GET parameter or renders error result
     * @return void
     */
    public function fetchUserPosts()
    {
        $id = intval($_GET['id']);
        if ($id > 0) {
            $records = $this->getHandler()::fetch($this->getFetchUrl() . '/' . $id . '/posts', $this->getCacheTime());

            if ($records) {
                print self::okResponse($records);
                die();
            }
        }
        print self::errorResponse("Sorry, we couldn't fetch the Users posts");
        die();
    }

    /**
     * fetches a users albums
     * expects user id as GET parameter or renders error result
     * @return void
     */
    public function fetchUserAlbums()
    {
        $id = intval($_GET['id']);
        if ($id > 0) {
            $records = $this->getHandler()::fetch($this->getFetchUrl() . '/' . $id . '/albums', $this->getCacheTime());

            if ($records) {
                 print self::okResponse($records);
                 die();
            }
        }
        print self::errorResponse("Sorry, we couldn't fetch the Users albums");
        die();
    }

    /**
     * fetches a users todos
     * expects user id as GET parameter or renders error result
     * @return void
     */
    public function fetchUserTodos()
    {
        $id = intval($_GET['id']);

        if ($id > 0) {
            $records = $this->getHandler()::fetch($this->getFetchUrl() . '/' . $id . '/todos', $this->getCacheTime());
            if ($records) {
                print self::okResponse($records);
                die();
            }
        }
        print self::errorResponse("Sorry, we couldn't fetch the Users ToDos");
        die();
    }

    /**
     * renders data into the exopected format
     * @param  mixed $data
     * @return string json encoded ok response
     */
    public static function okResponse($data)
    {
        return json_encode(['Result' => 'OK', 'Records' => $data]);
    }

    /**
     * renders error message into the exopected format
     * @param  string message
     * @return string json encoded error response
     */
    public static function errorResponse(string $message):string
    {
        return json_encode(['Result' => 'Error', 'Message' => $message]);
    }
}
