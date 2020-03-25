<?php
namespace Rasta\UserFetcher;

class Api
{
    public $cacheTime;
    public $fetchUrl;
    public $transientPrefix = 'RASTA_USER_';
    // Dependency Handler class
    protected $handler;

    public function __construct($caching = null, $fetch_url = null, $handler = null)
    {
        $this->setCacheTime($caching)
            ->setFetchUrl($fetch_url)
            ->setHandler($handler);
    }

    public function setCacheTime($time)
    {
        $this->cacheTime = $time;
        
        return $this;
    }

    public function getCacheTime():int
    {
        if (!isset($this->cacheTime) || !is_int($this->cacheTime)) {
            $this->cacheTime = 3600;
        }
        
        return $this->cacheTime;
    }

    public function getFetchUrl():string
    {
        if (!isset($this->fetchUrl)) {
             $this->fetchUrl = 'https://jsonplaceholder.typicode.com/users';
        }

        return $this->fetchUrl;
    }

    public function setFetchUrl(?string $fetchUrl):self
    {
        $this->fetchUrl = $fetchUrl;

        return $this;
    }

    public function getHandler():string
    {
        if (!isset($this->handler)) {
             $this->handler = 'Rasta\UserFetcher\Handler';
        }

        return $this->handler;
    }

    public function setHandler(?string $handler):self
    {
        $this->handler = $handler;

        return $this;
    }


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

    public static function okResponse($data)
    {
        return json_encode(['Result' => 'OK', 'Records' => $data]);
    }

    public static function errorResponse(string $message):string
    {
        return json_encode(['Result' => 'Error', 'Message' => $message]);
    }
}
