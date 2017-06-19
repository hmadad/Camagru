<?php
require_once 'config/db.php';
require_once 'functions/functions.php';

session_start();

if (isset($_POST['del']))
{
    $pdo->prepare('DELETE FROM commentaires WHERE user_id = ? AND id = ?')->execute([$_SESSION['auth']->id, $_POST['del']]);
}

if (isset($_POST['submit']))
{
    if (isset($_POST['message']))
    {
        $pdo->prepare('INSERT INTO commentaires SET user_id = ?, post_id = ?, message = ?, created_at = NOW()')->execute([$_SESSION['auth']->id, $_GET['id'], htmlspecialchars($_POST['message'])]);
        $auteur = findUserPost($_GET['id'], $pdo);
        if ($auteur->id != $_SESSION['auth']->id) :
            $name = $_SESSION['auth']->username;
            $post_id = $_GET['id'];
            $to    =  $auteur->email;
            $subject = 'Commentaire - Camagru';
            $header  = "MIME-Version: 1.0\r\n";
            $header .= 'From:"Camagru"<support@camagru.fr>'."\n";
            $header .= 'Content-Type:text/html; charset="UTF-8"'."\n";
            $header .= 'Content-Transfer-Encoding: 8bit';
            $message = '<!doctype html>
                            <html lang="fr">
                            <head>
                                <meta charset="UTF-8">
                                <meta name="viewport"
                                      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                                <link rel="stylesheet" href="css/style.css">
                                <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
                                <title>Camagru</title>
                                <style>
                                /* ========================      FONT FACE    ================================    */
                                    @font-face {
                                        font-family: \'Roboto\', sans-serif;
                                    }
                                    /* ========================      BODY    ================================    */
                                    body {
                                        font-family: \'Roboto\', sans-serif;
                                        color: rgb(51, 51, 51);
                                        margin: 0;
                                    }
                                    
                                    body p {
                                        color: rgb(85, 85, 85);
                                    }
                                    /* ========================      MENU    ================================    */
                                    .menu {
                                        width: 100%;
                                        height: 80px;
                                        padding: 10px;
                                        box-sizing: border-box;
                                        display: flex;
                                        -webkit-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.75);
                                        -moz-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.75);
                                        box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.75);
                                    }
                                    
                                    
                                    .title {
                                        width: 50%;
                                        display: flex;
                                        flex-flow: row wrap ;
                                        justify-content: flex-start;
                                        align-items: center;
                                        align-content: center;
                                    }
                                    
                                    .nav {
                                        width: 50%;
                                        display: flex;
                                        flex-flow: row wrap ;
                                        justify-content: space-around;
                                        align-items: center;
                                        align-content: center;
                                    }
                                    
                                    .nav a {
                                        padding: 10px;
                                        border-bottom: solid 3px white;
                                        transition: border-bottom 0.3s;
                                        text-decoration: none;
                                        color: black;
                                    }
                                    
                                    .nav a:hover {
                                        transition: border-bottom 0.3s;
                                        border-bottom: solid 3px rgb(0, 140, 186);
                                    }
                                    
                                    .container {
                                        width: 1200px;
                                        display: flex;
                                        flex-wrap: wrap;
                                        height: auto;
                                        margin: auto;
                                    }
                                    /* ========================      INDEX.PHP    ================================    */
                                    .main {
                                        width: 75%;
                                        padding: 0 15px;
                                        box-sizing: border-box;
                                    }
                                    
                                    .sidebar {
                                        width: 25%;
                                        height: 800px;
                                        padding: 0 15px;
                                        box-sizing: border-box;
                                        background-color: #eee;
                                        overflow: auto;
                                    }
                                    
                                    .sidebar img {
                                        border-radius: 5px;
                                    }
                                    /* ========================        STYLE BUTTON    ================================    */
                                    .button {
                                        display: inline-block;
                                        border-radius: 4px;
                                        background-color: rgb(0, 140, 186);
                                        border: none;
                                        color: #FFFFFF;
                                        text-align: center;
                                        font-size: 16px;
                                        padding: 8px;
                                        width: 150px;
                                        transition: all 0.5s;
                                        cursor: pointer;
                                        margin: 5px;
                                    }
                                    
                                    .button span {
                                        cursor: pointer;
                                        display: inline-block;
                                        position: relative;
                                        transition: 0.5s;
                                    }
                                    
                                    .button span:after {
                                        content: \'\00bb\';
                                        position: absolute;
                                        opacity: 0;
                                        top: 0;
                                        right: -20px;
                                        transition: 0.5s;
                                    }
                                    
                                    .button:hover span {
                                        padding-right: 25px;
                                    }
                                    
                                    .button:hover span:after {
                                        opacity: 1;
                                        right: 0;
                                    }
                                    
                                    /* ========================      FLASH MESSAGE    ================================    */
                                    
                                    .alert {
                                        width: 100%;
                                        padding: 20px;
                                        background-color: #f44336; /* Red */
                                        color: white;
                                        margin-bottom: 15px;
                                    }
                                    
                                    /* The close button */
                                    .closebtn {
                                        margin-left: 15px;
                                        color: white;
                                        font-weight: bold;
                                        float: right;
                                        font-size: 22px;
                                        line-height: 20px;
                                        cursor: pointer;
                                        transition: 0.3s;
                                    }
                                    
                                    .closebtn:hover {
                                        color: black;
                                    }
                                    
                                    .alert-danger {
                                        background-color: #f44336;
                                    }
                                    
                                    .alert-success {
                                        background-color: #4CAF50;
                                    }
                                    
                                    /* ========================      FOOTER    ================================    */
                                    
                                    .footer {
                                        width: 100%;
                                        height: 50px;
                                        margin-top: 20px;
                                        display: flex;
                                        flex-flow: row wrap ;
                                        justify-content: space-around;
                                        align-items: center;
                                        align-content: center;
                                        -webkit-box-shadow: 0px -1px 5px 0px rgba(0,0,0,0.75);
                                        -moz-box-shadow: 0px -1px 5px 0px rgba(0,0,0,0.75);
                                        box-shadow: 0px -1px 5px 0px rgba(0,0,0,0.75);
                                    }
                                    
                                    /* ========================      GALERIE    ================================    */
                                    
                                    .photos {
                                        display: flex;
                                        flex-wrap: wrap;
                                        height: auto;
                                        margin: auto;
                                    }
                                </style>
                            </head>
                            <body>
                                <div class="menu">
                                    <div class="container">
                                        <div class="title">
                                            <img src="https://scontent.xx.fbcdn.net/v/t34.0-12/19369695_1491662190891696_1423676887_n.jpg?oh=03fa17248c84e01e0e7382d5dfea8bae&oe=594A2BE5" alt="" style="width: 40px; float: left; height: 40px;">
                                            <h1 style="margin: 0;">Camagru</h1>
                                        </div>
                                        <div class="nav">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="container" style="display: block">
                                    <h1 style="width: 100%">Photo commenté</h1>
                                    <p>'.$name.' a commenté votre <a href="http://localhost:8080/camagru/single.php?id='.$post_id.'">photo</a></p>
                                </div>
                            </body> 
                            </html>';
            /* Envoie du mail HTML */
            mail($to, $subject, $message, $header);
        endif;
    }
    else
        $_SESSION['flash']['danger'] = "Commentaire vide";
}

