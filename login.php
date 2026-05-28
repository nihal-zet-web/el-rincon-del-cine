<?php

require_once "conectar_db.php";
$username = isset($_POST['username']) ? $_POST['username'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null; 

if ($username && $password) {
    try {
        $loginQuery = "SELECT username, user_password FROM users WHERE username = :username"; 
        $loginStmt = $pdo->prepare($loginQuery); 
        $loginStmt->execute([":username" => $username]);
        $user = $loginStmt->fetch(PDO::FETCH_ASSOC); 
        if ($user['username'] == $username) {
            if (password_verify($password, $user['user_password'])) {
                echo "success"; 
            }
        }
    }
    catch (PDOException $e) {
        echo $e->getMessage();
        echo "Ha ocurrido un problema.";
    }
}