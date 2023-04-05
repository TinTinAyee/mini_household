<?php
function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

function pd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
}

function base_path($file)
{
    return BASE_PATH .$file;
}

function login($user){
    $_SESSION['user'] = $user;
}

?>