if (isset($_GET['id'])) {
    $req = $pdo->prepare('SELECT * FROM articles WHERE id = ?');
    $req->execute([$_GET['id']]);
    $article = $req->fetch();
    if ($req->rowCount() <= 0)
        $_SESSION['flash']['danger'] = "Aucun Article avec cet id";
    else {
        $req = $pdo->prepare('SELECT * FROM commentaires WHERE post_id = ? ORDER BY created_at DESC');
        $req->execute([$_GET['id']]);
        $commentaires = $req->fetchAll();
    }
} else
    $_SESSION['flash']['danger'] = "Aucun Article avec cet id";



require 'inc/header.php';

if (!empty($article)) : ?>
    <div class="galerie" style="width: 980px; margin: auto">
            <div class="articles" style="width: 500px; margin: auto">
                <img src="<?= $article->path; ?>" alt="" style="width: 320px; height: 250px;">
            </div>
        <form action="like.php?vote=1&ref_id=<?= $article->id ?>" method="post" style="float: left">
            <button type="submit" class="button" style="background-color: #4CAF50"><span style="color: green">Like : </span> <?= $article->like_count; ?></button>
        </form>
        <form action="like.php?vote=-1&ref_id=<?= $article->id ?>" method="post" style="float: right">
            <button type="submit" class="button" style="background-color: #f44336"><span style="color: white">Dislike : </span> <?= $article->dislike_count; ?></button>
        </form>
        <div class="comment" style="width: 100%; margin-top: 50px;">
            <form action="" method="POST">
                <label for="message">Commentaire</label>
                <textarea name="message" rows="3" style="width: 100%" placeholder="Commentaire..."></textarea>
                <button type="submit" class="button" name="submit"><span>Envoyer</span></button>
            </form>
            <hr>
            <?php if (!empty($commentaires)) : ?>
                <?php foreach ($commentaires as $com) : ?>
                    <div class="comm" style="width: 100%; background-color: #eeeeee; border-radius: 20px; padding: 10px; box-sizing: border-box; margin: 10px 0;">
                        <?php if ($_SESSION['auth']->id == $com->user_id) : ?>
                        <form action="" method="post">
                            <button class="closebtn" name="del" style="border: none; color: red" value="<?= $com->id ?>">&times;</button>
                        </form>
                        <?php endif; ?>
                        <p><span style="color: rgb(0, 140, 186);"><?php ucfirst(showUser($com->user_id, $pdo)); ?></span> : <?= $com->message ?></p>
                        <p style="text-align: right"><?= $com->created_at ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        </div>
        <hr>
    <script>
        function delcom() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("POST", "http://localhost/cama/single.php", true);
            xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xmlhttp.send("data="+data+"&elements="+elements);
        }
    </script>
<?php endif;
require 'inc/footer.php';
?>
