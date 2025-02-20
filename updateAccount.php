<?php

require_once __DIR__ . "/lib/pdo.php";
require_once __DIR__ . "/lib/session.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST["updateProfile"])) {
    header("Location: /account.php?error=invalid_access");
    exit();
}

$userId = $_SESSION['user']['user_id'] ?? null;
if (!$userId) {
    header("Location: /login.php");
    exit();
}

$userId = $_SESSION['user']['user_id'];
$name = htmlspecialchars(trim($_POST['name'] ?? ''));
$firstname = htmlspecialchars(trim($_POST['firstname'] ?? ''));
$pseudo = htmlspecialchars(trim($_POST['pseudo'] ?? ''));
$birthDate = htmlspecialchars(trim($_POST['birth_date'] ?? ''));
$gender = !empty($_POST['gender']) ? trim($_POST['gender']) : "non spécifié";
$phone = !empty($_POST['phone']) ? trim($_POST['phone']) : "0000000000";

$uploadDir = "upload/profile_pictures/";
$photoPath = $_SESSION['user']['photo'] ?? null;

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0775, true);
}

if(isset($_FILES['photo']) && !empty($_FILES['photo']['name'])){
    $photoTmpPath = $_FILES['photo']['tmp_name'];
    $photoName = basename($_FILES['photo']['name']);
    $photoSize = $_FILES['photo']['size'];
    $photoError = $_FILES['photo']['error'];
    $photoExt = strtolower(pathinfo($photoName, PATHINFO_EXTENSION));

    $allowedExts = ["jpg", "jpeg", "png"];

    if($photoError === 0 && in_array($photoExt, $allowedExts) && $photoSize <= 2 * 1024 * 1024){
        $newFileName = "profile_" . $userId . "." . $photoExt;
        $photoPath = $uploadDir . $newFileName;

        if(!move_uploaded_file($photoTmpPath, $photoPath)){
            header("Location: /account.php?error=upload_failed");
            exit();
        }
    } else {
        header("Location: /account.php?error=invalid_photo");
        exit();
    }
}

if (empty($name) || empty($firstname) || empty($pseudo) || empty($birthDate) || empty($gender) || empty($phone)) {
    header("Location: /account.php?error=missing_fields");
    exit();
}

try {
    $pdo->beginTransaction();

    $query = $pdo->prepare("
        UPDATE user SET
            name = :name,
            firstname = :firstname,
            pseudo = :pseudo,
            birth_date = :birth_date,
            gender = :gender,
            phone = :phone"
            . (!empty($photoPath) ? ", photo = :photo" : "") . "
        WHERE user_id = :user_id
    ");
    $query->bindValue(':name', $name, PDO::PARAM_STR);
    $query->bindValue(':firstname', $firstname, PDO::PARAM_STR);
    $query->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
    $query->bindValue(':birth_date', $birthDate, PDO::PARAM_STR);
    $query->bindValue(':gender', $gender, PDO::PARAM_STR);
    $query->bindValue(':phone', $phone, PDO::PARAM_STR);
    if(!empty($photoPath)){
        $query->bindValue(':photo', $photoPath, PDO::PARAM_STR);
    }
    $query->bindValue(':user_id', $userId, PDO::PARAM_INT);

    $result = $query->execute();

    if (!$result) {
        throw new Exception("Erreur lors de l'exécution de la requête SQL de mise à jour du profil.");
    }

    if(isset($_POST['statuts']) && is_array($_POST['statuts'])) {
        $queryDelete = $pdo->prepare("DELETE FROM user_statut WHERE user_id = :user_id");
        $queryDelete->execute([':user_id' => $userId]);

        $queryInsert = $pdo->prepare("INSERT INTO user_statut (user_id, statut_id) VALUES (:user_id, :statut_id)");
        foreach($_POST['statuts'] as $statutId) {
            $queryInsert->execute([
                ':user_id'   => $userId,
                ':statut_id' => $statutId
            ]);
        }
    }
    
    $_SESSION['user']['name'] = $name;
    $_SESSION['user']['firstname'] = $firstname;
    $_SESSION['user']['pseudo'] = $pseudo;
    $_SESSION['user']['birth_date'] = $birthDate;
    $_SESSION['user']['gender'] = $gender;
    $_SESSION['user']['phone'] = $phone;
    if(!empty($photoPath)){
        $_SESSION['user']['photo'] = $photoPath;
    }

    $pdo->commit();
    header('Location: /account.php?update=success');
    exit();
} catch (Exception $e) {
    $pdo->rollBack();
    error_log("Erreur SQL : " . $e->getMessage());
    header("Location: /account.php?error=" . urlencode($e->getMessage()));
    exit();
}