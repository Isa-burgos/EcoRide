<?php

function getCarshare(PDO $pdo):array
{
    $query = $pdo->prepare("SELECT * FROM carshare");
    $query->execute();

    return $query->fetchAll(PDO::FETCH_ASSOC);
}