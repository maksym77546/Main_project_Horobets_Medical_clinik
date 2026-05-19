<?php
 include_once ('../function.php');
 include_once ('../conf.php');
?>
<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Додання нової новини</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <h3>Форма додання нового запису</h3>
                <form action="check-new.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Вкажіть назву новини</label>
                        <input type="text" name="title" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Введіть текст новини</label><br>
                        <textarea name="content" style="width: 100%; box-sizing: border-box; resize: vertical; min-height: 150px;"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-check-label" for="exampleCheck1">Завантажте зображення</label>
                        <input type="file" name="image" class="form-control-file"   >
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="exampleCheck1">Дата публікації</label>
                        <input type="date" name="date" class="form-control">
                    </div>
                    <?php $menus = get_menu();?>
                    <div class="mb-3">
                        <label class="form-label" for="exampleCheck1">Категорія новини</label>
                        <select name="menu_id" required>
                            <option value="">-- Оберіть категорію --</option>
                            <?php foreach ($menus as $menu): ?>
                                <!-- value містить id для БД, а між тегами - назва для користувача -->
                                <option value="<?= htmlspecialchars($menu['id']) ?>">
                                    <?= htmlspecialchars($menu['title']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Додати новину</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
