<?php

session_start();
unset($_SESSION['auth']);
$_SESSION['flash']['success'] = "Vous vous etes deconnecté avec succès";
header('location: index.php');