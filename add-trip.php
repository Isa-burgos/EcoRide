<?php 
    require_once __DIR__ . "/templates/header.php";
?>

<main>
    <section class="big-hero text-center">
        <div class="big-hero-content">
            <h1>Proposer un trajet</h1>
        </div>
    </section>

    <?php if (isset($_SESSION['user'])) {?>
        <section class="conteneur">
            <form class="conteneur-content" action="">
                    <div id="step1" class="step active">
                        <h2>Mon trajet</h2>
                        <hr class="separator">
                        <div class="step-content">
                            <fieldset>
                                <legend>Adresse de départ</legend>
                                <div class="input-container">
                                    <label for="departAdress"></label>
                                    <input class="input startAdress" type="text" name="departAdress" id="departAdress" placeholder="Adresse de départ" required>
                                    <div id="suggestionsDepart" class="suggestions-container"></div>
                                    <button type="button" class="btn-geoloc" id="geolocDepart" aria-label="Utiliser ma position"></button>
                                    <div class="invalid-feedback">
                                        Ce champs est requis
                                    </div>
                                </div>
                                <div>
                                    <span>Adresse sélectionnée :</span>
                                    <span id="selectedAdressDepart"></span>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Adresse d'arrivée</legend>
                                <div class="input-container">
                                    <label for="arrivalAdress"></label>
                                    <input class="input endAdress" type="text" name="arrivalAdress" id="arrivalAdress" placeholder="Adresse d'arrivée" required>
                                    <div id="suggestionsArrival" class="suggestions-container"></div>
                                    <button type="button" class="btn-geoloc" id="geolocArrival" aria-label="Utiliser ma position"></button>
                                    <div class="invalid-feedback">
                                        Ce champs est requis
                                    </div>
                                </div>
                                <div>
                                    <span>Adresse sélectionnée :</span>
                                    <span id="selectedAdressArrival"></span>
                                </div>
                            </fieldset>
                        </div>
                        <div class="step-buttons">
                            <button type="button" class="btn btn-next">Étape suivante</button>
                        </div>
                    </div>
                    
                    <div id="step2" class="step">
                        <h2>Mon véhicule</h2>
                        <hr class="separator">
                        <div class="step-content">
                            <fieldset>
                                <legend></legend>
                                <div>
                                    <legend for="carChoice">Je choisis un véhicule</legend>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                        Véhicule 1
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                        <label class="form-check-label" for="flexCheckChecked">
                                        Véhicule 2
                                        </label>
                                    </div>
                                </div>
                                <div class="reservation">
                                    <div class="passenger-quantity p-0">
                                        <div class="passenger-icon p-2">
                                            <div class="trip-price">
                                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 7C8.5 5.93913 8.92143 4.92172 9.67157 4.17157C10.4217 3.42143 11.4391 3 12.5 3C13.5609 3 14.5783 3.42143 15.3284 4.17157C16.0786 4.92172 16.5 5.93913 16.5 7C16.5 8.06087 16.0786 9.07828 15.3284 9.82843C14.5783 10.5786 13.5609 11 12.5 11C11.4391 11 10.4217 10.5786 9.67157 9.82843C8.92143 9.07828 8.5 8.06087 8.5 7ZM8.5 13C7.17392 13 5.90215 13.5268 4.96447 14.4645C4.02678 15.4021 3.5 16.6739 3.5 18C3.5 18.7956 3.81607 19.5587 4.37868 20.1213C4.94129 20.6839 5.70435 21 6.5 21H18.5C19.2956 21 20.0587 20.6839 20.6213 20.1213C21.1839 19.5587 21.5 18.7956 21.5 18C21.5 16.6739 20.9732 15.4021 20.0355 14.4645C19.0979 13.5268 17.8261 13 16.5 13H8.5Z" fill="#59642F"/>
                                                </svg>
                                            </div>
                                            <div class="trip-passenger">
                                                <p class="m-0">Nombre de places disponibles</p>
                                            </div>
                                        </div>
                                        <div class="passenger-quantity-and-price p-2">
                                            <div class="quantity-selector">
                                                <button class="btn-quantity decrease">-</button>
                                                <input type="input" class="quantity-input" value="1" readonly>
                                                <button class="btn-quantity increase">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="">
                                        <label class="form-check-label" for="">
                                        Mon véhicule est électrique
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="">
                                        <label class="form-check-label" for="">
                                        Mon véhicule est fumeur
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="">
                                        <label class="form-check-label" for="">
                                        J'accepte les animaux de compagnie
                                        </label>
                                    </div>
                                    <div class="mb-3">
                                        <label for="otherPreferences" class="form-label">Quelque chose à ajouter?</label>
                                        <textarea class="form-control input" id="otherPreferences" rows="3" placeholder="Vous ne prenez pas l'autoroute? L'espace dans votre coffre est limité?"></textarea>
                                    </div>
                            </fieldset>
                        </div>
                        <div class="step-buttons">
                            <button type="button" class="btn btn-prev mx-2">Étape précédente</button>
                            <button type="button" class="btn btn-next mx-2">Étape suivante</button>
                        </div>
                    </div>
                    <div id="step3" class="step">
                        <h2>Date et heure</h2>
                        <hr class="separator">
                        <div class="step-content">
                            <fieldset>
                                <legend>Départ</legend>
                                <div>
                                    <div>
                                        <div>
                                            <label for="">Jour</label>
                                            <input class="input form-control" type="date" required>
                                        </div>
                                        <div>
                                            <fieldset>
                                                <legend>Heure</legend>
                                                <select class="input" name="hour" id="hour">
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                </select>
                                                <label for="minute">min</label>
                                                <select class="input" name="minute" id="minute">
                                                    <option value="00">00</option>
                                                    <option value="15">15</option>
                                                    <option value="30">30</option>
                                                    <option value="45">45</option>
                                                </select>
                                                <label for="hour">h</label>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="">Je partirai</label>
                                        <select class="input" name="" id="">
                                            <option value="0" selected>A l'heure indiquée</option>
                                            <option value="15">+/- 15 minutes</option>
                                            <option value="30">+/- 30 minutes</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="step-buttons">
                            <button type="button" class="btn btn-prev mx-2">Étape précédente</button>
                            <button type="button" class="btn btn-next mx-2">Étape suivante</button>
                        </div>
                    </div>
                    <div id="step4" class="step">
                        <h2>Itinéraire et coût</h2>
                        <hr class="separator">
                        <div class="step-content">
                            <fieldset>
                                <legend>Itinéraire</legend>
                                <div>
                                    <p>Votre itinéraire fait <strong>x km</strong> et vous empruntez une route à péage</p>
                                    <br>
                                    <a href="">Visualiser ou modifier</a>
                                </div>
                                <div>
                                    <input type="checkbox">
                                    <label for="">Je souhaite éviter les péages</label>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Prix du trajet</legend>
                                <div class="reservation">
                                    <div class="passenger-quantity p-0">
                                        <div class="passenger-icon p-2">
                                            <div class="trip-passenger">
                                                <p class="m-0">Prix par passager (€)</p>
                                            </div>
                                        </div>
                                        <div class="passenger-quantity-and-price p-2">
                                            <div class="quantity-selector">
                                                <button class="btn-quantity decrease">-</button>
                                                <input type="input" class="quantity-input" value="1" readonly>
                                                <button class="btn-quantity increase">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="step-buttons">
                            <button type="button" class="btn btn-prev mx-2">Étape précédente</button>
                            <button type="button" class="btn btn-next mx-2">Étape suivante</button>
                        </div>
                    </div>
                    <div id="step5" class="step">
                        <h2>Publication</h2>
                        <hr class="separator">
                        <div class="step-content">
                            <fieldset>
                                <legend>Mon trajet</legend>
                                <div>
                                    <div>
                                        <p>Départ : <span>Villeneuve-de-Berg</span></p>
                                        <p>Arrivée : <span>Valence</span></p>
                                    </div>
                                    <div>
                                        <p>Distance : <span>90 km</span></p>
                                        <p>Durée théorique : <span>1h05</span></p>
                                    </div>
                                    <a href="#">Modifier</a>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Mon véhicule</legend>
                                <div>
                                    <div>
                                        <p>Places disponibles : <span>3</span></p>
                                        <p>Véhicule thermique</p>
                                        <p>Véhicule non fumeur</p>
                                        <p>Pas d'animaux de compagnie</p>
                                        <p>Autres commentaires</p>
                                    </div>
                                    <a href="#">Modifier</a>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Date et heure</legend>
                                <div>
                                    <p>Départ le <span> date </span>à<span> heure </span></p>
                                    <p>Je partirai <span> à l'heure indiquée </span></p>
                                </div>
                                <a href="#">Modifier</a>
                            </fieldset>
                            <fieldset>
                                <legend>Prix</legend>
                                <div>
                                    <p>Prix par passager :<span> 5€</span></p>
                                </div>
                                <a href="#">Modifier</a>
                            </fieldset>
                            <p>En publiant une annonce en tant que conducteur, vous attestez être en possession d'un permis de conduire en cours de validité et d'un véhicule correctement assuré dont le contrôle technique est à jour.</p>
                        </div>
                        <div class="step-buttons">
                            <button type="button" class="btn btn-prev mx-2">Étape précédente</button>
                            <button type="submit" class="btn btn-submit mx-2">Créer mon annonce</button>
                        </div>
                    </div>
                </form>
            </section>
            <?php } else { ?>
                <div class="container conteneur pt-5">
                    <div class="conteneur-content d-flex justify-content-center flex-wrap">
                        <p class="text-center">Connectez-vous pour ajouter un trajet</p>
                        <a href="/login.php" class="btn">Je me connecte</a>
                    </div>
    
            <?php } ?>
                </div>

</main>

<?php require_once __DIR__ . "/templates/footer.php"?>
