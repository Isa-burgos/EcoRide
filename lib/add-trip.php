<?php

function saveAnnonce(PDO $pdo, string $departAdress, string $arrivalAdress, string $departDate, string $departTime, string $arrivalTime, int $nbPlace, float $pricePerson, int $vehicleId): bool {

    if (!isset($_SESSION['user']['user_id'])) {
        die("⚠️ Erreur : L'utilisateur n'est pas connecté !");
    }

    $query = $pdo->prepare("
        INSERT INTO carshare
        (depart_adress, arrival_adress, depart_date, depart_time,arrival_time, nb_place, price_person, used_vehicle)
        VALUES
        (:depart_adress, :arrival_adress, :depart_date, :depart_time, :arrival_time, :nb_place, :price_person, :used_vehicle)
    ");

    $query->bindValue(':depart_adress', $departAdress, PDO::PARAM_STR);
    $query->bindValue(':arrival_adress', $arrivalAdress, PDO::PARAM_STR);
    $query->bindValue(':depart_date', $departDate, PDO::PARAM_STR);
    $query->bindValue(':depart_time', $departTime, PDO::PARAM_STR);
    $query->bindValue(':arrival_time', $arrivalTime, PDO::PARAM_STR);
    $query->bindValue(':nb_place', $nbPlace, PDO::PARAM_INT);
    $query->bindValue(':price_person', $pricePerson, PDO::PARAM_STR);
    $query->bindValue(':used_vehicle', $vehicleId, PDO::PARAM_INT);

    $result = $query->execute();

    return $result;
}
