<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== 'admin') {
    header('Location: ../login/index.php');
    exit();
}
include_once('../conf.php');

$sql = "SELECT doctors.*, menu.title AS category FROM doctors LEFT JOIN menu ON doctors.menu_id = menu.id ORDER BY doctors.id DESC";
$result = mysqli_query($conn, $sql);
$doctors = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Адмін-панель | Медична клініка</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body { background: #f0f4f8; }
        .admin-header { background: #0d6efd; color: #fff; padding: 16px 24px; border-radius: 0 0 12px 12px; margin-bottom: 32px; }
        .table-img { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="admin-header d-flex justify-content-between align-items-center">
        <h1 class="h4 mb-0">🏥 Адмін-панель | Медична клініка</h1>
        <div>
            <a href="../index.php" class="btn btn-outline-light btn-sm me-2">← На сайт</a>
            <a href="logout.php" class="btn btn-danger btn-sm">Вийти</a>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 fw-bold">Список лікарів</h2>
        <a href="add-new.php" class="btn btn-success">+ Додати лікаря</a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-<?=$_GET['msg']==='deleted'?'danger':($_GET['msg']==='added'?'success':'info')?> alert-dismissible fade show" role="alert">
        <?php
            if ($_GET['msg']==='deleted') echo 'Лікаря успішно видалено.';
            elseif ($_GET['msg']==='added') echo 'Лікаря успішно додано.';
            elseif ($_GET['msg']==='updated') echo 'Дані лікаря оновлено.';
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Фото</th>
                        <th>ПІБ лікаря</th>
                        <th>Спеціалізація</th>
                        <th>Категорія</th>
                        <th>Дата</th>
                        <th class="text-center">Дії</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($doctors)): ?>
                    <tr><td colspan="7" class="text-center py-4 text-muted">Лікарів ще немає</td></tr>
                    <?php endif; ?>
                    <?php foreach ($doctors as $doc): ?>
                    <tr>
                        <td><?=$doc['id']?></td>
                        <td><img src="<?=htmlspecialchars($doc['image'])?>" class="table-img" alt="" /></td>
                        <td class="fw-bold"><?=htmlspecialchars($doc['doctor_name'])?></td>
                        <td><?=htmlspecialchars(mb_substr($doc['specialization'],0,60,'utf-8'))?>...</td>
                        <td><span class="badge bg-primary"><?=htmlspecialchars($doc['category'])?></span></td>
                        <td><?=date('d.m.Y', strtotime($doc['datetime']))?></td>
                        <td class="text-center">
                            <a href="edit-new.php?id=<?=$doc['id']?>" class="btn btn-warning btn-sm me-1">✏️ Ред.</a>
                            <a href="delete-new.php?id=<?=$doc['id']?>" class="btn btn-danger btn-sm"
                               onclick="return confirm('Ви впевнені, що хочете видалити цього лікаря?')">🗑️ Видалити</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
