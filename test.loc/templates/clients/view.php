<?php include __DIR__ . '/../header.php'?>
<section class="Testimonials">
        <div class="container">
            <h2 class="heading">Testimonials</h2>
            <div class="cards-profiles">
                <div class="card-profile">
                    <div class="box-image">
                        <img class="card-profile-image" src="/images/profile-card.png" alt="">
                    </div>
                    <div class="profile-info">
                        <div class="profile-text">
                            <p>
                            <?= $client->getLastName() ?> <?= $client->getFirstName() ?>
                            </p>
                            <p>
                            <?= $client->getEmail() ?>
                            </p>
                        </div>
                        <span class="profile-name"><?= $clientProfile->getPosition() ?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php include __DIR__ . '/../footer.php'?>
