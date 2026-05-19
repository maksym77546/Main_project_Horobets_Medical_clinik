<?php
    include_once ('../function.php');
    session_start();
    $login = 'admin';
    $password = '12345';
   if ($_SESSION['login'] !== $login && $_SESSION['password'] !== $password) {
       header('location: ../login/index.php');
   }


?>
<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Адмін-панель</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php">Адмін-панель</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="btn btn-primary" href="logout.php">Вихід</a></li>

                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <section class="date">
        <?php $news = get_news()?>
        <div class="container">
            <h2 class="mt-4">Всі записи</h2>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">№</th>
                    <th scope="col">Назва новини</th>
                    <th scope="col">Опції</th>
                </tr>
                </thead>
                <?php foreach($news as $new): ?>
                <tbody>
                <tr>
                    <th scope="row"><?=$new['id']?></th>
                    <td><?=$new['title']?></td>
                    <td><a  class="btn btn-warning" href="edit-new.php?post_id=<?=$new['id']?>">Редагувати</a></td>
                    <td><a  class="btn btn-danger" href="delete-new.php?new_id=<?=$new['id']?>">Видалити</a></td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            <a class="btn btn-success" href="add-new.php">Додани новий запис</a>
        </div>
    </section>
</body>
</html>
