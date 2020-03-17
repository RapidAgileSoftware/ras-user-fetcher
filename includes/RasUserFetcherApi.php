<?php

class RasUserFetcherApi {

    protected $user_request;

 	public static function fetchUserRequest() {
    	$url = 'https://jsonplaceholder.typicode.com/users';
        $status = "OK";
        $output= [];
        $records= self::fetch($url);
    
    	if(!$records) {
            $status = 'ERROR';
            $output['Message'] = "Sorry, we couldn't connect to the user server";
    	}
        else{
            $output['Records'] = $records;    
        }
        $output['Result'] = $status;
        
    	return json_encode($output);
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

	public function listUserData(){

 		if(!isset($this->user_request)){
 			$this->user_request = self::fetchUserRequest();
 		} 
        print $this->user_request;
 		
 	}

}

$action = $_GET['action']?? false;

if($action=='list-users'){
	$api=new RasUserFetcherApi();
	$api->listUserData();
	die();
}