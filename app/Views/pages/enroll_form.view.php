<?php require __DIR__ . '/../layouts/header.view.php'; ?>

<main class="styled-form">
    <h2>Prihlásiť sa na kurz: <strong><?= htmlspecialchars($course['title']) ?></strong></h2>

    <form action="?url=enroll/enroll" method="POST" class="add-form">
        <input type="hidden" name="course_id" value="<?= htmlspecialchars($course['id']) ?>">

        <label for="email">Váš email:</label>
        <input type="email" id="email" name="email" required>

        <label for="phone">Telefónne číslo:</label>
        <input type="text" id="phone" name="phone" placeholder="+421 123 456 789" required>

        <label for="message">Správa:</label>
        <textarea id="message" name="message" required></textarea>

        <button type="submit" class="btn btn-success">Odoslať žiadosť</button>
    </form>
</main>

<?php require __DIR__ . '/../layouts/footer.view.php'; ?>
