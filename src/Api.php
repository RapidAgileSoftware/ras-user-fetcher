<?php
namespace Rasta\UserFetcher;

class Api
{
    public $fetchUrl = 'https://jsonplaceholder.typicode.com/users';
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


    public function fetchUserRequest():string
    {
        $records = $this->getHandler()::fetch($this->fetchUrl);

        if (!$records) {
            return self::errorResponse("Sorry, we couldn't connect to the user data server. Please scream in anger now.");
        }
        else {
            return json_encode(['Result' => 'OK', 'Records' => $records]);
        }
    }

    public function fetchUserDetails(int $id):string
    {
        $records = $this->getHandler()::fetch($this->fetchUrl . '/' . $id);

        if (!$records) {
            return self::errorResponse("Sorry, we couldn't fetch the Users details");
        }
        else {
            return json_encode(['Result' => 'OK', 'Records' => [$records]]);
        }
    }

    public function fetchUserPosts(int $id):string
    {
        $records = $this->getHandler()::fetch($this->fetchUrl . '/' . $id . '/posts');

        if (!$records) {
            return self::errorResponse("Sorry, we couldn't fetch the Users posts");
        }
        else {
            return json_encode(['Result' => 'OK', 'Records' => $records]);
        }
    }

    public function fetchUserAlbums(int $id):string
    {
        $records = $this->getHandler()::fetch($this->fetchUrl . '/' . $id . '/albums');

        if (!$records) {
            return self::errorResponse("Sorry, we couldn't fetch the Users albums");
        }
        else {
            return json_encode(['Result' => 'OK', 'Records' => $records]);
        }
    }

    public function fetchUserTodos(int $id):string
    {
        $records = $this->getHandler()::fetch($this->fetchUrl . '/' . $id . '/todos');

        if (!$records) {
            return self::errorResponse("Sorry, we couldn't fetch the Users ToDos");
        }
        else {
            return json_encode(['Result' => 'OK', 'Records' => $records]);
        }
    }

    public static function errorResponse(string $message):string
    {
        return json_encode(['Result' => 'Error', 'Message' => $message]);
    }
}
