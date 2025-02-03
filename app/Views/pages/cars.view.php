<?php require __DIR__ . '/../layouts/header.view.php'; ?>

    <main class="auta-content">
        <div>
            <!-- Кнопка на создание -->
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="?url=car/create" class="btn btn-primary" style="float: right; margin: 10px;">Pridať auto</a>
            <?php endif; ?>
            <h2 class="stranka-title">Naše Auta</h2>
        </div>

        <!-- Пример AJAX поиска (доп. фишка) -->
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

    <script src="assets/js/ajax_search.js"></script> <!-- Подключаем скрипт AJAX поиска -->


<?php require __DIR__ . '/../layouts/footer.view.php'; ?>