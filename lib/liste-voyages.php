<?php

function getTripListByUserId(PDO $pdo, int $userId):array
{
    $query = $pdo->prepare("SELECT carshare.*, vehicle.energy_icon AS energy_icon
                            FROM carshare
                            JOIN vehicle ON vehicle.vehicle_id = carshare.used_vehicle
                            WHERE vehicle.belong = :user_id");
    $query->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $query->execute();
    $carshare = $query->fetchAll(PDO::FETCH_ASSOC);

    return $carshare;
    
}