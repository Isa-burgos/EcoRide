<?php

$config = require "config.php";

try{
    $pdo = new PDO("mysql:dbname={$config['dbname']};host={$config['host']};charset=utf8mb4", $config['username'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
}
catch(Exception $e){
    die('Erreur : ' . $e->getMessage());
}

