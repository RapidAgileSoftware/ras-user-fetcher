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


    public function fetchUserRequest():string
    {
        $handler = $this->getHandler();
        $transient = $this->transientPrefix.'LIST';

        // caching, do we already got this request in the transients?
        var_dump($handler::test());
        
        //$users = $handler::getTransient($transient);
        $user = get_transient('Rasta');
        var_dump('pasta');
        var_dump($users);
        // no, we need to fetch it
        if ($users === false) {
            $users = $handler::fetch($this->fetchUrl);
            // if we got them successful, write them to our cache
            if ($users) {
                // for now let's expire in one hour
                $handler::setTransient($transient, $users, 3600);
            }
        }

        if (!$users) {
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
