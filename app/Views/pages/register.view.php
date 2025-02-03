<?php require __DIR__ . '/../layouts/header.view.php'; ?>

<main class="styled-form">
    <h2>Registrácia nového používateľa</h2>

    <?php if (isset($_GET['error'])): ?>
        <?php if ($_GET['error'] === 'empty'): ?>
            <div class="alert alert-danger">Musíte vyplniť všetky polia.</div>
        <?php elseif ($_GET['error'] === 'exists'): ?>
            <div class="alert alert-danger">Tento užívateľ už existuje!</div>
        <?php elseif ($_GET['error'] === 'db'): ?>
            <div class="alert alert-danger">Chyba databázy pri registrácii!</div>
        <?php endif; ?>
    <?php endif; ?>

    <form action="?url=user/registerProcess" method="POST">
        <label for="username">Používateľské meno:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Heslo:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Registrovať</button>
    </form>

    <p>Už máte účet? <a href="?url=user/login">Prihlásiť sa</a></p>
</main>

<?php require __DIR__ . '/../layouts/footer.view.php'; ?>
