<?php
  require_once __DIR__ . "/../lib/session.php";

  // ✅ Test pour voir si quelque chose est envoyé avant le DOCTYPE
  if (headers_sent($file, $line)) {
      die("❌ Erreur : Des en-têtes ont déjà été envoyés dans $file à la ligne $line.");
  }
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/main.min.css">
    <script src="/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/script.js/" defer></script>
    <script src="/js/addTrip.js" defer></script>
    <script src="/js/account.js" defer></script>
    <title>EcoRide</title>
</head>
<body>

    <!-- START HEADER -->
    <header class="fixed-top">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="header-nav container-fluid mx-3">
              <a class="navbar-brand" href="/">
                <img src="/assets/img/Logo.svg" alt="Logo" width="112" height="49">
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
                    <a class="nav-link required-connexion-btn" href="/add-trip.php">Proposer un trajet</a>
                  </li>
                  <?php if (isset($_SESSION['user'])){ ?>
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