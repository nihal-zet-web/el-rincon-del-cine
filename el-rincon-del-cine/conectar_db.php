<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//here we connect php to the database and we use this file
//in all the other php files 
try {
    $pdo = new PDO("mysql:hostname=localhost;port=3307;dbname=db_el_rincon_del_cine", "my_user", "-phpPassword-");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log($e->getMessage());
    echo "No se ha podido conectar con el servidor.";
}
