<?php
    include_once ('function.php');

?>

<!doctype html>
<html lang="uk">
<head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Blog Home - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Мій блог</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php $menus = get_menu();?>
                <?php foreach ($menus as $menu):?>
                <li class="nav-item"><a class="nav-link" href="category.php?category_id=<?=$menu['id']?>"><?=$menu['title']?></a></li>
                <?php endforeach;?>
                li class="nav-item"><a class="nav-link" href="login/index.php">Адмінка</a></li>
            </ul>
        </div>
    </div>
</nav>