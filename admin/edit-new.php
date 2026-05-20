<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== 'admin') {
    header('Location: ../login/index.php');
    exit();
}
include_once('../conf.php');

$id = intval($_GET['id'] ?? 0);
if (!$id) { header('Location: index.php'); exit(); }

$sql    = "SELECT * FROM doctors WHERE id = $id";
$result = mysqli_query($conn, $sql);
$doctor = mysqli_fetch_assoc($result);
if (!$doctor) { header('Location: index.php'); exit(); }

$menus = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM menu"), MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Редагувати лікаря | Адмін</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>body { background: #f0f4f8; }</style>
</head>
<body>
<div class="container py-5" style="max-width:700px">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-warning text-dark rounded-top-4">
            <h2 class="h5 mb-0">✏️ Редагувати лікаря #<?=$doctor['id']?></h2>
        </div>
        <div class="card-body p-4">
            <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">Заповніть усі поля!</div>
            <?php endif; ?>
            <form action="update.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?=$doctor['id']?>" />
                <div class="mb-3">
                    <label class="form-label fw-bold" for="doctor_name">ПІБ лікаря</label>
                    <input type="text" name="doctor_name" id="doctor_name" class="form-control"
                           value="<?=htmlspecialchars($doctor['doctor_name'])?>" required />
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold" for="image">URL фото</label>
                    <?php 
                        $imageUrl = $doctor['image'];
                        // Якщо це локальний шлях (починається з assets/), не виводимо його в поле URL
                        if (strpos($imageUrl, 'http') !== 0) {
                            $imageUrl = '';
                        }
                    ?>
                    <input type="text" name="image" id="image" class="form-control"
                           value="<?=htmlspecialchars($imageUrl)?>" placeholder="https://..." />
                    <div class="form-text">АБО завантажте нове фото нижче:</div>
                </div>
                <div class="mb-3">
                    <input type="hidden" name="old_image" value="<?=htmlspecialchars($doctor['image'])?>" />
                    <label class="form-label fw-bold" for="image_file">Завантажити нове фото з комп'ютера</label>
                    <input type="file" name="image_file" id="image_file" class="form-control" accept="image/*" />
                    <?php if (!empty($doctor['image'])): ?>
                    <div class="mt-2">
                        <span class="small text-muted">Поточне зображення:</span><br>
                        <?php 
                        $imgPath = $doctor['image'];
                        if (strpos($imgPath, 'http') !== 0 && strpos($imgPath, 'assets/') === 0) {
                            $imgPath = '../' . $imgPath;
                        }
                        ?>
                        <img src="<?=htmlspecialchars($imgPath)?>" alt="preview"
                             style="height:80px; border-radius:8px; object-fit:cover;" />
                    </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold" for="specialization">Спеціалізація / Опис</label>
                    <textarea name="specialization" id="specialization" class="form-control" rows="4" required><?=htmlspecialchars($doctor['specialization'])?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold" for="datetime">Дата</label>
                    <input type="date" name="datetime" id="datetime" class="form-control"
                           value="<?=$doctor['datetime']?>" required />
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold" for="menu_id">Категорія</label>
                    <select name="menu_id" id="menu_id" class="form-select" required>
                        <?php foreach ($menus as $menu): ?>
                        <option value="<?=$menu['id']?>" <?=$menu['id']==$doctor['menu_id']?'selected':''?>>
                            <?=htmlspecialchars($menu['title'])?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning flex-grow-1">💾 Оновити дані</button>
                    <a href="index.php" class="btn btn-outline-secondary">Скасувати</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
