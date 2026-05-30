<?php
include_once ('header.php');

$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
if (!$post_id) { header('Location: 404.php'); exit(); }
$doctor = get_doctor_by_id($post_id);
if (!$doctor) { header('Location: 404.php'); exit(); }

$schedule = get_doctor_schedule($post_id);
$certificates = get_doctor_certificates($post_id);
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
                        <p class="card-text lead"><?=$doctor['specialization']?></p>
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
        </div>
    </div>
</section>
<?php require_once('footer.php'); ?>
