<?php
include_once ('header.php');

$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
if (!$post_id) { header('Location: index.php'); exit(); }
$doctor = get_doctor_by_id($post_id);
if (!$doctor) { header('Location: index.php'); exit(); }
?>
<section class="doctor-detail py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow border-0 rounded-4 overflow-hidden">
                    <img class="card-img-top"
                         src="<?=$doctor['image']?>"
                         alt="<?=$doctor['doctor_name']?>"
                         style="max-height: 400px; object-fit: cover;" />
                    <div class="card-body p-4">
                        <span class="badge bg-primary mb-2">
                            <?php
                                $cat = get_category_title($doctor['menu_id']);
                                echo $cat['title'] ?? '';
                            ?>
                        </span>
                        <h1 class="card-title fw-bolder h3"><?=$doctor['doctor_name']?></h1>
                        <div class="small text-muted mb-3">
                            <i>Дата додавання:</i>
                            <?=$doctor['datetime']=date('d.m.Y', strtotime($doctor['datetime']));?>
                        </div>
                        <p class="card-text lead"><?=$doctor['specialization']?></p>
                        <a class="btn btn-primary mt-3" href="index.php">← Повернутися до списку</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once('footer.php'); ?>
