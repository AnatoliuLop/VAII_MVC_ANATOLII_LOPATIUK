<?php require __DIR__ . '/../layouts/header.view.php'; ?>

<main class="styled-form">
    <h2>Pridať nový kurz</h2>
    <form action="?url=course/store" method="POST" enctype="multipart/form-data" class="add-form">
        <label for="title">Názov kurzu:</label>
        <input type="text" id="title" name="title" required>

        <label for="description">Krátky popis:</label>
        <textarea id="description" name="description" required></textarea>

        <!-- ✅ Новое поле для полного описания -->
        <label for="full_description">Celý popis kurzu:</label>
        <textarea id="full_description" name="full_description" rows="6" required></textarea>

        <label for="duration">Dĺžka (hodiny):</label>
        <input type="number" id="duration" name="duration" required>

        <label for="price">Cena (€):</label>
        <input type="number" step="0.01" id="price" name="price" required>

        <label for="photo">Fotka kurzu:</label>
        <input type="file" id="photo" name="photo" accept="image/*" required>

        <button type="submit" class="btn btn-success">Pridať</button>
    </form>
</main>

<?php require __DIR__ . '/../layouts/footer.view.php'; ?>
