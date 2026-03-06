<?php
//this file handles form data, we receive it and then 
//decide what to do with it(save in database, check if already exists)
//only processes data
//redirects or shows success/error
//it needs connection to the database to be able to insert the new row in the table
require "conectar_db.php";
//you need to fill the form so that it can be processed

//i make sure that the form is filled by checking if the array post has the values of the keys that i wrote ( which have the same name as the attr name in the input tags so its easier to remember)
//if the array dont ahve data then this variables will be null

$username = isset($_POST['username']) ? $_POST['username'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;
//check if the variables have data or are null
//TRY-CATCH

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
        //if they dont have data then will make a sql statement for inserting the data in the database and we write it with placeholders so it more secure
        //TRY-CATCH
        $insertDataQuery = "INSERT INTO users (username, email, user_password) VALUES (:username, :email, :password)";
        //then we prepare the statement turning it into an object from pdostatement class
        $insertDataStmt = $pdo->prepare($insertDataQuery);
        //now we use our object that has the statement to execute it and we replace the placeholders with the actual values
        $insertDataStmt->execute([":username" => $username, ":email" => $email, ":password" => $password]);
        session_start();
        $_SESSION['username'] = $username;
        //if everything goes right, we'll have the row inserted in the table
        echo "success";
    }
    catch (PDOException $e) {
        error_log($e->getMessage());
        "Ha ocurrido un error. No se puede registrar en este momento."
    }
} else {
    //if its everything is not fine, then we'll make sure to say it
    echo "Ha ocurrido un error. Intente rellenar el formulario otra vez";
}
// i can add a try catch bloque in the if and delete the else

