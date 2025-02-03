<?php require __DIR__ . '/../layouts/header.view.php'; ?>

<main class="auta-content">
    <div>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="?url=instructor/create" class="btn btn-primary" style="float: right; margin: 10px;">Pridať inštruktora</a>
        <?php endif; ?>
        <h2 class="stranka-title">Naši inštruktori</h2>
    </div>

    <div class="courses-container">
        <?php foreach ($instructors as $inst): ?>
            <div class="course-card">
                <img src="<?= htmlspecialchars($inst['photo_path']) ?>" alt="Foto inštruktora" class="course-photo">
                <h3><?= htmlspecialchars($inst['name']) ?></h3>
                <p><strong>Email:</strong> <?= htmlspecialchars($inst['email']) ?></p>
                <p><strong>Telefón:</strong> <?= htmlspecialchars($inst['phone']) ?></p>
                <p><strong>Špecializácia:</strong> <?= htmlspecialchars($inst['specialization']) ?></p>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="?url=instructor/edit&id=<?= $inst['id'] ?>" class="btn btn-warning">Upraviť</a>
                    <a href="?url=instructor/delete&id=<?= $inst['id'] ?>" class="btn btn-danger"
                       onclick="return confirm('Naozaj chcete odstrániť inštruktora?');">Vymazať</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require __DIR__ . '/../layouts/footer.view.php'; ?>
