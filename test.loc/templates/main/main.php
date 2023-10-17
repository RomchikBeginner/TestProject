<?php include __DIR__ . '/../header.php'; ?>
    <section class="Testimonials">
        <div class="container">
            <h2 class="heading">Clients</h2>
            <div class="cards-profiles" id="cards-profiles">
                <?php foreach ($profiles as $profile): ?>
                <button>
                    <a href="clients/<?= $profile->getId()?>/delete" id="link-delete">X</a>
                </button>
                    <a href="/clients/<?= $profile->getId() ?>/edit" class="link-pofile">
                <div class="card-profile">
                    <div class="box-image">
                        <img class="card-profile-image" src="images/profile-card.png" alt="">
                    </div>
                    <div class="profile-info">
                        <div class="profile-text">
                            <p>
                                <?= $profile->getEmail() ?>
                            </p>
                        </div>
                        <span class="profile-name"><?= $profile->getFirstName() ?> <?= $profile->getLastName() ?> </span>
                    </div>
                </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <div style="text-align: center">
    <?php for ($pageNum = 1; $pageNum <= $pagesCount; $pageNum++): ?>
        <?php if ($currentPageNum === $pageNum): ?>
            <b class="page"><?= $pageNum ?></b>
        <?php else: ?>
            <a href="/<?= $pageNum === 1 ? '' : $pageNum ?>" class="page"><?= $pageNum ?></a>
        <?php endif; ?>
    <?php endfor; ?>
    </div>
<?php include __DIR__ . '/../footer.php'; ?>