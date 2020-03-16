<?php

class RasUserFetcherApi {

	protected $request;

 	public static function fetchUserData() {
    	$tree = [];
    	$url = 'https://jsonplaceholder.typicode.com/users';

    	$curl = curl_init();
    	curl_setopt($curl, CURLOPT_URL, $url);
    	curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    	$result = curl_exec($curl);

    
    	if(!$result){
    		die("Connection Failure");
    	}
    	curl_close($curl);
   
    	return $result;
 	}

	public function listUserData(){

 		if(!isset($this->request)){
 			$this->request = self::fetchUserData();
 		} 
 		header('Content-Type: application/json');
 		
 	}

}

$action = $_GET['action']?? false;

if($action=='list-users'){
	$api=new RasUserFetcherApi();
	$api->listUserData();
	die();
}