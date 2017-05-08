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