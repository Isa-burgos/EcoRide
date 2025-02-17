<?php

$session_lifetime = 3600;

session_set_cookie_params([
    'lifetime' => $session_lifetime,
    'path' => '/',
    'domain' => '.ecoride.local',
    'httponly' => true
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user'])) {
    setcookie(session_name(), session_id(), time() + $session_lifetime, "/");
}

function isUserConnected():bool
{
    return isset($_SESSION['user']);
}