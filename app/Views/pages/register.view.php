<?php require __DIR__ . '/../layouts/header.view.php'; ?>

<main class="styled-form">
    <h2>Registrácia nového používateľa</h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?php
            $error = $_GET['error'];
            switch ($error) {
                case 'empty':
                    echo "Musíte vyplniť všetky polia.";
                    break;
                case 'exists':
                    echo "Tento užívateľ už existuje!";
                    break;
                case 'db':
                    echo "Chyba databázy pri registrácii!";
                    break;
                case 'short_username':
                    echo "Používateľské meno musí mať aspoň 3 znaky.";
                    break;
                case 'weak_password':
                    echo "Heslo musí mať aspoň 6 znakov a obsahovať číslo.";
                    break;
                default:
                    echo "Neznáma chyba!";
            }
            ?>
        </div>
    <?php endif; ?>

    <form action="?url=user/registerProcess" method="POST">
        <label for="username">Používateľské meno:</label>
        <input type="text" name="username" id="username" required minlength="3">

        <label for="password">Heslo:</label>
        <input type="password" name="password" id="password" required minlength="6">

        <button type="submit">Registrovať</button>
    </form>

    <p>Už máte účet? <a href="?url=user/login">Prihlásiť sa</a></p>
</main>

<?php require __DIR__ . '/../layouts/footer.view.php'; ?>
