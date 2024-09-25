<?php

require_once 'config.php';

ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

session_set_cookie_params (
    [
        'domain' => $config["cookie_domain"],
        'path' => '/',
        'secure' => true,
        'httponly' => true
    ]
);

session_start();

if ( !isset($_SESSION['last_regeneration']) or
    time() - $_SESSION['last_regeneration'] >= 60 * 30 )
{
    regenerate_session_id();
}

if ( isset($_SESSION['last_active']) and
    time() - $_SESSION['last_active'] >= 60 * 60 * 24 )
{
    session_unset();
    session_destroy(); 
}

$_SESSION['last_active'] = time();

function regenerate_session_id()
{
    session_regenerate_id(true);

    if (isset($_SESSION["user_id"]))
    {
        $userId = $_SESSION["user_id"];
        $newSessionId = session_create_id();
        session_id($newSessionId . "_" . $userId);
    }

    $_SESSION['last_regeneration'] = time();
}