<?php require_once ('functions/functions.php'); ?>
<?php
if (!empty($_POST))
{
    $errors = array();
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        $errors['email'] = "L'email est invalide";
    if (empty($errors))
    {
        session_start();
        require_once('config/db.php');
        $req = $pdo->prepare("SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL");
        $req->execute([$_POST['email']]);
        $user = $req->fetch();
        if (!empty($user))
        {
            $reset_token = str_random(60);
            $req = $pdo->prepare('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?')->execute([$reset_token, $user->id]);
            $subject = 'Reinitialisation du mot de passe - Camagru';
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
                                    <h1 style="width: 100%">Reinitialisation du mot de passe</h1>
                                    <p>Afin de reinitialiser votre mot de passe, merci de vous rendre sur <a href="http://localhost:8080/camagru/reset.php?id='.$user->id.'&token='.$reset_token.'">ce lien</a></p>
                                </div>
                            </body> 
                            </html>';
            /* Envoie du mail HTML */
            mail($_POST['email'], $subject, $message, $header);
            $_SESSION['flash']['success'] = "Les instructions vous on été envoyé par email";
            header('location: login.php');
            exit;
        }
        else
            $_SESSION['flash']['danger'] = "Aucun compte ne correspond a cet email";
    }
}
require ('inc/header.php');
?>
    <div class="container">
        <h1>Mot de passe oublié</h1>
        <form action="" method="POST" style="width: 100%">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Email" style="margin: 15px 0; width: 100%; padding: 15px; font-size: 15px; border-radius: 5px; border: solid 1px rgb(51, 51, 51)">
            <br />
            <button class="button" type="submit"><span>Reinitialiser</span></button>
        </form>
    </div>
<?php require ('inc/footer.php'); ?>