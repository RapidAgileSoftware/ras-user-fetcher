<?php
namespace Rasta\UserFetcher;

class Api
{
    public $fetchUrl = 'https://jsonplaceholder.typicode.com/users';
    public $transientPrefix = 'RASTA_USER_';
    // Dependency Handler class
    protected $handler;

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
        $users = $this->getHandler()::fetch($this->fetchUrl);

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
            $records = $this->getHandler()::fetch($this->fetchUrl . '/' . $id);

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
            $records = $this->getHandler()::fetch($this->fetchUrl . '/' . $id . '/posts');

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
            $records = $this->getHandler()::fetch($this->fetchUrl . '/' . $id . '/albums');

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
            $records = $this->getHandler()::fetch($this->fetchUrl . '/' . $id . '/todos');
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
