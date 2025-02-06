<?php require __DIR__ . '/../layouts/header.view.php'; ?>
    <link rel="stylesheet" href="/assets/css/instructors.css">

    <main class="instructors-content">
        <div class="instructors-header">
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="?url=instructor/create" class="btn btn-primary add-instructor-btn">Pridať inštruktora</a>
            <?php endif; ?>
            <h2 class="instructors-title">Naši inštruktori</h2>
            <p class="instructors-subtitle">
                Naši skúsení inštruktori vám pomôžu zvládnuť pravidlá cestnej premávky, získate istotu za volantom a budete pripravení na skúšky.
                S nami je výučba efektívna a bezpečná! 🚗💨
            </p>
        </div>

        <div class="instructors-container">
            <?php foreach ($instructors as $inst): ?>
                <div class="instructor-card">
                    <h3 class="instructor-name"><?= htmlspecialchars($inst['name']) ?></h3>
                    <p class="instructor-info"><strong>Email:</strong> <?= htmlspecialchars($inst['email']) ?></p>
                    <p class="instructor-info"><strong>Telefón:</strong> <?= htmlspecialchars($inst['phone']) ?></p>
                    <p class="instructor-info"><strong>Špecializácia:</strong> <?= htmlspecialchars($inst['specialization']) ?></p>
<!--                    <p class="instructor-info"><strong>Skúsenosti:</strong> --><?php //= htmlspecialchars($inst['experience_years']) ?><!-- rokov</p>-->
                    <div class="photo-container">
                        <img src="<?= htmlspecialchars($inst['photo_path']) ?>" alt="Foto inštruktora" class="instructor-photo">
                        <div class="hover-info">
                            <?php
                            $experience = (int) htmlspecialchars($inst['experience_years']);
                            $specialization = htmlspecialchars($inst['specialization']);

                            $message = '';
                            if ($specialization == 'Skupina A') {
                                $message = "Učí ľudí vodiť motocykel už viac ako {$experience} rokov.";
                            } elseif ($specialization == 'Skupina B') {
                                $message = "Obučuje ľudí vodiť autá už viac ako {$experience} rokov.";
                            } elseif ($specialization == 'Skupina C') {
                                $message = "Obučuje ľudí vodiť nákladné vozidlá už viac ako {$experience} rokov.";
                            } elseif ($specialization == 'Skupina A, B') {
                                $message = "Obučuje ľudí vodiť motocykle a autá už viac ako {$experience} rokov.";
                            } elseif ($specialization == 'Skupina B, C') {
                                $message = "Obučuje ľudí vodiť autá a nákladné vozidlá už viac ako {$experience} rokov.";
                            } elseif ($specialization == 'Skupina A, B, C') {
                                $message = "Obučuje ľudí vodiť motocykle, autá a nákladné vozidlá už viac ako {$experience} rokov.";
                            }
                            ?>
                            <div class="overlay"></div>
                            <p class="instructor-experience"><?= $message ?></p>
                        </div>
                    </div>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <div class="admin-buttons">
                            <a href="?url=instructor/edit&id=<?= $inst['id'] ?>" class="btn btn-warning">Upraviť</a>
                            <a href="?url=instructor/delete&id=<?= $inst['id'] ?>" class="btn btn-danger"
                               onclick="return confirm('Naozaj chcete odstrániť inštruktora?');">Vymazať</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

<?php require __DIR__ . '/../layouts/footer.view.php'; ?>