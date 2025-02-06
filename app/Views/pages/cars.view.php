<?php require __DIR__ . '/../layouts/header.view.php'; ?>
    <link rel="stylesheet" href="/assets/css/cars.css">
    <main class="auta-content">
         <div class="auta-header">
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="?url=car/create" class="btn btn-primary add-car-btn">Pridať auto</a>
            <?php endif; ?>
            <h2 class="auta-title">Naše Auta</h2>
            <p class="auta-subtitle">
                Objavte naše moderné a bezpečné vozidlá, ktoré používame na výučbu jazdy.
                Všetky autá sú pravidelne servisované a prispôsobené na výcvik vodičov. 🚗🔧
            </p>
        </div>


        <div class="search-block">
            <input type="text" id="searchCars" placeholder="Hľadať podľa značky alebo modelu...">
            <button id="searchBtn" class="btn btn-secondary">Hľadať</button>
        </div>

        <div id="carsContainer" class="auta-container">
            <?php foreach ($cars as $car): ?>
                <div class="car-card">
                    <img src="<?= htmlspecialchars($car['photo_path']) ?>" alt="Fotka auta" class="car-photo">
                    <h3><?= htmlspecialchars($car['brand']) ?> <?= htmlspecialchars($car['model']) ?></h3>
                    <p><strong>Palivo:</strong> <?= htmlspecialchars($car['fuel_type']) ?></p>
                    <p><strong>Rok:</strong> <?= htmlspecialchars($car['year']) ?></p>
                    <p><strong>Evidenčné číslo:</strong> <?= htmlspecialchars($car['license_plate']) ?></p>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a href="?url=car/edit&id=<?= $car['id'] ?>" class="btn btn-warning">Upraviť</a>
                        <a href="?url=car/delete&id=<?= $car['id'] ?>" class="btn btn-danger"
                           onclick="return confirm('Naozaj chcete odstrániť auto?');">Vymazať</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script src="assets/js/ajax_search.js"></script>


<?php require __DIR__ . '/../layouts/footer.view.php'; ?>