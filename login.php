<?php 

    require_once __DIR__ . "/templates/header.php";
    require_once __DIR__ . "/lib/session.php";
    require_once __DIR__ . "/lib/pdo.php";
    require_once __DIR__ . "/lib/user.php";

    $errors = [];

    if (isset($_POST['btnLogin'])) {
        $user = verifyUserLoginPassword($pdo, $_POST['email'], $_POST['password']);

        if($user){
            $_SESSION['user'] = $user;
            header('location: index.php');
            exit();
        } else {
            $errors[] = "Email ou mot de passe incorrect.";
        }
    }
?>

<main>
    <section class="big-hero text-center">
        <div class="big-hero-content">
            <h1>Se connecter</h1>
            <p>Vous n’avez pas de compte? <a href="/register">Créez un compte</a></p>
        </div>
    </section>

    <section class="conteneur">
        <form class="conteneur-content" method="post" action="">
            <div>
                <label for="email"></label>
                <input class="input form-control" type="email" name="email" id="emailInput" placeholder="Email">
            </div>
            <div>
                <label for="password"></label>
                <input class="input password form-control" type="password" name="password" id="passwordInput" placeholder="Mot de passe">
            </div>

            <?php foreach ($errors as $error) { ?>
                <div class="alert alert-danger" role="alert">
                    <?=$error; ?>
                </div>
            <?php } ?>

            <div>
                <input class="checkbox" type="checkbox">
                <label for="">Rester connecté</label>
            </div>
            <div class="text-end">
                <a href="#">J’ai oublié mon mot de passe</a>
            </div>

                <input class="btn d-flex justify-content-center" name="btnLogin" id="btnLogin" type="submit" value="Connexion">

        </form>
    </section>
</main>

<?php require_once __DIR__ . "/templates/footer.php";?>