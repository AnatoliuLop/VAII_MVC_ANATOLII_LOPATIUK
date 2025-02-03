<?php require __DIR__ . '/../layouts/header.view.php'; ?>

<main class="styled-form">
    <h2>Upraviť inštruktora</h2>

    <form action="?url=instructor/update" method="POST" enctype="multipart/form-data" class="add-form">
        <input type="hidden" name="id" value="<?= htmlspecialchars($instructor['id']) ?>">
        <input type="hidden" name="existing_photo" value="<?= htmlspecialchars($instructor['photo_path']) ?>">

        <label for="name">Meno:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($instructor['name']) ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($instructor['email']) ?>" required>

        <label for="phone">Telefón:</label>
        <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($instructor['phone']) ?>" required>

        <label for="specialization">Špecializácia:</label>
        <select id="specialization" name="specialization" required>
            <option <?= ($instructor['specialization'] == 'Skupina A') ? 'selected' : '' ?> value="Skupina A">Skupina A</option>
            <option <?= ($instructor['specialization'] == 'Skupina B') ? 'selected' : '' ?> value="Skupina B">Skupina B</option>
            <option <?= ($instructor['specialization'] == 'Skupina A, B') ? 'selected' : '' ?> value="Skupina A, B">Skupina A, B</option>
            <option <?= ($instructor['specialization'] == 'Skupina B,C') ? 'selected' : '' ?> value="Skupina B,C">Skupina B,C</option>
            <option <?= ($instructor['specialization'] == 'Skupina A,B,C') ? 'selected' : '' ?> value="Skupina A,B,C">Skupina A,B,C</option>
        </select>

        <label for="photo">Nová fotka (ak chcete zmeniť):</label>
        <input type="file" id="photo" name="photo" accept="image/*">

        <button type="submit" class="btn btn-primary">Uložiť zmeny</button>
    </form>
</main>

<?php require __DIR__ . '/../layouts/footer.view.php'; ?>
