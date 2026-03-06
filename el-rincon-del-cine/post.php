<!DOCTYPE html>
<?php 
    require "conectar_db.php";
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <!--Esta parte mostrará el titulo de la película o serie-->
        <title>
            <?php  
                $post_id = isset($_GET['post_id']) ? $_GET['post_id'] : null;      
                if ($post_id) {
                    //try {
                        $showTitleQuery = "SELECT * FROM posts WHERE post_id = :post_id";
                        $showTitleQueryStmt = $pdo->prepare($showTitleQuery);
                        $showTitleQueryStmt->execute(['post_id' => $post_id]);
                        $title = $showTitleQueryStmt->fetch(PDO::FETCH_ASSOC);
                        if ($title) {
                            echo htmlspecialchars($title['title']);
                        } else {
                            echo "Titulo no disponible.";
                        }
                    //} 
                    //catch (PDOException $e) {
                        //error_log($e->getMessage());
                        //echo "Ha ocurrido un problema. No se puede cargar el título.";
                    //}
                } else { 
                    echo "No hay valor.";
                } 
            ?>
        </title>
        <link rel="stylesheet" href="styles.css">
    </head>
    </head>
    <body>
        <header id="header-container">
            <h1>El Rincón del Cine</h1>
        </header>
        <nav id="nav-container">
            <ul id="ul-container">
                <li class="navBar-element"><a href="index.php">Inicio</a></li>
                <li class="navBar-element"><a href="registro.html">Registro</a></li>
                <li class="navBar-element"><a href="contacto.html">Contacto</a></li>
            </ul>
        </nav>
        <main id="main-container">
            <section id="post-container">
                <div class="small-border">
                    <?php
                    // Get the ID from the URL (index.php?id=1)
                    //receives an id
                        $post_id = isset($_GET['post_id']) ? $_GET['post_id'] : null;
                    //uses the id
                    //TRY-CATCH
                        if ($post_id):
                            try {
                                $showPostQuery = "SELECT * FROM posts WHERE post_id = :post_id";
                                $showPostStmt = $pdo->prepare($showPostQuery);
                                $showPostStmt->execute([':post_id' => $post_id]);
                                $post = $showPostStmt->fetch(PDO::FETCH_ASSOC);
                            //displays post data
                                if ($post) { 
                    ?>
                                    <h1><?=htmlspecialchars($post['title'])?> (<?=htmlspecialchars($post['release_year'])?>)<br></h1>
                                    <p>
                                    
                                        <div id="post-box">
                                            <img src="<?=htmlspecialchars($post['post_image'])?>"><br>
                                        </div>
                                        <div class="post-box-content">
                                            <p>
                                                <span>Director:</span>       <?=htmlspecialchars($post['director'])?><br>
                                                <span>Género:</span>         <?=htmlspecialchars($post['genre'])?><br>
                                                <span>Descripción:</span>    <br><?=htmlspecialchars($post['description'])?><br>
                                                <span>Cast:</span>           <?=htmlspecialchars($post['cast'])?><br>
                                                <span>Plataformas:</span>    <?=$post['where_to_watch']?><br>
                                            </p>
                                            <h3 id='spoiler'>Esta publicación contiene SPOILERS!</h3><br><br>
                                            <div id='review-container'>
                                                <?=nl2br($post['my_review'])?>
                                            </div><br>
                                            <div class="post-date">
                                                <?php 
                                                    $datePosted = htmlspecialchars($post['date_posted']);
                                                    $datePostedObject = new DateTime($datePosted);
                                                    echo "Subido en ".$datePostedObject->format("Y-m-d H:i");
                                                ?>
                                            </div>
                                        </div>
                                    </p>
                    <?php
                                } else {
                                    echo "Entrada no disponible.";
                                }
                            }
                            catch (PDOException $e) {
                                error_log($e->getMessage());
                                echo "Ha ocurrido un problema. No se puede cargar el post.";
                            }
                        else:
                            echo "No hay valor.";
                        endif; 
                    ?>
                </div>
            </section>
            <section id="comments-container">
                <form id="comment-form" action="añadir_comentarios.php" method="get">
                    <label for="user-comment">Comentarios</label><br>
                    <div class="comment">
                        <input id="user-comment" type="text" name="user-comment" value="" placeholder="Comentar..."><BR>
                        <div id="error-user-comment"></div>
                        <input id="comment-post-id" type="hidden" name="post-id" value= "<?php echo $post_id;?>">
                        <input type="submit" value="Enviar">
                    </div>
                </form>
                <div id="comment-section">
                    <?php 
                        $post_id = isset($_GET['post_id']) ? $_GET['post_id'] : null;
                        //uses the id
                        //TRY-CATCH
                        if ($post_id) {
                            try {
                                $showCommentQuery = "SELECT * FROM comments WHERE post_id = :post_id ORDER BY date_created DESC";
                                $showCommentStmt = $pdo->prepare($showCommentQuery);
                                $showCommentStmt->execute([':post_id' => $post_id]);
                                $comment = $showCommentStmt->fetchAll(PDO::FETCH_ASSOC);   
                            //displays comment data
                                if ($comment) {
                                    foreach ($comment as $singleComment) { 
                    ?>
                                        <h4>
                                            <a href="comentarios_usuario.php?username=<?=htmlspecialchars($singleComment['username'])?>"><?=htmlspecialchars($singleComment['username'])?></a>
                                        </h4>
                                        <p>
                                            <?=htmlspecialchars($singleComment['comment_text'])?><br>
                                            <?php 
                                                $dateCreated = htmlspecialchars($singleComment['date_created']);
                                                $dateCreatedObject = new DateTime($dateCreated);
                                                echo $dateCreatedObject->format("Y-m-d");
                                            ?>
                                        </p>
                    <?php
                                    }
                                } else {
                                    echo "No hay comentarios.";
                                }
                            } 
                            catch (PDOException $e) {
                                error_log($e->getMessage());
                                echo "Ha ocurrido un problema. No se pueden cargar los comentarios.";
                            }
                        } else {
                            echo "No hay valor.";
                        }
                    ?>
                </div>
            </section>
        </main>
        <footer id="footer-container">
            <p>El Rincon del Cine Copyright &copy; 2026</p>      
        </footer>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="script.js"></script>   
    </body>
</html>