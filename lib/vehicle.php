<?php

function getUserVehicles(PDO $pdo, int $userId):array
{
    $query = $pdo->prepare("SELECT vehicle_id, brand, model FROM vehicle WHERE belong = :user_id");
    $query->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $query->execute();

    return $query->fetchAll(PDO::FETCH_ASSOC);
}