<?php

session_start();
unset($_SESSION['auth']);
$_SESSION['flash']['success'] = "Vous vous etes deconnect� avec succ�s";
header('location: index.php');