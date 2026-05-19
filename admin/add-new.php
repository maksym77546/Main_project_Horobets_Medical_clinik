<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== 'admin') {
    header('Location: ../login/index.php');
    exit();
}
include_once('../conf.php');

$menus = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM menu"), MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Додати лікаря | Адмін</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>body { background: #f0f4f8; }</style>
</head>
<body>
<div class="container py-5" style="max-width:700px">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4">
            <h2 class="h5 mb-0">➕ Додати нового лікаря</h2>
        </div>
        <div class="card-body p-4">
            <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">Заповніть усі поля!</div>
            <?php endif; ?>
            <form action="check-new.php" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold" for="doctor_name">ПІБ лікаря</label>
                    <input type="text" name="doctor_name" id="doctor_name" class="form-control" placeholder="Ім'я Прізвище По-батькові" required />
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold" for="image">URL фото</label>
                    <input type="url" name="image" id="image" class="form-control" placeholder="https://..." required />
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold" for="specialization">Спеціалізація / Опис</label>
                    <textarea name="specialization" id="specialization" class="form-control" rows="4" placeholder="Опишіть спеціалізацію, досвід, послуги..." required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold" for="datetime">Дата</label>
                    <input type="date" name="datetime" id="datetime" class="form-control" value="<?=date('Y-m-d')?>" required />
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold" for="menu_id">Категорія</label>
                    <select name="menu_id" id="menu_id" class="form-select" required>
                        <option value="">-- Оберіть категорію --</option>
                        <?php foreach ($menus as $menu): ?>
                        <option value="<?=$menu['id']?>"><?=htmlspecialchars($menu['title'])?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success flex-grow-1">✅ Зберегти лікаря</button>
                    <a href="index.php" class="btn btn-outline-secondary">Скасувати</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
