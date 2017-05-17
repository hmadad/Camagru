<?php
$pdo = new PDO('mysql:host=localhost', 'root', '');

$req = $pdo->prepare("CREATE DATABASE IF NOT EXISTS `camagru`")->execute();
$pdo = new PDO('mysql:dbname=camagru;host=localhost', 'root', '');
$req = $pdo->prepare("CREATE TABLE IF NOT EXISTS `users`
(
    `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `confirmation_token` VARCHAR(60),
    `confirmed_at` DATETIME,
    `reset_token` VARCHAR(60),
    `reset_at` DATETIME
)")->execute();
$req = $pdo->prepare("CREATE TABLE IF NOT EXISTS `articles`
(
    `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` int(11) NOT NULL,
    `path` VARCHAR(255) NOT NULL,
    `created_at` DATETIME NOT NULL,
    `like_count` int(11) DEFAULT '0',
    `dislike_count` int(11) DEFAULT '0'
)")->execute();
$req = $pdo->prepare("CREATE TABLE IF NOT EXISTS `commentaires`
(
    `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` int(11) NOT NULL,
    `post_id` int(11) NOT NULL,
    `message` longtext NOT NULL,
    `created_at` DATETIME NOT NULL
)")->execute();
$req = $pdo->prepare("CREATE TABLE IF NOT EXISTS `votes`
(
    `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `ref_id` int(11) NOT NULL,
    `ref` varchar(255) NOT NULL,
    `user_id` int(11) NOT NULL,
    `vote` int(11) NOT NULL,
    `created_at` DATETIME NOT NULL
)")->execute();

header('location: ../index.php');