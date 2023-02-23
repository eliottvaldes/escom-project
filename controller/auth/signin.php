<?php

/**
 * Function to sign in a user using the email and password
 *
 * @param string $email
 * @param string $password
 * @return string $tkn
 */
function signInUser(string $email, string $password): string
{
    # require the db-conn.php file to connect to the database
    require_once($_SERVER['DOCUMENT_ROOT'] . '/escom-project/model/db-conn.php');
    # connect to the database
    $pdo = connectToDB();

    // Preparar la consulta SQL para obtener el usuario
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");

    // Ejecutar la consulta SQL y obtener el resultado
    if (!$stmt->execute([$email])) {
        throw new Exception("Error al buscar el usuario en la base de datos.");
    }

    // Obtener el usuario
    $user = $stmt->fetch();

    // Verificar si el usuario existe y está activo
    if (!$user || $user['status'] != 1) {
        throw new Exception("Usuario bloqueado - contacta al administrador.");
    }

    // Verificar si la contraseña es correcta
    if (!password_verify($password, $user['password'])) {
        throw new Exception("Credenciales inválidas.");
    }

    # call the function to generate a tkn and return it
    require_once($_SERVER['DOCUMENT_ROOT'] . '/escom-project/controller/auth/generate-tkn.php');
    return generateTkn($user['id_user']) ?? null;
}


// # test the function
// $email = 'eli_val@example.com22';
// $password ='lalaland'; # correct password
// $password ='lalaland2'; # incorrect password

// try {
//     $tkn = signInUser($email, $password);
//     echo $tkn;
// } catch (Exception $e) {
//     echo $e->getMessage();
// }