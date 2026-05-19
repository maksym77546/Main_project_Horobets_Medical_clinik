<?php?>
<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Вхід в адмін-панель</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-4">
                <h3>Форма входу у адмін-панель</h3>
                <form  action="check-login.php" method="post">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Введіть ваш логі</label>
                        <input type="text" name="login" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Введіть ваш пароль</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                    </div>

                    <button type="submit" class="btn btn-primary">Увійти</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
