<?php

function getAllUsers(): array
{
    # require the db-conn.php file to connect to the database
    require_once($_SERVER['DOCUMENT_ROOT'] . '/escom-project/model/db-conn.php');

    # connect to the database
    $pdo = connectToDB();

    # craete a query to get all users from the database
    $stmt = $pdo->query("SELECT * FROM user WHERE status = 1");

    try {
        # fetch all users from the database
        $users = $stmt->fetchAll();
        return $users ?? [];
    } catch (PDOException $e) {
        throw new Exception("Error al obtener los usuarios: " . $e->getMessage());
    }
}


// # test the function to validate the response after implementing the function in api\v1\users\get-all.php
// echo "<pre><br>";
// try {
//     $users = getAllUsers();
//     print_r($users);
// } catch (Exception $e) {
//     echo $e->getMessage();
// }
