<?php
include_once ('header.php');

$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
if (!$post_id) { header('Location: 404.php'); exit(); }
$doctor = get_doctor_by_id($post_id);
if (!$doctor) { header('Location: 404.php'); exit(); }

$schedule = get_doctor_schedule($post_id);
$certificates = get_doctor_certificates($post_id);

$user_appointments = [];
if (is_user_logged_in()) {
    $user_appointments = get_user_appointments_for_doctor($_SESSION['user_id'], $post_id);
}
?>
<section class="doctor-detail py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow border-0 rounded-4 overflow-hidden">
                    <img class="card-img-top"
                         src="<?=$doctor['image']?>"
                         alt="<?=$doctor['doctor_name']?>"
                         style="max-height: 450px; object-fit: cover; object-position: center top;" />
                    <div class="card-body p-4">
                        <span class="badge bg-primary mb-2">
                            <?php
                                $cat = get_category_title($doctor['menu_id']);
                                echo $cat['title'] ?? '';
                            ?>
                        </span>
                        <h1 class="card-title fw-bolder h3"><?=$doctor['doctor_name']?></h1>
                        <div class="small text-muted mb-3">
                            <i><?=$lang['date_added']?></i>
                            <?=$doctor['datetime']=date('d.m.Y', strtotime($doctor['datetime']));?>
                        </div>
                        <p class="card-text lead mb-4"><?=$doctor['specialization']?></p>
                        
                        <div class="d-flex flex-column gap-2 mb-2">
                            <?php if (!empty($doctor['phone'])): ?>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-telephone-fill text-success me-2"></i>
                                <span class="fw-medium"><?=htmlspecialchars($doctor['phone'])?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($doctor['cabinet'])): ?>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-door-open-fill text-primary me-2"></i>
                                <span class="fw-medium">Кабінет <?=htmlspecialchars($doctor['cabinet'])?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Графік прийому -->
                <div class="card shadow border-0 rounded-4 mt-4">
                    <div class="card-header bg-primary text-white rounded-top-4">
                        <h5 class="mb-0"><i class="bi bi-clock"></i> <?=$lang['work_schedule']?></h5>
                    </div>
                    <div class="card-body p-4">
                        <?php if (empty($schedule)): ?>
                            <p class="text-muted mb-0"><?=$lang['no_schedule']?></p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover schedule-table mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-muted" style="width: 50%;"><?=$lang['day_1']?></th>
                                            <th class="text-center text-muted"><?=$lang['search']?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        // Створюємо масив за днями тижня
                                        $schedule_by_day = [];
                                        foreach ($schedule as $s) {
                                            $schedule_by_day[$s['day_of_week']] = $s;
                                        }
                                        for ($day = 1; $day <= 7; $day++): 
                                        ?>
                                        <tr class="<?=isset($schedule_by_day[$day]) ? '' : 'text-muted'?>">
                                            <td class="fw-semibold"><?=$lang['day_' . $day]?></td>
                                            <td class="text-center">
                                                <?php if (isset($schedule_by_day[$day])): ?>
                                                    <span class="badge bg-success-subtle text-success px-3 py-2 schedule-badge">
                                                        <?=substr($schedule_by_day[$day]['start_time'], 0, 5)?> — <?=substr($schedule_by_day[$day]['end_time'], 0, 5)?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary-subtle text-secondary px-3 py-2"><?=$lang['day_off']?></span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endfor; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Сертифікати -->
                <div class="card shadow border-0 rounded-4 mt-4">
                    <div class="card-header bg-primary text-white rounded-top-4">
                        <h5 class="mb-0"><i class="bi bi-award"></i> <?=$lang['certificates']?></h5>
                    </div>
                    <div class="card-body p-4">
                        <?php if (empty($certificates)): ?>
                            <p class="text-muted mb-0"><?=$lang['no_certificates']?></p>
                        <?php else: ?>
                            <div class="row g-3">
                                <?php foreach ($certificates as $cert): ?>
                                <div class="col-md-6">
                                    <div class="certificate-card p-3 rounded-3 h-100">
                                        <div class="d-flex align-items-start">
                                            <div class="cert-icon me-3">
                                                <i class="bi bi-patch-check-fill text-primary fs-3"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-1"><?=htmlspecialchars($cert['title'])?></h6>
                                                <?php if (!empty($cert['issued_date'])): ?>
                                                    <small class="text-muted d-block mb-1">
                                                        <i class="bi bi-calendar3"></i> <?=$lang['cert_issued']?> <?=date('d.m.Y', strtotime($cert['issued_date']))?>
                                                    </small>
                                                <?php endif; ?>
                                                <?php if (!empty($cert['description'])): ?>
                                                    <small class="text-secondary"><?=htmlspecialchars($cert['description'])?></small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mt-4">
                    <a class="btn btn-primary" href="index.php"><?=$lang['back_to_list']?></a>
                </div>
            </div>
            
            <div class="col-lg-4">
                <!-- Блок запису на прийом -->
                <div class="card shadow border-0 rounded-4 sticky-top" style="top: 20px;">
                    <div class="card-header bg-success text-white rounded-top-4">
                        <h5 class="mb-0"><i class="bi bi-calendar-check"></i> Запис на прийом</h5>
                    </div>
                    <div class="card-body p-4">
                        <?php if (isset($_GET['success'])): ?>
                            <div class="alert alert-success">Ви успішно записані на прийом!</div>
                        <?php endif; ?>
                        <?php if (isset($_GET['cancel_success'])): ?>
                            <div class="alert alert-info">Ваш запис успішно скасовано.</div>
                        <?php endif; ?>
                        <?php if (isset($_GET['error'])): ?>
                            <?php if ($_GET['error'] == 'booked'): ?>
                                <div class="alert alert-danger">Вибачте, цей час вже зайнятий. Оберіть інший.</div>
                            <?php elseif ($_GET['error'] == 'cancel'): ?>
                                <div class="alert alert-danger">Не вдалося скасувати запис.</div>
                            <?php else: ?>
                                <div class="alert alert-danger">Виникла помилка.</div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if (is_user_logged_in()): ?>
                            
                            <?php if (!empty($user_appointments)): ?>
                                <div class="mb-4">
                                    <h6 class="fw-bold text-success mb-3">Ваші записи до цього лікаря:</h6>
                                    <?php foreach ($user_appointments as $app): ?>
                                        <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded mb-2 border">
                                            <div>
                                                <i class="bi bi-calendar-event me-2"></i>
                                                <strong><?=date('d.m.Y', strtotime($app['appointment_date']))?></strong> о <strong><?=$app['appointment_time']?></strong>
                                            </div>
                                            <form action="cancel-appointment.php" method="POST" class="m-0" onsubmit="return confirm('Ви впевнені, що хочете скасувати цей запис?');">
                                                <input type="hidden" name="appointment_id" value="<?=$app['id']?>">
                                                <input type="hidden" name="doctor_id" value="<?=$doctor['id']?>">
                                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Відмінити запис">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </form>
                                        </div>
                                    <?php endforeach; ?>
                                    <hr>
                                </div>
                            <?php endif; ?>

                            <form action="book-appointment.php" method="POST" id="bookingForm">
                                <input type="hidden" name="doctor_id" id="doctorId" value="<?=$doctor['id']?>">
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Оберіть дату:</label>
                                    <input type="date" name="date" id="appointmentDate" class="form-control" min="<?=date('Y-m-d')?>" required>
                                </div>
                                
                                <div class="mb-4" id="slotsContainer" style="display:none;">
                                    <label class="form-label fw-bold">Доступні години:</label>
                                    <div id="slotsList" class="d-flex flex-wrap gap-2">
                                        <!-- Сюди будуть завантажені слоти через JS -->
                                    </div>
                                    <input type="hidden" name="time" id="selectedTime" required>
                                </div>

                                <button type="submit" class="btn btn-success w-100 btn-lg" id="submitBtn" disabled>
                                    Підтвердити запис
                                </button>
                            </form>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="bi bi-person-lock display-4 text-muted mb-3 d-block"></i>
                                <p class="mb-3">Для запису на прийом необхідно увійти в систему.</p>
                                <a href="login/index.php" class="btn btn-outline-success w-100">Авторизуватися</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('appointmentDate');
    const doctorId = document.getElementById('doctorId')?.value;
    const slotsContainer = document.getElementById('slotsContainer');
    const slotsList = document.getElementById('slotsList');
    const selectedTime = document.getElementById('selectedTime');
    const submitBtn = document.getElementById('submitBtn');

    if (dateInput) {
        dateInput.addEventListener('change', function() {
            const date = this.value;
            if (!date) return;
            
            slotsList.innerHTML = '<div class="spinner-border text-success spinner-border-sm" role="status"></div> Завантаження...';
            slotsContainer.style.display = 'block';
            submitBtn.disabled = true;
            selectedTime.value = '';

            fetch(`get-slots.php?doctor_id=${doctorId}&date=${date}`)
                .then(response => response.json())
                .then(data => {
                    slotsList.innerHTML = '';
                    if (data.error) {
                        slotsList.innerHTML = `<span class="text-danger">${data.error}</span>`;
                        return;
                    }
                    if (data.slots && data.slots.length > 0) {
                        data.slots.forEach(slot => {
                            const btn = document.createElement('button');
                            btn.type = 'button';
                            btn.className = 'btn btn-outline-success btn-sm time-slot';
                            btn.textContent = slot;
                            btn.onclick = function() {
                                document.querySelectorAll('.time-slot').forEach(b => b.classList.remove('active'));
                                this.classList.add('active');
                                selectedTime.value = slot;
                                submitBtn.disabled = false;
                            };
                            slotsList.appendChild(btn);
                        });
                    } else {
                        slotsList.innerHTML = '<span class="text-muted">Немає вільних годин на цю дату.</span>';
                    }
                })
                .catch(error => {
                    slotsList.innerHTML = '<span class="text-danger">Помилка завантаження.</span>';
                });
        });
    }
});
</script>

<?php require_once('footer.php'); ?>
