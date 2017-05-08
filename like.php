<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(403);
    die();
}
session_start();

require_once 'config/db.php';

require 'class/Vote.php';
$vote = new Vote($pdo);

if ($_GET['vote'] == 1) {
    $vote->like('articles', $_GET['ref_id'], $_SESSION['auth']->id);
} else {
    $vote->dislike('articles', $_GET['ref_id'], $_SESSION['auth']->id);
}
header('location: galerie.php');