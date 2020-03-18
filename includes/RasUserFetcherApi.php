<?php
define( 'RAS_USER_FETCHER_API_URL', 'https://jsonplaceholder.typicode.com/users');

class RasUserFetcherApi {

    protected $user_request;

 	public static function fetchUserRequest() {
        $records= self::fetch(RAS_USER_FETCHER_API_URL);
    
    	if(!$records) {
            return self::errorResponse("Sorry, we couldn't connect to the user data server. Please scream in anger now.");
    	}
        else{
            return json_encode(['Result'=>"OK", 'Records' => $records]); 
        }
 	}

    public static function fetchUserDetails(int $id) {
        $url = RAS_USER_FETCHER_API_URL.'/'.$id;
        $records= self::fetch($url);
    
        if(!$records) {
            return self::errorResponse("Sorry, we couldn't fetch the Users details");
        }
        else{
            return json_encode(['Result'=>"OK", 'Records' => [$records]]); 
        }
    }

    public static function fetchUserPosts(int $id) {
        $url = RAS_USER_FETCHER_API_URL.'/'.$id.'/posts';
        $records= self::fetch($url);
    
        if(!$records) {
            return self::errorResponse("Sorry, we couldn't fetch the Users posts");
        }
        else{
            return json_encode(['Result'=>"OK", 'Records' => $records]); 
        }
    }

    public static function fetchUserAlbums(int $id) {
        $url = RAS_USER_FETCHER_API_URL.'/'.$id.'/albums';
        $records= self::fetch($url);
    
        if(!$records) {
            return self::errorResponse("Sorry, we couldn't fetch the Users albums");
        }
        else{
            return json_encode(['Result'=>"OK", 'Records' => $records]); 
        }
    }

    public static function fetchUserTodos(int $id) {
        $url = RAS_USER_FETCHER_API_URL.'/'.$id.'/posts';
        $records= self::fetch($url);
    
        if(!$records) {
            return self::errorResponse("Sorry, we couldn't fetch the Users ToDos");
        }
        else{
            return json_encode(['Result'=>"OK", 'Records' => $records]); 
        }
    }

    protected static function fetch(string $fetch_url){
        // reusable curl based fetch function
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $fetch_url);
        $result = curl_exec($ch);
        curl_close($ch);
        return ($result===false)? false : json_decode($result);

    }

    public static function errorResponse(string $message){
        return json_encode(['Result'=>"Error", 'Message' => $message]);
    }

}

$action = $_GET['action']?? false;

if($action)
{
    if($action=='list-users'){
        print RasUserFetcherApi::fetchUserRequest();
    }
    else{
        // these actions require a valid integer user-id
        $user_id = intval($_GET['id']) ?? 0;
        if($user_id>0){
            // api stuff
            switch ($action) {
                case 'user-details':
                print RasUserFetcherApi::fetchUserDetails($user_id);
                break;
            case 'user-posts':
                print RasUserFetcherApi::fetchUserPosts($user_id);
                break;
            case 'user-todos':
                 print RasUserFetcherApi::fetchUserTodos($user_id);
                break;
            case 'user-albums':
                 print RasUserFetcherApi::fetchUserAlbums($user_id);
                break;
            default:
                //requested action not recognised
                print RasUserFetcherApi::errorResponse("Sorry, we can't ".$action.". Something went wrong here");
                break;
            }
        } else {
            // user id is invalid
            print RasUserFetcherApi::errorResponse("Sorry, this user-id is invalid");
        }
        //
    }


}