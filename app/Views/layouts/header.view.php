<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?></title>

    <!-- Bootstrap (по желанию) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind (по желанию) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700' rel='stylesheet' type='text/css'>
    <!-- Наши стили -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/footer.css">

    <!-- Скрипты -->
<!--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>-->
    <script src="/assets/js/ajax_search.js"></script>
    <script src="/assets/js/notification.js"></script>
    <script src="/assets/js/enroll.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!--FOOTER-->
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
        <nav>
            <ul class="nav-links">
                <li><a href="?url=home/index">Hlavná</a></li>
                <li><a href="?url=instructor/index">O nás</a></li>
                <li><a href="?url=course/index">Kurzy</a></li>
                <li><a href="?url=car/index">Naše autá</a></li>
                <li><a href="?url=home/exams">Skúšky</a></li>
                <li><a href="?url=home/contact">Kontakt</a></li>
            </ul>
        </nav>
        <?php


        if (isset($_SESSION['username'])) {
            echo '<div class="user-block">';
            echo 'Prihlásený ako: ' . htmlspecialchars($_SESSION['username']) . ' ';
            echo '<a href="?url=user/logout" class="btn btn-sm btn-danger">Odhlásiť</a>';
            echo '</div>';
        } else {
            echo '<a href="?url=user/login" class="btn btn-sm btn-primary login-btn">Prihlásiť</a>';
        }
        ?>
    </div>
</header>
