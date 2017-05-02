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