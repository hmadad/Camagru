<?php

function debug($variable)
{
    echo '<pre>'.print_r($variable).'</pre>';
}

function str_random($length)
{
    $alphabet = "0123456789abcdefghijklmnopqrstuvwxyzABCEFGHIJKLMNOPQRSTUVWXYZ";
    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}

function isConnected()
{
    if (session_status() == PHP_SESSION_NONE)
        session_start();
    if (isset($_SESSION['auth']))
        return TRUE;
    return FALSE;
}

function radio()
{
    $i = 0;
    foreach (glob("images/*.png") as $img)
    {
        echo '<img src="'.$img.'" style="width: 50px;">';
        echo '<input type="radio" name="elements" value="'.$img.'">'.substr($img, 7, strlen($img) - 7 - 4);
        $i++;
    }
}

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);
    echo "<script>console.log('Debug Objects: ".$output."');</script>";
}

function showUser($id, PDO $pdo)
{
    $req = $pdo->prepare('SELECT username FROM users WHERE id = ?');
    $req->execute([$id]);
    $user = $req->fetch();
    if (empty($user))
        return FALSE;
    else
        echo $user->username;
    return TRUE;
}

function findUserPost($post_id, PDO $pdo)
{
    $req = $pdo->prepare('SELECT * FROM articles WHERE id = ?');
    $req->execute([$post_id]);
    $article = $req->fetch();
    $req = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $req->execute([$article->user_id]);
    return $req->fetch();
}