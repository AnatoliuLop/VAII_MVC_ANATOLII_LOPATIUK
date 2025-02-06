<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?></title>

    <!-- Bootstrap (voliteľné) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind (voliteľné) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700' rel='stylesheet' type='text/css'>
    <!-- Naše štýly -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/footer.css">

    <!-- Skripty -->
    <!--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="/assets/js/ajax_search.js"></script>
    <script src="/assets/js/notification.js"></script>
    <script src="/assets/js/enroll.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/logout.js"></script>
    <script src="/assets/js/burgerMenu.js"></script>

    <!-- FOOTER -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700' rel='stylesheet' type='text/css'>
</head>

<body>

<header>
    <div class="header-container">
        <div class="logo">
            <img src="/assets/images/logo.jpg" alt="Logo">
        </div>
        <h1>Autoškola PRO</h1>

        <!-- Desktopová navigácia -->
        <nav class="desktop-nav">
            <ul class="nav-links">
                <li><a href="?url=home/index">Hlavná</a></li>
                <li><a href="?url=instructor/index">Inštruktori</a></li>
                <li><a href="?url=course/index">Kurzy</a></li>
                <li><a href="?url=car/index">Naše autá</a></li>
                <li><a href="?url=home/exams">Skúšky</a></li>
                <li><a href="?url=home/contact">Kontakt</a></li>
            </ul>
        </nav>

        <!-- Burger menu (mobilná verzia) -->
        <div class="burger-menu" onclick="toggleMenu()">&#9776;</div>
    </div>

    <!-- Mobilná navigácia (predvolene skrytá) -->
    <nav class="mobile-nav">
        <ul class="mobile-nav-links">
            <li><a href="?url=home/index">Hlavná</a></li>
            <li><a href="?url=instructor/index">Inštruktori</a></li>
            <li><a href="?url=course/index">Kurzy</a></li>
            <li><a href="?url=car/index">Naše autá</a></li>
            <li><a href="?url=home/exams">Skúšky</a></li>
            <li><a href="?url=home/contact">Kontakt</a></li>
        </ul>
    </nav>

    <!-- Blok používateľa -->
    <?php if (isset($_SESSION['username'])): ?>
        <div class="user-block">
            Prihlásený ako: <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>
            <button id="logoutButton" class="btn btn-sm btn-danger">Odhlásiť</button>
        </div>
    <?php else: ?>
        <a href="?url=user/login" class="btn btn-sm btn-primary login-btn">Prihlásiť</a>
    <?php endif; ?>
</header>
