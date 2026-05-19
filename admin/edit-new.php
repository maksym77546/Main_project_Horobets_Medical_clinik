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
    <title>Редагування новини</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
            <h3>Форма редагування запису</h3>
            <?php
            $post_id = $_GET['post_id'];
            if (!is_numeric($post_id)) exit();

            $post = get_news_by_id($post_id);
            ?>
            <form action="check-new.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Вкажіть назву новини</label>
                    <input type="text" name="title" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?=$post['title']?>">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Введіть текст новини</label><br>
                    <textarea name="content" style="width: 100%; box-sizing: border-box; resize: vertical; min-height: 150px;"><?=$post['content']?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-check-label" for="exampleCheck1">Завантажте зображення</label>
                    <input type="file" name="image" class="form-control-file"   >
                </div>
                <div class="mb-3">
                    <label class="form-label" for="exampleCheck1">Дата публікації</label>
                    <input type="date" name="date" class="form-control" value="<?=$post['datetime']?>">
                </div>
                <?php $menus = get_menu();?>
                <div class="mb-3">
                    <label class="form-label" for="exampleCheck1">Категорія новини</label>
                    <input type="text" name="menu_id" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?=$post['menu_id']?>">
                </div>
                <button type="submit" class="btn btn-primary">Оновити новину</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
