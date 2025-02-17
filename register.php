<?php

require_once __DIR__ . "/templates/header.php";
require_once __DIR__ . "/lib/registration.php";
require_once __DIR__ . "/lib/pdo.php";
require_once __DIR__ . "/lib/session.php";

$gender = $_POST['gender'] ?? '';
$name = htmlspecialchars(trim($_POST['name'] ?? ''));
$firstname = htmlspecialchars(trim($_POST['firstname'] ?? ''));
$birthDate = htmlspecialchars(trim($_POST['birth_date'] ?? ''));
$email = htmlspecialchars(trim($_POST['email'] ?? ''));
$password = trim($_POST['password'] ?? '');
$possess = $_POST['possess'] ?? 1;

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registration'])){
    $query = $pdo->prepare('SELECT COUNT(*) FROM user WHERE email = :email');
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $emailExists = $query->fetchColumn();
    if($emailExists > 0){
        $errors[] = "Un compte existe déjà avec cet e-mail";
    } else{
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $result = registration($pdo, $gender, $name, $firstname, $birthDate, $email, $hashedPassword, $possess);
    }
    if($result){
        $userQuery = $pdo->prepare("SELECT * FROM user WHERE email = :email");
        $userQuery->bindValue(':email', $email, PDO::PARAM_STR);
        $userQuery->execute();
        $user = $userQuery->fetch(PDO::FETCH_ASSOC);

        if($user){
            $_SESSION['user'] = [
                'user_id' => $user['user_id'],
                'gender' => $user['gender'],
                'name' => $user['name'],
                'birth_date' => $user['birth_date'],
                'firstname' => $user['firstname'],
                'email' => $user['email'],
                'possess' => $user['possess'],
            ];
            header('location: /account.php');
            exit();
        }

    } else{
        $errors[] = "Erreur lors de l'inscription";
    }
}

?>


<main>
    <section class="big-hero text-center">
        <div class="big-hero-content">
            <h1>Créer un compte</h1>
            <p>Vous avez déjà un compte? <a href="/login">Identifiez-vous</a></p>
    </section>
    
    <section class="conteneur">
        <?php if(!empty($errors)) : ?>
            <div class="alert alert-danger">
                <?php foreach($errors as $error): ?>
                    <?= htmlspecialchars($error) ?>
                <?php endforeach ?>
            </div>
        <?php endif ?>

        <form class="conteneur-content" method="post" action="register.php">
            <div class="d-flex pt-2">
                <div class="me-2">
                    <input type="radio" name="gender" value="homme" checked>
                    <label for="gender">Homme</label>
                </div>
                <div>
                    <input type="radio" name="gender" value="femme">
                    <label for="gender">Femme</label>
                </div>
            </div>
            <div>
                <label for="nameInput"></label>
                <input class="input form-control" name="name" id="nameInput" type="text" placeholder="Nom" required>
                <div class="invalid-feedback">
                    Le nom est requis
                </div>
            </div>
            <div>
                <label for="firstnameInput"></label>
                <input class="input form-control" name="firstname" type="text" id="firstnameInput" placeholder="Prénom" required>
                <div class="invalid-feedback">
                    Le prénom est requis
                </div>
            </div>
            <div>
                <label for="birth_date">Date de naissance</label>
                <input type="date" class="form-control input" aria-label="select annee de naissance" name="birth_date" required>
                <div class="invalid-feedback">
                    Veuillez indiquer votre date de naissance
                </div>
            <div>
                <label for="emailInput"></label>
                <input class="input form-control" type="email" name="email" id="emailInput" placeholder="Email" value="">
                <div class="invalid-feedback">
                    L'e-mail n'est pas au bon format
                </div>
            </div>
            <div>
                <label for="passwordInput"></label>
                <input class="input form-control password" type="password" id="passwordInput" placeholder="Mot de passe" value="">
                <div class="invalid-feedback">
                    Le mot de passe doit comporter au moins 8 caractères dont 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial
                </div>
            </div>
            <div>
                <label for="passwordValidateInput"></label>
                <input class="input form-control password" type="password" id="passwordValidateInput" placeholder="Confirmer le mot de passe" value="">
                <div class="invalid-feedback">
                    La confirmation n'est pas identique au mot de passe
                </div>
            </div>
            <div>
                <input class="checkbox" type="checkbox" required>
                <label for="">En cliquant sur “Valider”, vous acceptez les conditions générales d’utilisation et certifiez avoir plus de 18 ans</label>
            </div>
                <input class="btn d-flex justify-content-center" type="submit" value="Inscription" name="registration" id="btn-validation-inscription">
        </form>
    </section>
</main>

<?php require_once __DIR__ . "/templates/footer.php"?>