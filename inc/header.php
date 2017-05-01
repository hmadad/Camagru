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
    <title>Camagru</title>
</head>
<body>
<div class="nav">
    <ul>
        <a href="index.php"><li>Accueil</li></a>
        <?php if(!isset($_SESSION['auth'])): ?>
        <a href="login.php"><li>Se connecter</li></a>
        <a href="register.php"><li>S'inscrire</li></a>
    <?php else :?>
            <a href="lougout.php"<li>Se deconnecter</li></a>
    <?php endif; ?>
    </ul>
</div>
<?php

if (isset($_SESSION['flash']))
{
    foreach ($_SESSION['flash'] as $key => $value)
    {
        if ($key == "danger")
            echo '<h3 style="color: red;">'.$value.'</h3>';
        if ($key == "success")
            echo '<h3 style="color: green;">'.$value.'</h3>';

    }
    unset($_SESSION['flash']);
}

?>