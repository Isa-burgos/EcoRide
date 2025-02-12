<?php 

    require_once __DIR__ . "/templates/header.php";
    require_once __DIR__ . "/lib/pdo.php";
    require_once __DIR__ . "/lib/liste-voyages.php";

    if (isset($_SESSION['user'])){
        $carshare = getTripListByUserId($pdo, $_SESSION['user']['user_id']);
    }
?>

<main>
    <section class="big-hero text-center">
        <div class="big-hero-content">
            <h1>Mon historique</h1>
        </div>
    </section>

    <section class="conteneur w-100">

    <div class="row conteneur-content">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <?php foreach($carshare as $trip) : ?>
                <h3 class="card-title text-center"><?=$trip['depart_adress'] ?><span> - </span><?=$trip['arrival_adress'] ?></h3>
                <?php endforeach; ?>
            </div>
        <div class="card-body">
            <p class="card-text">Détails du voyage</p>
            <div class="d-flex justify-content-between align-items-end mt-3">
                <a href="#" class="btn btn-primary m-0">Voir le voyage</a>
                <?php foreach($carshare as $trip) : ?>
                <span class="badge rounded-pill text-white text-bg-primary">
                    <img src="/assets/icons/<?=$trip['energy_icon']; ?>" alt="">
                </span>
                <?php endforeach; ?>
            </div>
        </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Special title treatment</h5>
            </div>
            <div class="card-body">
                <p class="card-text">Détails du voyage</p>
                <a href="#" class="btn btn-primary">Voir le voyage</a>
            </div>
        </div>
    </div>
    </div>
    </section>
</main>





<?php require_once __DIR__ . "/templates/footer.php"?>