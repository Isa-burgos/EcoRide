<?php 

    require_once __DIR__ . "/templates/header.php";
    require_once __DIR__ . "/lib/pdo.php";
    require_once __DIR__ . "/lib/liste-voyages.php";
    require_once __DIR__ . "/lib/session.php";

    if (isUserConnected()){
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

            <?php if(!empty($carshare)) : ?>
                <?php foreach($carshare as $trip) : ?>
                    <div class="col-sm-6">
                        <div class="card input p-1">
                            <div class="card-header">
                                <h3 class="card-title text-center">
                                    <?=htmlspecialchars($trip['depart_adress']) ?><span> - </span><?=htmlspecialchars($trip['arrival_adress']) ?>
                                </h3>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    Départ : <?= (new DateTime($trip['depart_time']))->format('G\hi') ?> - Arrivée : <?= (new DateTime($trip['arrival_time']))->format('G\hi') ?>
                                </p>
                                <p class="card-text">
                                    Places disponibles : <?= ($trip['nb_place']) ?>
                                </p>
                                <p class="card-text">
                                    Prix par passagers : <?= ($trip['price_person']) ?> crédits
                                </p>
                                <div class="d-flex justify-content-between align-items-end mt-3">
                                    <a href="#" class="btn btn-primary m-0">Voir le voyage</a>
                                    <span class="badge rounded-pill text-white text-bg-primary">
                                        <img src="/assets/icons/<?=htmlspecialchars($trip['energy_icon']); ?>" alt="">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-center">Aucun trajet enregistré.</p>
            <?php endif; ?>
        </div>
    </section>
</main>





<?php require_once __DIR__ . "/templates/footer.php"?>