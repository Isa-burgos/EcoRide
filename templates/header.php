<?php
  require_once __DIR__ . "/../lib/session.php";

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/main.min.css">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
      crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
      integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
      crossorigin=""></script>
    <script src="/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/account.js" defer></script>
    <script src="/js/geolocation.js" defer></script>
    <script src="/js/quantity.js" defer></script>
    <script src="/js/addTrip.js" defer></script>
    <script src="/js/register.js" defer></script>
    <script src="/js/login.js" defer></script>
    <title>EcoRide</title>
</head>
<body>

    <!-- START HEADER -->
    <header class="fixed-top">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="header-nav container-fluid mx-3">
              <a class="navbar-brand" href="/">
                <img src="/assets/icons/Logo.svg" alt="Logo" width="112" height="49">
              </a>
              <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
                  </svg>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                  <li class="nav-item">
                    <a class="nav-link" href="/covoiturages.php">Covoiturages</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/contact.php">Contact</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link required-connexion-btn" href="/trip.php">Proposer un trajet</a>
                  </li>
                  <?php if (isUserConnected()){ ?>
                    <li class="nav-item">
                      <a class="nav-link" href="/dashboard.php">Mon compte</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="/logout.php">Déconnexion</a>
                    </li>
                      
                    <?php } else { ?>
                    <li class="nav-item">
                      <a class="nav-link" href="/login.php">Se connecter</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="/register.php">Créer un compte</a>
                    </li>

                    <?php } ?>
                </ul>
              </div>
            </div>
          </nav>
    </header>

    <!-- END HEADER -->