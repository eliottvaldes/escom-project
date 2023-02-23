<?php

/**
 * This file contains the code to create a simple endpoint to get all users from db
 * - method: GET
 * - params: none
 * - content-type: application/json
 * - response: json
 */

//  verify the method of the request
if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    header('HTTP/1.1 405 Method Not Allowed');
    exit;
}

# REQUIRE THE CONTROLLER FILE TO GET ALL USERS -> we can use relative or full path
# RELATIVE PATH
require_once '../../../controller/users/get-all.php';
# FULL PATH
// require_once($_SERVER['DOCUMENT_ROOT'] . '/escom-project/controller/users/get-all.php');

# execute the function to get all users -> the function returns an array of users
try {
    $users = getAllUsers();    
    # return the array of users in json format to be consumed by the client app    
    echo json_encode([
        'ok' => true,
        'msg' => 'Users found',
        'users' => $users
    ]);
    exit;
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode([
        'ok' => false,
        'msg' => $e->getMessage()
    ]);
    exit;
}




?>