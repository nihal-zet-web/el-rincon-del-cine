<?php
session_start();
require "conectar_db.php";
//Aquí recibimos los nuevos comentarios y vemos si están registrados o no y en caso de que sí lo estén, 
//añadimos el comentario en la base de datos.

$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$post_id = isset($_GET['myPostId']) ? $_GET['myPostId'] : null;
$comment_text = isset($_GET['comment']) ? $_GET['comment'] : null;
if ($username && $post_id && $comment_text) {
    try {
        $insertCommentQuery = "INSERT INTO comments(username, post_id, comment_text, date_created) VALUES(:username, :post_id, :comment_text, current_timestamp())";
        $insertCommentStmt = $pdo->prepare($insertCommentQuery);
        $insertCommentStmt->execute([":username" => $username, ":post_id" => $post_id, ":comment_text" => $comment_text]);
        echo "success";
        $_SESSION['post-id'] = $post_id;
    }
    catch (PDOException $e) {
        error_log($e->getMessage());
        echo "Ha ocurrido un problema. No se puede añadir su comentario. ¿Se ha registrado correctamente?";
    }
} else {
    echo "Tiene que estar registrado para comentar.";
}
               

