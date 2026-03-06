<?php
//here we receive new comments from users and validate for a 
//second time after js and return an answer to js if necessary
//this should receive a comment text, receive post id, username, store comment, redirect back to post.php
    require "conectar_db.php";
//we neeed the user to be registred to be able to write a comment
    session_start();
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
            echo "Ha ocurrido un problema. No se puede añadir su comentario.";
        }
    } else {
        echo "Tiene que estar registrado para comentar.";
    }
               

