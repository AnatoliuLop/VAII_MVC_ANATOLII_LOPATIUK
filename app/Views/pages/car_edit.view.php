<?php require __DIR__ . '/../layouts/header.view.php'; ?>

    <main class="styled-form">
        <h2>Upraviť auto</h2>

        <form action="?url=car/update" method="POST" enctype="multipart/form-data" class="add-form">
            <input type="hidden" name="id" value="<?= htmlspecialchars($car['id']) ?>">
            <input type="hidden" name="existing_photo" value="<?= htmlspecialchars($car['photo_path']) ?>">

            <label for="brand">Značka:</label>
            <input type="text" id="brand" name="brand" value="<?= htmlspecialchars($car['brand']) ?>" required>

            <label for="model">Model:</label>
            <input type="text" id="model" name="model" value="<?= htmlspecialchars($car['model']) ?>" required>

            <label for="year">Rok výroby:</label>
            <input type="number" id="year" name="year" value="<?= htmlspecialchars($car['year']) ?>" required>

            <label for="fuel_type">Typ paliva:</label>
            <input type="text" id="fuel_type" name="fuel_type" value="<?= htmlspecialchars($car['fuel_type']) ?>" required>

            <label for="license_plate">Evidenčné číslo:</label>
            <input type="text" id="license_plate" name="license_plate" value="<?= htmlspecialchars($car['license_plate']) ?>" required>

            <label for="photo">Новое фото (если хотите заменить):</label>
            <input type="file" id="photo" name="photo" accept="image/*">

            <button type="submit" class="btn btn-primary">Uložiť zmeny</button>
        </form>
    </main>
<?php if (!empty($_SESSION['errors'])): ?>
    <div class="error-box">
        <?php foreach ($_SESSION['errors'] as $error): ?>
            <p class="error-message"><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
        <?php unset($_SESSION['errors']); ?>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.view.php'; ?>