<!DOCTYPE html>
<?php
    require "conectar_db.php";    
    //Cogemos cada post que hay en la base de datos y lo mostramos en la página inicial
    try {
        $showPostQuery = "SELECT post_id, title, date_posted, post_image FROM posts";
        $showPostStmt = $pdo->prepare($showPostQuery);
        $showPostStmt->execute();
        $posts = $showPostStmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e) {
        error_log($e->getMessage());
        echo "Ha ocurrido un problema al intentar cargar la página.";
    }
?>
<html>
    <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>El Rincón del Cine</title>
       <link rel="stylesheet" href="styles.css">
    </head>

    <body>
        <header id="header-container">
            <h1>El Rincón del Cine</h1>
        </header>
        <nav id="nav-container">
            <ul id="ul-container">
                <li class="navBar-element-non-clickable">Inicio</li>
                <li class="navBar-element"><a href="registro.html">Registro</a></li>
                <li class="navBar-element">           
                    <div id="navBar-dropdown">
                        <!--Usamos javascript para redirigir a la página y php para mostrar los valores desde la base de datos-->
                        <select onchange="if(this.value) window.location.href='post.php?post_id=' + this.value;">
                            <option value="entradas" selected>Entradas</option>
                                <?php if ($posts): ?>
                                    <?php foreach ($posts as $post): ?>
                                        <option value="<?= htmlspecialchars($post['post_id']); ?>">
                                            <?php echo htmlspecialchars($post['title']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="">No hay entradas</option>
                                <?php endif; ?>
                        </select>
                    </div>
                </li>
                <li class="navBar-element"><a href="contacto.html">Contacto</a></li>
            </ul>
        </nav>
        <main>
            <div id="posts-container"> 
                <?php if($posts): 
                    foreach ($posts as $post): ?>
                        <div class="post-content">
                            <h3 class="post-title">
                                <a href='post.php?post_id=<?=htmlspecialchars($post['post_id'])?>'><?=htmlspecialchars($post['title'])?></a>
                            </h3><br>
                            <div class="image-container">
                                <img class="post-image" src="<?=htmlspecialchars($post['post_image'])?>">
                            </div><br>
                            <p class="post-date">
                            
                                <?php 
                                    $datePosted = htmlspecialchars($post['date_posted']);
                                    $datePostedObject = new DateTime($datePosted);
                                    echo "Subido en ".$datePostedObject->format("Y-m-d H:i");
                                ?>
                            </p>
                        </div><br>
                <?php 
                    endforeach;
                endif; ?>     
            </div>
        </main>
        <footer id="footer-container">
            <p>El Rincon del Cine Copyright &copy; 2026</p>      
        </footer>
    </body>
</html>