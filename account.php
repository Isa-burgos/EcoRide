<?php 
    require_once __DIR__ . "/templates/header.php";
    require_once __DIR__ . "/lib/session.php";

    if(!isset($_SESSION['user'])){
        header('location: /login.php');
        exit();
    }

    $user = $_SESSION['user'];

    $birthDate = !empty($user['birth_date']) ? (new DateTime($user['birth_date']))->format('Y-m-d') : '';
    ?>

<main>
    <section class="big-hero text-center">
        <div class="big-hero-content">
            <h1>Mon compte</h1>
        </div>
    </section>
    
    <section class="conteneur">
        <div class="formulaire-title m-auto">
            <h2>Informations générales</h2>
        </div>
    
        <form class="form conteneur-content" method="POST" action="update-account.php">
            <div class="d-flex pt-2">
                <div class="me-2">
                    <input type="radio" id="homme" name="genre" value="homme" <?= ($user['gender'] == 'homme') ? 'checked' : '' ?>>
                    <label for="homme">Homme</label>
                </div>
                <div>
                    <input type="radio" id="femme" name="genre" value="femme" <?= ($user['gender'] == 'femme') ? 'checked' : '' ?>>
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
                <label for="phoneNumber"></label>
                <input class="input" type="text" name="phoneNumber" id="phone" placeholder="0606060606" value="">
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
                <input class="checkbox" type="checkbox" id="isPassenger">
                <label for="isPassenger">Je suis passager</label>
            </div>
            <div>
                <input class="checkbox checkbox-driver" type="checkbox" id="isDriver">
                <label for="isDriver">Je suis conducteur</label>
    
                <div class="hidden-content">
                    <div class="formulaire-title mx-auto mt-2">
                        <h2>Mon véhicule</h2>
                    </div>
        
                    <div>
                        <label for="immat">Plaque d'immatriculation</label>
                        <input class="input" type="text" name="immat" id="immat" placeholder="XX-111-XX" value="XX-111-XX">
                    </div>
                    <div>
                        <label for="immat-date">Date de la première immatriculation</label>
                        <input class="input" type="date" name="immat-date" id="immat-date" placeholder="01/01/2020" value="01/01/2020">
                    </div>
                    <div>
                        <label for="carBrand">Marque</label>
                        <select class="form-select input" aria-label="select marque voiture" id="carBrand" name="carBrand">
                            <option value="">Sélectionner une marque</option>
                        </select>
                    </div>
                    <div>
                        <label for="carModel">Modèle</label>
                        <select class="form-select input" aria-label="select modele voiture" id="carModel" name="carModel" disabled>
                            <option value="">Sélectionner un modèle</option>
                        </select>
                    </div>
                    <div>
                        <label for="carColor">Couleur</label>
                        <select class="form-select input" aria-label="select couleur voiture" id="carColor" name="carColor">
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
                        <a href="#">Ajouter un véhicule</a>
                    </div>
                    <div>
                        <label for="place">Places disponibles</label>
                        <select class="form-select input" aria-label="select marque voiture" id="marque" name="marque">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
        
                    <div class="formulaire-title">
                        <div class="formulaire-title">
                            <h2>Préférences</h2>
                        </div>
                        <fieldset>
                            <legend>Fumeur</legend>
                            <div class="d-flex">
                                <div class="me-3 mb-2">
                                    <input type="radio" checked>
                                    <label for="">Oui</label>
                                </div>
                                <div>
                                    <input type="radio">
                                    <label for="">Non</label>
                                </div>
                            </div>
                        </fieldset>
                        </div>
                        <fieldset>
                            <legend>Animal</legend>
                            <div class="d-flex">
                                <div class="me-3 mb-2">
                                    <input type="radio" checked>
                                    <label for="">Oui</label>
                                </div>
                                <div>
                                    <input type="radio">
                                    <label for="">Non</label>
                                </div>
                            </div>
                            <div class="formulaire-title">
                                <a href="#">Ajouter une préférence</a>
                            </div>
                </div>
            </div>
        </form>
    </section>
    
    <button class="btn d-flex justify-content-center" type="submit">Mettre à jour</button>
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
    
    <!-- Modal -->
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