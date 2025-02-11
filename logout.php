<?php
    require_once __DIR__ . "/lib/session.php";

    session_regenerate_id(true);
    session_destroy();
    unset($_SESSION);

    header('location: login.php');