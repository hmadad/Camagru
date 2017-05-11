<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(403);
    die();
}
require 'functions/functions.php';

session_start();
if (!isset($_POST['submit']))
{
    $img = $_POST['data'];
    $img = str_replace('data:image/jpeg;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $formated = str_random(10);
    $success = file_put_contents("public/pictures/".$formated.".jpeg", $data);
// On charge d'abord les images
    $source = imagecreatefrompng($_POST['elements']); // Le logo est la source
    $destination = imagecreatefromjpeg("public/pictures/".$formated.".jpeg"); // La photo est la destination
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
    unlink("public/pictures/".$formated.".jpeg");
    imagecolortransparent ($destination, 100);
    $formated_after = str_random(10);
    if (!file_exists("public/montages/".$_SESSION['auth']->id.""))
        mkdir("public/montages/".$_SESSION['auth']->id);
// On affiche l'image de destination qui a été fusionnée avec le logo
    imagejpeg($destination, "public/montages/".$_SESSION['auth']->id."/".$formated_after.".jpg");
    $path = "public/montages/".$_SESSION['auth']->id."/".$formated_after.".jpg";
    require 'config/db.php';
    $req = $pdo->prepare("INSERT INTO articles SET user_id = ?, path = ?, created_at = NOW()")->execute([$_SESSION['auth']->id, $path]);
    $username = $_SESSION['auth']->username;
}
else
{
    if (!isset($_FILES['data']))
    {
        $_SESSION['flash']['danger'] = "Aucune image upload";

    }
    else
    {
        $imagename = $_FILES['data']['name'];
        $imagetype = $_FILES['data']['type'];
        $imagetypep = str_replace('image/', '', $imagetype);
        $imageerror = $_FILES['data']['error'];
        $imagetemp = $_FILES['data']['tmp_name'];
        $formated = str_random(10);

        if ($imagetypep != "jpg" && $imagetypep != "jpeg")
        {
            $_SESSION['flash']['danger'] = "Mauvais format de l'image (uniquement jpg ou jpeg)";
            header('location: index.php');
            exit;
        }
        //The path you wish to upload the image to
        $imagePath = "public/pictures/".$formated;

        if(is_uploaded_file($imagetemp) && substr($imagetype, 0, 5) == "image") {
            if(move_uploaded_file($imagetemp, $imagePath .".".$imagetypep)) {
                // On charge d'abord les images
                $source = imagecreatefrompng($_POST['elements']); // Le logo est la source
                $destination = imagecreatefromjpeg("public/pictures/".$formated.".".$imagetypep); // La photo est la destination
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
                unlink("public/pictures/".$formated.".".$imagetypep);
                imagecolortransparent ($destination, 100);
                $formated_after = str_random(10);
                if (!file_exists("public/montages/".$_SESSION['auth']->id.""))
                    mkdir("public/montages/".$_SESSION['auth']->id);
// On affiche l'image de destination qui a été fusionnée avec le logo
                imagejpeg($destination, "public/montages/".$_SESSION['auth']->id."/".$formated_after.".jpg");
                $path = "public/montages/".$_SESSION['auth']->id."/".$formated_after.".jpg";
                require 'config/db.php';
                $req = $pdo->prepare("INSERT INTO articles SET user_id = ?, path = ?, created_at = NOW()")->execute([$_SESSION['auth']->id, $path]);
                $username = $_SESSION['auth']->username;
            }
            else {
                $_SESSION['flash']['danger'] = "Probleme lors du deplacement du fichier";
            }
        }
        else {
            $_SESSION['flash']['danger'] = "Probleme avec l'image";
        }
    }
}
header('location: index.php');