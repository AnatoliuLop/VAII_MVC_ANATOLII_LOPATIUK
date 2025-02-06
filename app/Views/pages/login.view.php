<?php require __DIR__ . '/../layouts/header.view.php'; ?>

<main class="styled-form">
    <h2>Prihlásenie</h2>

    <div id="login-error" class="alert alert-danger" style="display: none;"></div>

    <form id="loginForm">
        <label>Meno (username):</label>
        <input type="text" name="username" id="username" required>

        <label>Heslo (password):</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Prihlásiť</button>
    </form>

    <p>Nemáte ešte účet? <a href="?url=user/register">Zaregistrujte sa</a></p>
</main>

<script src="/assets/js/login.js"></script>

<?php require __DIR__ . '/../layouts/footer.view.php'; ?>
