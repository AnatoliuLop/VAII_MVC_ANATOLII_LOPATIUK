<?php require __DIR__ . '/../layouts/header.view.php'; ?>

<main class="styled-form">
    <h2>Prihlásenie</h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">Nesprávne meno alebo heslo!</div>
    <?php endif; ?>

    <form action="?url=user/loginProcess" method="POST">
        <label>Meno (username):</label>
        <input type="text" name="username" required>

        <label>Heslo (password):</label>
        <input type="password" name="password" required>

        <button type="submit">Prihlásiť</button>
    </form>
    <p>Nemáte ešte účet? <a href="?url=user/register">Zaregistrujte sa</a></p>
<!--    --><?php
    echo password_hash('123', PASSWORD_DEFAULT);
//    ?>
</main>

<?php require __DIR__ . '/../layouts/footer.view.php'; ?>
