<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    include_once ('function.php');

    // Визначення мови
    $current_lang = $_SESSION['lang'] ?? 'uk';
    include_once("lang/{$current_lang}.php");
?>

<!doctype html>
<html lang="<?=$current_lang?>">
<head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="<?=$lang['site_name']?> - <?=$lang['site_tagline']?>" />
        <meta name="author" content="" />
        <title><?=$lang['site_name']?></title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <!-- Bootstrap CDN for consistent styling -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Custom medical clinic styles -->
        <link href="css/main.css" rel="stylesheet" />
        <style>
            .bg-medical { background-color: #0d6efd !important; } /* Blue color */
            .text-medical { color: #0d6efd !important; }
        </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-medical">
    <div class="container">
        <a class="navbar-brand" href="index.php"><?=$lang['site_name']?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php $menus = get_menu();?>
                <?php foreach ($menus as $menu):?>
                <li class="nav-item"><a class="nav-link" href="category.php?category_id=<?=$menu['id']?>"><?=$menu['title']?></a></li>
                <?php endforeach;?>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                <!-- Перемикач мови -->
                <li class="nav-item me-2">
                    <?php if ($current_lang === 'uk'): ?>
                        <a class="nav-link lang-switch" href="set-lang.php?lang=en" title="Switch to English">
                            <span class="lang-flag">🇬🇧</span> EN
                        </a>
                    <?php else: ?>
                        <a class="nav-link lang-switch" href="set-lang.php?lang=uk" title="Перемкнути на українську">
                            <span class="lang-flag">🇺🇦</span> UA
                        </a>
                    <?php endif; ?>
                </li>
                
                <!-- Авторизація/Реєстрація користувача -->
                <?php if (is_user_logged_in()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="user-profile.php">
                            <i class="bi bi-person-circle"></i> <?=$lang['nav_profile']?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="user-logout.php">
                            <i class="bi bi-box-arrow-right"></i> <?=$lang['nav_logout']?>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="user-login.php">
                            <i class="bi bi-box-arrow-in-right"></i> <?=$lang['nav_login']?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm ms-2" href="register.php">
                            <?=$lang['nav_register']?>
                        </a>
                    </li>
                <?php endif; ?>
                
                <!-- Адмінка -->
                <li class="nav-item ms-2">
                    <a class="nav-link" href="login/index.php">
                        <i class="bi bi-gear"></i> <?=$lang['nav_admin']?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>