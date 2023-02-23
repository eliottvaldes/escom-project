<?php

/**
 * This file contains the code to create a simple endpoint to create a user in db
 * - method: POST
 * - params:
 *    - username: string
 *    - email: string 
 *    - password: string
 * - response: json
 */

 # define the response array used to return the response to the client app
$res= [
    'ok' => false,
    'msg' => '',
];

//  verify the method of the request
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');    
    $res['msg'] = 'Method not allowed';
    echo json_encode($res);    
    exit;
}


# verify the params of the request exist
if (!isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['password'])) {
    header('HTTP/1.1 400 Bad Request');
    $res['msg'] = 'Bad request - missing params';
    echo json_encode($res);    
    exit;
}

# get the params of the request and filter them from html tags and spaces
$username = trim(htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8'));
$email = trim(htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8'));
$password = trim(htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8'));

# validate the params
if (empty($username) || empty($email) || empty($password)) {    
    header('HTTP/1.1 400 Bad Request');
    $res['msg'] = 'Bad request - empty params';
    echo json_encode($res);
    exit;
}

# validate email is a real email and has the correct format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('HTTP/1.1 400 Bad Request');
    $res['msg'] = 'Bad request - invalid email';
    echo json_encode($res);
    exit;
}



# REQUIRE THE CONTROLLER FILE TO GET ALL USERS -> we can use relative or full path
# RELATIVE PATH
require_once '../../../controller/users/create.php';
# FULL PATH
// require_once($_SERVER['DOCUMENT_ROOT'] . '/escom-project/controller/users/create');

# execute the function to get all users -> the function returns an array of users
try {
    $lastID = createUser($username, $email, $password);
    # return the array of users in json format to be consumed by the client app 
    header('HTTP/1.1 201 Created');
    $res = [
        'ok' => true,
        'msg' => 'User created successfully',
        'lastID' => $lastID
    ];
    echo json_encode($res);
    exit;
} catch (Exception $e) {
    header('HTTP/1.1 400 Bad Request');
    $res['msg'] = $e->getMessage();
    echo json_encode($res);
    exit;
}
