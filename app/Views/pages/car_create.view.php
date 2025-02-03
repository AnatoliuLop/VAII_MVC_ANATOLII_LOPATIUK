<?php require __DIR__ . '/../layouts/header.view.php'; ?>

<main class="styled-form">
    <h2>Pridať nové auto</h2>
    <form action="?url=car/store" method="POST" enctype="multipart/form-data" class="add-form">
        <label for="brand">Značka:</label>
        <input type="text" id="brand" name="brand" required>

        <label for="model">Model:</label>
        <input type="text" id="model" name="model" required>

        <label for="year">Rok výroby:</label>
        <input type="number" id="year" name="year" required>

        <label for="fuel_type">Typ paliva:</label>
        <select id="fuel_type" name="fuel_type" required>
            <option value="Benzín">Benzín</option>
            <option value="Dizel">Dizel</option>
            <option value="Plyn">Plyn</option>
            <option value="Elektro">Elektro</option>
        </select>

        <label for="license_plate">Evidenčné číslo:</label>
        <input type="text" id="license_plate" name="license_plate" required>

        <label for="photo">Fotka auta:</label>
        <input type="file" id="photo" name="photo" accept="image/*" required>

        <button type="submit" class="btn btn-success">Pridať</button>
    </form>
</main>

<?php require __DIR__ . '/../layouts/footer.view.php'; ?>
