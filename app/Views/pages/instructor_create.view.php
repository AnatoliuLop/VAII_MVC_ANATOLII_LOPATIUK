<?php require __DIR__ . '/../layouts/header.view.php'; ?>

<main class="styled-form">
    <h2>Pridať nového inštruktora</h2>
    <form action="?url=instructor/store" method="POST" enctype="multipart/form-data" class="add-form">
        <label for="name">Meno:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="phone">Telefón:</label>
        <input type="text" id="phone" name="phone" required>

        <label for="specialization">Špecializácia:</label>
        <select id="specialization" name="specialization" required>
            <option value="Skupina A">Skupina A</option>
            <option value="Skupina B">Skupina B</option>
            <option value="Skupina A, B">Skupina A, B</option>
            <option value="Skupina B,C">Skupina B,C</option>
            <option value="Skupina A,B,C">Skupina A,B,C</option>
        </select>
        <label for="experience_years">Stáž (roky):</label>
        <input type="number" id="experience_years" name="experience_years" value="<?= htmlspecialchars($instructor['experience_years'] ?? '') ?>" min="0" required>

        <label for="photo">Fotka inštruktora:</label>
        <input type="file" id="photo" name="photo" accept="image/*" required>

        <button type="submit" class="btn btn-success">Pridať</button>
    </form>
</main>

<?php require __DIR__ . '/../layouts/footer.view.php'; ?>
