<?php

function createUser(string $username, string $email, string $password)
{
    # require the db-conn.php file to connect to the database
    require_once($_SERVER['DOCUMENT_ROOT'] . '/escom-project/model/db-conn.php');

    # connect to the database
    $pdo = connectToDB();

    // Verificar si el usuario o el correo electrónico ya existen
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM user WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    $count = $stmt->fetchColumn();
    if ($count > 0) {
        throw new PDOException("El username o email ya se encuentra registrado.");
    }

    // Cifrar la contraseña
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insertar el nuevo usuario
    $stmt = $pdo->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
    try {
        $result = $stmt->execute([$username, $email, $hashedPassword]);
        if (!$result || $stmt->rowCount() == 0) {
            throw new PDOException("Error al registrar al usuario.");
        }
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        throw new Exception("Error al registrar al usuario: " . $e->getMessage());
    }
}



# test the function to validate the response after implementing the function in api\v1\users\create.php
// echo "<pre><br>";
// try {
//     $newUserId = createUser("eliot_valdes2", "eliot_valdes2@example.com", "mypassword");
//     echo "El nuevo usuario se ha registrado con el ID $newUserId.";
// } catch (Exception $e) {
//     echo $e->getMessage();
// }
