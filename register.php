<?php
require_once ('functions/functions.php');
if (session_status() == PHP_SESSION_NONE)
    session_start();
    if (!empty($_POST))
    {
        if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username']))
            $_SESSION['flash']['danger'] = "Le nom d'utilisateur n'est pas valide";
        else {
            require_once ('config/db.php');
            $req = $pdo->prepare("SELECT id FROM users WHERE username = ?");
            $req->execute([$_POST['username']]);
            $user = $req->fetch();
            if (!empty($user))
                $_SESSION['flash']['danger'] = "Le nom d'utilisateur est déjà utilisé";
        }

        if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            $_SESSION['flash']['danger'] = "L'email est invalide";
        else {
            $req = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $req->execute([$_POST['email']]);
            $user = $req->fetch();
            if (!empty($user))
                $_SESSION['flash']['danger'] = "Cet email est déjà utilisé";
        }

        if (empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm'])
            $_SESSION['flash']['danger'] = "Le mot de passe est invalide";

        if (!isset($_SESSION['flash']['danger']))
        {
            $req = $pdo->prepare("INSERT INTO users SET username = ?, email = ?, password = ?, confirmation_token = ?");
            $token = str_random(60);
            $req->execute([$_POST['username'], $_POST['email'], password_hash($_POST['password'], PASSWORD_BCRYPT), $token]);
            $id = $pdo->lastInsertId();
            $to    =  $_POST['email'];
            $subject = 'Activation du compte - Camagru';
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
                                    <h1 style="width: 100%">Activation du compte</h1>
                                    <p>Afin de valider votre compte, merci de cliquer sur <a href="http://localhost:8080/camagru/confirm.php?id='.$id.'&token='.$token.'">ce lien</a></p>
                                </div>
                            </body> 
                            </html>';
            /* Envoie du mail HTML */
            mail($to, $subject, $message, $header);
            $_SESSION['flash']['success'] = "Un email de confirmation a été envoyé";
            header('Location: login.php');
            exit;

        }
    }
require ('inc/header.php');
?>
<div class="container">
    <h1>S'inscrire</h1>
    <form action="" method="POST" style="width: 100%">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" placeholder="Nom d'utilisateur" style="margin: 15px 0; width: 100%; padding: 15px; font-size: 15px; border-radius: 5px; border: solid 1px rgb(51, 51, 51)">
        <br />
        <label for="email">Email</label>
        <input type="email" name="email" placeholder="Email" style="margin: 15px 0; width: 100%; padding: 15px; font-size: 15px; border-radius: 5px; border: solid 1px rgb(51, 51, 51)">
        <br />
        <label for="password">Mot de passe</label>
        <input type="password" name="password" placeholder="Mot de passe" style="margin: 15px 0; width: 100%; padding: 15px; font-size: 15px; border-radius: 5px; border: solid 1px rgb(51, 51, 51)">
        <br />
        <label for="password_confirm">Confirmer le mot de passe</label>
        <input type="password" name="password_confirm" placeholder="Confirmer mot de passe" style="margin: 15px 0; width: 100%; padding: 15px; font-size: 15px; border-radius: 5px; border: solid 1px rgb(51, 51, 51)">
        <br />
        <button class="button" type="submit"><span>S'inscrire</span></button>
    </form>
</div>
<?php require ('inc/footer.php'); ?>