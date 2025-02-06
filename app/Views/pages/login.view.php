<?php require __DIR__ . '/../layouts/header.view.php'; ?>

<main class="styled-form">
    <h2>Prihlásenie</h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?php
            $error = $_GET['error'];
            switch ($error) {
                case 'invalid_credentials':
                    echo "Nesprávne meno alebo heslo!";
                    break;
                case 'empty_fields':
                    echo "Vyplňte všetky požadované polia.";
                    break;
                default:
                    echo "Neznáma chyba pri prihlasovaní!";
            }
            ?>
        </div>
    <?php endif; ?>

    <form action="?url=user/loginProcess" method="POST">
        <label>Meno (username):</label>
        <input type="text" name="username" required>

        <label>Heslo (password):</label>
        <input type="password" name="password" required>

        <button type="submit">Prihlásiť</button>
    </form>

    <p>Nemáte ešte účet? <a href="?url=user/register">Zaregistrujte sa</a></p>
</main>

<?php require __DIR__ . '/../layouts/footer.view.php'; ?>
