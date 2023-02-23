<?php

/**
 * This file contains the code to create a simple endpoint to sign in a user
 * - method: POST
 * - params: email, password
 * - response: json -> {ok: true, msg: 'Successful signin', tkn: $tkn}
 */

$res = [
    'ok' => false
];

//  verify the method of the request
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    $res['msg'] = 'Method not allowed';
    echo json_encode($res);
    exit;
}

# verify the params of the request exist
if (!isset($_POST['email']) || !isset($_POST['password'])) {
    header('HTTP/1.1 400 Bad Request');
    $res['msg'] = 'Bad request - missing params';
    echo json_encode($res);
    exit;
}

# get the params of the request and filter them from html tags and spaces
$email = trim(htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8'));
$password = trim(htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8'));

# validate the params
if (empty($email) || empty($password)) {
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

## AQUI YA PASO TODAS LAS VALIDACIONES -> TIPO MIDDLEWARES

# REQUIRE THE CONTROLLER FILE TO SIGN IN A USER -> we can use relative or full path
# RELATIVE PATH
require_once '../../../controller/auth/signin.php';

# execute the function to sign in a user -> the function return a tkn if the user is found and the password is correct
try {
    $user = signInUser($email, $password);
    # return the array of users in json format to be consumed by the client app    
    $res = [
        'ok' => true,
        'msg' => 'Sign in successful',
        'tkn' => $user
    ];
    echo json_encode($res);
    exit;
} catch (Exception $e) {
    header('HTTP/1.1 400 Bad Request');
    $res['msg'] = $e->getMessage();
    echo json_encode($res);
    exit;
}

