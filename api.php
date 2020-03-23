<?php

require __DIR__ . '/vendor/autoload.php';

$action = $_GET['action'] ?? false;

if ($action) {
    $Api = new Rasta\UserFetcher\Api();

    if ($action == 'list-users') {
        print $Api->fetchUserRequest();
    }
    else {
        // these actions require a valid integer user-id
        $user_id = intval($_GET['id']) ?? 0;
        if ($user_id > 0) {
            // api stuff
            switch ($action) {
                case 'user-details':
                    print $Api->fetchUserDetails($user_id);
                    break;
                case 'user-posts':
                    print $Api->fetchUserPosts($user_id);
                    break;
                case 'user-todos':
                     print $Api->fetchUserTodos($user_id);
                    break;
                case 'user-albums':
                     print $Api->fetchUserAlbums($user_id);
                    break;
                default:
                    //requested action not recognised
                    print Rasta\UserFetcher\Api::errorResponse("Sorry, you can't do that.");
                    break;
            }
        }
        else {
            // user id is invalid
            print Rasta\UserFetcher\Api::errorResponse('Sorry, this user-id is invalid');
        }
        //
    }
}
