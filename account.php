<?php 
    require_once __DIR__ . "/templates/header.php";
    require_once __DIR__ . "/lib/session.php";
    require_once __DIR__ . "/lib/pdo.php";

    if(!isset($_SESSION['user'])){
        header('location: /login.php');
        exit();
    }

    $user = $_SESSION['user'];
    $userId = $user['user_id'];

    $birthDate = !empty($user['birth_date']) ? (new DateTime($user['birth_date']))->format('Y-m-d') : '';

    $query = $pdo->prepare("SELECT * FROM vehicle WHERE belong = :user_id");
    $query->execute([':user_id' => $_SESSION['user']['user_id']]);
    $vehicles = $query->fetchAll(PDO::FETCH_ASSOC);

    $queryStatut = $pdo->query("SELECT statut_id, name FROM statut");
    $statuts = $queryStatut->fetchAll(PDO::FETCH_ASSOC);

    $queryUserStatuts = $pdo->prepare("SELECT statut_id FROM user_statut WHERE user_id = :user_id");
    $queryUserStatuts->execute([':user_id' => $userId]);
    $userStatuts = $queryUserStatuts->fetchAll(PDO::FETCH_COLUMN, 0);

    ?>

<main>
    <section class="big-hero text-center">
        <div class="big-hero-content">
            <h1>Mon compte</h1>
        </div>
    </section>
    
    <section class="conteneur">
    <?php if (isset($_GET['update']) && $_GET['update'] == 'success'): ?>
        <div class="alert alert-success">Votre véhicule a été enregistré avec succès !</div>
    <?php elseif (isset($_GET['update']) && $_GET['update'] == 'error'): ?>
        <div class="alert alert-danger">Une erreur est survenue, veuillez réessayer.</div>
    <?php endif; ?>
        <div class="formulaire-title m-auto">
            <h2>Informations générales</h2>
        </div>
    
        <form class="form conteneur-content" method="POST" action="updateAccount.php" enctype="multipart/form-data">
            <div class="d-flex pt-2">
                <div class="me-2">
                    <input type="radio" id="homme" name="gender" value="homme" <?= ($user['gender'] == 'homme') ? 'checked' : '' ?>>
                    <label for="homme">Homme</label>
                </div>
                <div>
                    <input type="radio" id="femme" name="gender" value="femme" <?= ($user['gender'] == 'femme') ? 'checked' : '' ?>>
                    <label for="femme">Femme</label>
                </div>
            </div>
    
            <div>
                <label for="name"></label>
                <input class="input" type="text" name="name" id="name" placeholder="Nom" value="<?= htmlspecialchars($user['name'])?>">
            </div>
            <div>
                <label for="firstname"></label>
                <input class="input" type="text" name="firstname" id="firstname" placeholder="Prénom" value="<?= htmlspecialchars($user['firstname'])?>">
            </div>
            <div>
                <label for="pseudo"></label>
                <input class="input form-control" name="pseudo" type="text" id="pseudo" placeholder="Pseudo" value="<?= htmlspecialchars($user['pseudo'] ??'')?>" required>
                <div class="invalid-feedback">
                    Le pseudo est requis
                </div>
            </div>
            <div>
                <label for="phoneNumber">Téléphone</label>
                <input class="input" type="text" name="phone" id="phone" placeholder="0606060606" value="<?= htmlspecialchars($user['phone'] ?? '')?>">
            </div>
            <div>
                <label for="birth_date">Date de naissance</label>
                <input type="date" class="input" name="birth_date" value="<?= htmlspecialchars($birthDate)?>">
            </div>
            <div>
                <label for="email"></label>
                <input class="input" type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($user['email'])?>">
            </div>
            <div>
                <label for="photo">Ajoutez votre photo de profil :</label>
                <input type="file" class="input" id="photo" name="photo" accept="image/png, image/jpeg, image/jpg" />
            </div>
            <div>
                <label>Photo de profil :</label>
                <img src="<?= htmlspecialchars($_SESSION['user']['photo'] ?? '/assets/default-profile.png') ?>" alt="profil de l'utilisateur" width="150">
            </div>
            
            <div>
                <input class="checkbox" type="checkbox" id="isPassenger" name="statuts[]" value="1" <?php if(in_array(1, $userStatuts)) echo 'checked="checked"'; ?>>
                <label for="isPassenger">Je suis passager</label>
            </div>
            <div>
                <input class="checkbox checkbox-driver" type="checkbox" id="isDriver" name="statuts[]" value="2" <?php if(in_array(2, $userStatuts)) echo 'checked="checked"'; ?>>
                <label for="isDriver">Je suis conducteur</label>
                <div class="hidden-content">
                    <h3>Véhicules enregistrés</h3>
                    <?php if (!empty($vehicles)): ?>
                        <ul class="p-0">
                            <?php foreach ($vehicles as $vehicle): ?>
                                <li class="card my-3 mx-auto w-75 bg-light">
                                    <strong><?= htmlspecialchars($vehicle['brand']) . " " . htmlspecialchars($vehicle['model']) ?></strong> 
                                    (<?= htmlspecialchars($vehicle['color']) ?>) 
                                    <br> Immatriculation : <?= htmlspecialchars($vehicle['registration']) ?>
                                    <div class="card-footer">
                                        supprimer
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>Pas de véhicule enregistré</p>
                    <?php endif; ?>
                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#addVehicleModal">Ajouter un véhicule</button>
            </div>

            </div>
            <button class="btn d-flex justify-content-center" name="updateProfile" type="submit">Mettre à jour</button>
        </form>
    </section>
    
    
    <section class="conteneur page my-3">
        <div class="formulaire-title mx-auto mb-3">
            <h2>Mot de passe</h2>
        </div>
        <div class="formulaire-title m-auto">
            <a href="#">Modifier mon mot de passe</a>
        </div>
    </section>
    <section class="conteneur">
        <div class="formulaire-title mx-auto mb-3">
            <h2>Supprimer mon compte</h2>
        </div>
        <div class="formulaire-title m-auto">
            <p>La suppression de compte est définitive. Vos données personnelles ainsi que vos annonces seront supprimées.</p>
        </div>
        <button class="btn btn-danger d-flex justify-content-center" type="submit" data-bs-toggle="modal" data-bs-target="#suppressionModal">Supprimer mon compte</button>
    </section>
    <div style="height: 1rem;"></div>

    <!-- Modal add vehicle-->
    <div class="modal fade" id="addVehicleModal" tabindex="-1" aria-labelledby="addVehicleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content bg-secondary">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="addVehicleModalLabel">Ajouter un véhicule</h1>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="updateVehicle.php" method="post">
                    <div class="formulaire-title mx-auto mt-2">
                        <div>
                            <label for="registration">Plaque d'immatriculation</label>
                            <input class="input" type="text" name="registration" id="registration" placeholder="XX-111-XX" value="" required>
                        </div>
                        <div>
                            <label for="first_registration_date">Date de la première immatriculation</label>
                            <input class="input" type="date" name="first_registration_date" id="first_registration_date" placeholder="01/01/2020" value="" required>
                        </div>
                        <div>
                            <label for="brand">Marque</label>
                            <select class="form-select input" aria-label="select marque voiture" id="carBrand" name="brand" required>
                                <option value="">Sélectionner une marque</option>
                            </select>
                        </div>
                        <div>
                            <label for="model">Modèle</label>
                            <select class="form-select input" aria-label="select modele voiture" id="carModel" name="model" disabled>
                                <option value="">Sélectionner un modèle</option>
                            </select>
                        </div>
                        <div>
                            <label for="color">Couleur</label>
                            <select class="form-select input" aria-label="select couleur voiture" id="carColor" name="color" required>
                                <option value="">Sélectionnez une couleur</option>
                                <option value="blanc">Blanc</option>
                                <option value="noir">Noir</option>
                                <option value="gris">Gris</option>
                                <option value="bleu">Bleu</option>
                                <option value="rouge">Rouge</option>
                                <option value="vert">Vert</option>
                                <option value="jaune">Jaune</option>
                                <option value="orange">Orange</option>
                                <option value="marron">Marron</option>
                                <option value="violet">Violet</option>
                                <option value="rose">Rose</option>
                                <option value="beige">Beige</option>
                            </select>
                        </div>
                        <div class="formulaire-title mb-3">
                        </div>
                        <div>
                            <label for="nb_place">Places disponibles</label>
                            <select class="form-select input" aria-label="select places disponibles" id="nb_place" name="nb_place" required>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                        <fieldset>
                            <legend>véhicule électrique</legend>
                            <div class="d-flex">
                                <div class="me-3">
                                    <input type="radio" id="electric_yes" name="energy" value="1" checked>
                                    <label for="electric_yes">Oui</label>
                                </div>
                                <div>
                                    <input type="radio" id="electric_no" name="energy" value="0">
                                    <label for="electric_no">Non</label>
                                </div>
                            </div>
                        </fieldset>
            
                        <div class="formulaire-title">
                            <div class="formulaire-title">
                                <h2>Préférences</h2>
                            </div>
                            <fieldset>
                                <legend>Fumeur</legend>
                                <div class="d-flex">
                                    <div class="me-3 mb-2">
                                        <input type="radio" id="smoking_yes" name="smoking" value="1">
                                        <label for="smoking_yes">Oui</label>
                                    </div>
                                    <div>
                                        <input type="radio" id="smoking_no" name="smoking" value="0" checked>
                                        <label for="smoking_no">Non</label>
                                    </div>
                                </div>
                            </fieldset>
                            </div>
                            <fieldset>
                                <legend>Animaux acceptés</legend>
                                <div class="d-flex">
                                    <div class="me-3 mb-2">
                                        <input type="radio" id="pets_yes" name="pets" value="1">
                                        <label for="pets_yes">Oui</label>
                                    </div>
                                    <div>
                                        <input type="radio" id="pets_no" name="pets" value="0" checked>
                                        <label for="pets_no">Non</label>
                                    </div>
                                </div>
                            </fieldset>
                            
                                <div class="formulaire-title input">
                                    <label for="other_preferences">Ajouter une préférence</label>
                                    <textarea name="other_preferences" id="preference"></textarea>
                                    <input type="hidden" name="savePreferences" value="1">
                                    <button type="button" class="btn" onclick="alert('Les préférences seront enregistrées lors de la soumission du formulaire')">Ajouter</button>
                                </div>
                                <div class="container d-flex justify-content-center">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-secondary" name="saveVehicle">Enregistrer le véhicule</button>
                                </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
    </div>
    
    <!-- Modal suppression-->
    <div class="modal fade" id="suppressionModal" tabindex="-1" aria-labelledby="suppressionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content bg-secondary">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="suppressionModalLabel">Supprimer mon compte</h1>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container mt-3 text-center">
                    <p>Voulez-vous vraiment supprimer votre compte ?</p>
                    <div class="container d-flex justify-content-center">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-secondary">Confirmer la suppression</button>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
</main>

<?php require_once __DIR__ . "/templates/footer.php"?>