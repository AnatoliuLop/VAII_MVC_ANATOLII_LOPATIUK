<?php require __DIR__ . '/../layouts/header.view.php'; ?>

<main class="styled-form">
    <h2>Upraviť kurz</h2>

    <form action="?url=course/update" method="POST" enctype="multipart/form-data" class="add-form">
        <input type="hidden" name="id" value="<?= htmlspecialchars($course['id']) ?>">
        <input type="hidden" name="existing_photo" value="<?= htmlspecialchars($course['photo_path']) ?>">

        <label for="title">Názov kurzu:</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($course['title']) ?>" required>

        <label for="description">Krátky popis:</label>
        <textarea id="description" name="description" required><?= htmlspecialchars($course['description']) ?></textarea>

        <label for="full_description">Celý popis kurzu:</label>
        <textarea id="full_description" name="full_description" required><?= htmlspecialchars($course['full_description']) ?></textarea>

        <label for="duration">Trvanie (dni):</label>
        <input type="number" id="duration" name="duration" value="<?= htmlspecialchars($course['duration']) ?>" required>

        <label for="price">Cena (€):</label>
        <input type="number" id="price" name="price" value="<?= htmlspecialchars($course['price']) ?>" required>

        <label for="photo">Nové foto (nepovinné, ak nechcete meniť):</label>
        <input type="file" id="photo" name="photo" accept="image/*">

        <button type="submit" class="btn btn-primary">Uložiť zmeny</button>
    </form>
</main>

<?php require __DIR__ . '/../layouts/footer.view.php'; ?>
