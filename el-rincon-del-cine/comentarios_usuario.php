<?php require "conectar_db.php"; ?>
<!DOCTYPE html>
<html>
    <!--static content, THE EASIEST PART-->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>El Rincón del Cine</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <header id="header-container">
            <h1>El Ricón del Cine</h1>
        </header>
        <nav id="nav-container">
            <ul id="ul-container">
                <li class="navBar-element"><a href="index.php">Inicio</a></li>
                <li class="navBar-element"><a href="registro.html">Registro</a></li>
                <li class="navBar-element"><a href="contacto.html">Contacto</a></li>
            </ul>
        </nav>
        <main>
            <div id="history-container">
                <div class="small-border">
                    <?php

                        session_start();
                        $usernameInSession = isset($_SESSION['username']) ? $_SESSION['username'] : null;
                        $clickedUsername = isset($_GET['username']) ? $_GET['username'] : null;
                        if ($usernameInSession == $clickedUsername) {
                            //TRY-CATCH
                            $showUserCommentsQuery = "SELECT posts.post_id, posts.title, comments.comment_text, comments.date_created FROM comments INNER JOIN posts ON comments.post_id = posts.post_id WHERE comments.username = :username ORDER BY comments.date_created DESC";
                            $showUserCommentsStmt = $pdo->prepare($showUserCommentsQuery);
                            $showUserCommentsStmt->execute([":username" => $usernameInSession]);
                            $arrayComments = $showUserCommentsStmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($arrayComments as $comment) {
                    ?>
                                <div id="history-comment">
                                    <p><a href = 'post.php?post_id=<?=htmlspecialchars($comment['post_id'])?>'><?=htmlspecialchars($comment['title'])?></a></p>
                                    <p><?=htmlspecialchars($comment['comment_text'])?></p>
                                    <p>
                                        <?php 
                                            $dateCreated = htmlspecialchars($comment['date_created']);
                                            $dateCreatedObject = new DateTime($dateCreated);
                                            echo $dateCreatedObject->format("Y-m-d");
                                        ?>
                                    </p>
                                </div>
                    <?php
                            }        
                        } 
                        else {
                            echo "No puede ver el historial de comentarios de este usuario.";
                        }
                    ?>
                </div>
            </div>
        </main>
        <footer id="footer-container">
            <p>El Rincon del Cine Copyright &copy; 2026</p>
        </footer>
    </body>
</html>
 
