<?php

require_once __DIR__ . "/lib/pdo.php";
require_once __DIR__ . "/lib/session.php";

if (!isset($_SESSION['user']['user_id'])) {
    header("Location: /login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST["saveVehicle"])) {
    header("Location: account.php?error=invalid_access");
    exit();
}

$userId = $_SESSION['user']['user_id'];
$registration = trim($_POST['registration'] ?? '');
$firstRegistrationDate = trim($_POST['first_registration_date'] ?? '');
$brand = trim($_POST['brand'] ?? '');
$model = trim($_POST['model'] ?? '');
$color = trim($_POST['color'] ?? '');
$energy = $_POST['energy'] ?? 0;
$nbPlace = $_POST['nb_place'] ?? 1;
$smoking = isset($_POST['smoking']) ? (int) $_POST['smoking'] : 0;
$pets = isset($_POST['pets']) ? (int) $_POST['pets'] : 0;
$preferenceText = trim($_POST['other_preferences'] ?? '');

if (empty($registration) || empty($firstRegistrationDate) || empty($brand) || empty($model)) {
    header("Location: account.php?error=missing_fields");
    exit();
}

try {
    $pdo->beginTransaction();

    $queryVehicle = $pdo->prepare("
        INSERT INTO vehicle (registration, first_registration_date, brand, model, color, energy, belong)
        VALUES (:registration, :first_registration_date, :brand, :model, :color, :energy, :user_id)
        ON DUPLICATE KEY UPDATE
        first_registration_date = VALUES(first_registration_date),
        brand = VALUES(brand),
        model = VALUES(model),
        color = VALUES(color),
        energy = VALUES(energy)
    ");

    $paramsVehicle = [
        ':registration' => $registration,
        ':first_registration_date' => $firstRegistrationDate,
        ':brand' => $brand,
        ':model' => $model,
        ':color' => $color,
        ':energy' => $energy,
        ':user_id' => $userId
    ];

    if (!$queryVehicle->execute($paramsVehicle)) {
        throw new Exception("Erreur lors de l'exécution de la requête véhicule :");
    }

    $vehicleId = $pdo->lastInsertId();

    if (!$vehicleId) {
        $queryFindVehicle = $pdo->prepare("SELECT vehicle_id FROM vehicle WHERE registration = :registration LIMIT 1");
        $queryFindVehicle->execute([':registration' => $registration]);
        $vehicle = $queryFindVehicle->fetch(PDO::FETCH_ASSOC);
    
        if ($vehicle) {
            $vehicleId = $vehicle['vehicle_id'];
        } else {
            throw new Exception("Aucun véhicule trouvé avec l'immatriculation '$registration'");
        }
    }
    
    if (isset($_POST['savePreferences'])) {
        $queryPreferences = $pdo->prepare("
            INSERT INTO preferences (vehicle_id, smoking, pets, other_preferences)
            VALUES (:vehicle_id, :smoking, :pets, :other_preferences)
            ON DUPLICATE KEY UPDATE
            smoking = VALUES(smoking),
            pets = VALUES(pets),
            other_preferences = VALUES(other_preferences)
        ");

        $paramsPreferences = [
            ':vehicle_id' => $vehicleId,
            ':smoking' => $smoking,
            ':pets' => $pets,
            ':other_preferences' => $preferenceText
        ];

        if (!$queryPreferences->execute($paramsPreferences)) {
            throw new Exception("Erreur lors de l'enregistrement des préférences :");
        }
    }

    $queryCarshare = $pdo->prepare("
        UPDATE carshare
        SET nb_place = :nb_place
        WHERE used_vehicle = (SELECT vehicle_id FROM vehicle WHERE belong = :user_id LIMIT 1)
    ");

    $paramsCarshare = [
        ':nb_place' => $nbPlace,
        ':user_id' => $userId
    ];

    if (!$queryCarshare->execute($paramsCarshare)) {
        throw new Exception("Échec de la mise à jour du nombre de places :" . implode(" | ", $errorInfo));
    }

    $pdo->commit();
    header('Location: account.php?update=success');
    exit();
} catch (Exception $e) {
    $pdo->rollBack();
    error_log("Erreur SQL : " . $e->getMessage());
    header("Location: account.php?error=" . urlencode($e->getMessage()));
    exit();
}
