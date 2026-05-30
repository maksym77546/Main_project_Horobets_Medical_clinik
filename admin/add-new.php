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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet" />
    <style>body { background: #f0f4f8; }</style>
</head>
<body>
<div class="container py-5" style="max-width:800px">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4">
            <h2 class="h5 mb-0">➕ Додати нового лікаря</h2>
        </div>
        <div class="card-body p-4">
            <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">Заповніть усі обов'язкові поля!</div>
            <?php endif; ?>
            <form action="check-new.php" method="POST" enctype="multipart/form-data">
                
                <h5 class="border-bottom pb-2 mb-3">Основна інформація</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold" for="doctor_name">ПІБ лікаря *</label>
                        <input type="text" name="doctor_name" id="doctor_name" class="form-control" placeholder="Ім'я Прізвище" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold" for="menu_id">Категорія *</label>
                        <select name="menu_id" id="menu_id" class="form-select" required>
                            <option value="">-- Оберіть категорію --</option>
                            <?php foreach ($menus as $menu): ?>
                            <option value="<?=$menu['id']?>"><?=htmlspecialchars($menu['title'])?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold" for="specialization">Спеціалізація / Опис *</label>
                    <textarea name="specialization" id="specialization" class="form-control" rows="3" placeholder="Опишіть спеціалізацію..." required></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold" for="image">URL фото</label>
                        <input type="text" name="image" id="image" class="form-control" placeholder="https://..." />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold" for="image_file">АБО Фото з ПК</label>
                        <input type="file" name="image_file" id="image_file" class="form-control" accept="image/*" />
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold" for="datetime">Дата додавання *</label>
                    <input type="date" name="datetime" id="datetime" class="form-control" value="<?=date('Y-m-d')?>" required />
                </div>

                <!-- Графік роботи -->
                <h5 class="border-bottom pb-2 mb-3 mt-4">Графік прийому</h5>
                <div class="row g-2 mb-4">
                    <?php 
                    $days = [1=>'Понеділок', 2=>'Вівторок', 3=>'Середа', 4=>'Четвер', 5=>"П'ятниця", 6=>'Субота', 7=>'Неділя'];
                    foreach ($days as $num => $name): 
                    ?>
                    <div class="col-md-6">
                        <div class="input-group mb-2">
                            <div class="input-group-text bg-light" style="width: 120px;">
                                <input class="form-check-input mt-0 me-2 schedule-check" type="checkbox" name="schedule_days[]" value="<?=$num?>" id="day<?=$num?>">
                                <label class="form-check-label" for="day<?=$num?>"><?=$name?></label>
                            </div>
                            <input type="time" name="schedule_start[]" class="form-control" value="08:00" disabled>
                            <span class="input-group-text">-</span>
                            <input type="time" name="schedule_end[]" class="form-control" value="17:00" disabled>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Сертифікати -->
                <h5 class="border-bottom pb-2 mb-3 mt-4">Сертифікати та кваліфікація</h5>
                <div id="certificates-container">
                    <!-- Dynamic certificates will be added here -->
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm mb-4" id="add-cert-btn">
                    <i class="bi bi-plus-circle"></i> Додати сертифікат
                </button>

                <hr class="mt-2 mb-4">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success flex-grow-1 btn-lg">✅ Зберегти лікаря</button>
                    <a href="index.php" class="btn btn-outline-secondary btn-lg">Скасувати</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Enable/disable time inputs based on checkbox
    document.querySelectorAll('.schedule-check').forEach(function(check) {
        check.addEventListener('change', function() {
            let startInput = this.closest('.input-group').querySelector('input[name="schedule_start[]"]');
            let endInput = this.closest('.input-group').querySelector('input[name="schedule_end[]"]');
            startInput.disabled = !this.checked;
            endInput.disabled = !this.checked;
        });
    });

    // Dynamic certificates
    document.getElementById('add-cert-btn').addEventListener('click', function() {
        let container = document.getElementById('certificates-container');
        let index = container.children.length;
        
        let html = `
        <div class="card card-body bg-light mb-3 cert-item">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">Сертифікат #${index + 1}</h6>
                <button type="button" class="btn btn-sm btn-danger remove-cert" title="Видалити">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
            <div class="row">
                <div class="col-md-8 mb-2">
                    <input type="text" name="cert_title[]" class="form-control" placeholder="Назва сертифікату (обов'язково)" required>
                </div>
                <div class="col-md-4 mb-2">
                    <input type="date" name="cert_date[]" class="form-control" title="Дата видачі">
                </div>
                <div class="col-12">
                    <input type="text" name="cert_desc[]" class="form-control" placeholder="Короткий опис або ким виданий">
                </div>
            </div>
        </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    });

    // Remove certificate event delegation
    document.getElementById('certificates-container').addEventListener('click', function(e) {
        if (e.target.closest('.remove-cert')) {
            e.target.closest('.cert-item').remove();
            // Re-number
            document.querySelectorAll('.cert-item h6').forEach((el, idx) => {
                el.textContent = `Сертифікат #${idx + 1}`;
            });
        }
    });
</script>
</body>
</html>
