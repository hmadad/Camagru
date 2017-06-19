<?php
if (session_status() == PHP_SESSION_NONE)
    session_start();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <title>Camagru</title>
</head>
<div class="menu">
    <div class="container">
        <div class="title">
            <img src="images/logo.jpg" alt="" style="width: 50px; float: left">
            <h1 style="margin: 0;">Camagru</h1>
        </div>
        <div class="nav">
            <a href="index.php">Accueil</a>
            <?php if(!isset($_SESSION['auth'])): ?>
                <a href="login.php">Se connecter</a>
                <a href="register.php">S'inscrire</a>
            <?php else :?>
                <a href="galerie.php">Galerie</a>
                <a href="account.php">Profile</a>
                <a href="logout.php">Se deconnecter</a>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="container">
    <?php

    if (isset($_SESSION['flash']))
    {
        foreach ($_SESSION['flash'] as $key => $value)
        {
            if ($key == "danger")
            {
                echo '<div class="alert alert-danger">';
                echo '<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> ';
                echo $value;
                echo '</div>';
            }
            if ($key == "success")
            {
                echo '<div class="alert alert-success">';
                echo '<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> ';
                echo $value;
                echo '</div>';
            }

        }
        unset($_SESSION['flash']);
    }

    ?>
</div>