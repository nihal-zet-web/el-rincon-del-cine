<?php
//Aquí se recibe la información mandada en el formulario de registro y se comprueba si el nombre de usuario
//está en la base de datos, en caso de estario se avisa al usuario y sino se guarda la información en la base 
//de datos
require_once "conectar_db.php";
$username = isset($_POST['username']) ? $_POST['username'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;

if ($username && $email && $password) {
    try {
        $validateUsernameQuery = "SELECT username FROM users WHERE username = :username";
        $validateUsernameStmt = $pdo->prepare($validateUsernameQuery);
        $validateUsernameStmt->execute([":username" => $username]);
        $user = $validateUsernameStmt->fetchColumn();
        if ($user === $username) {
            echo "existe";
            exit;
        }
        $insertDataQuery = "INSERT INTO users (username, email, user_password) VALUES (:username, :email, :password)";
        $insertDataStmt = $pdo->prepare($insertDataQuery);
        $insertDataStmt->execute([":username" => $username, ":email" => $email, ":password" => password_hash($password)]);
        session_start();
        $_SESSION['username'] = $username;
        echo "success";
    }
    catch (PDOException $e) {
        error_log($e->getMessage());
        echo "Ha ocurrido un error. No se puede registrar en este momento.";
    }
} else {
    echo "Ha ocurrido un error. Intente rellenar el formulario otra vez";
}


