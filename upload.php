<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(403);
    die();
}
require 'functions/functions.php';

session_start();
if (!file_exists("public/pictures/".$_SESSION['auth']->id))
    mkdir("public/pictures/".$_SESSION['auth']->id);
$img = $_POST['data'];
$img = str_replace('data:image/jpeg;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$formated = str_random(10);
$success = file_put_contents("public/pictures/".$_SESSION['auth']->id."/".$formated.".jpeg", $data);
// On charge d'abord les images
$source = imagecreatefrompng($_POST['elements']); // Le logo est la source
$destination = imagecreatefromjpeg("public/pictures/".$_SESSION['auth']->id."/".$formated.".jpeg"); // La photo est la destination
imagealphablending($source, false);
imagesavealpha($source, true);
// Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
$largeur_source = imagesx($source);
$hauteur_source = imagesy($source);
$largeur_destination = imagesx($destination);
$hauteur_destination = imagesy($destination);
// On veut placer le logo en bas à droite, on calcule les coordonnées où on doit placer le logo sur la photo
$destination_x = ($largeur_destination - $largeur_source) / 2;
$destination_y =  ($hauteur_destination - $hauteur_source) / 2;
// On met le logo (source) dans l'image de destination (la photo)
imagecopy($destination, $source, $destination_x, $destination_y, 0, 0, $largeur_source, $hauteur_source);
imagecolortransparent ($destination, 100);
$formated_after = str_random(10);
if (!file_exists("public/montages/".$_SESSION['auth']->id.""))
    mkdir("public/montages/".$_SESSION['auth']->id);
// On affiche l'image de destination qui a été fusionnée avec le logo
imagejpeg($destination, "public/montages/".$_SESSION['auth']->id."/".$formated_after.".jpg");
$path = "public/montages/".$_SESSION['auth']->id."/".$formated_after.".jpg";
$username = $_SESSION['auth']->username;