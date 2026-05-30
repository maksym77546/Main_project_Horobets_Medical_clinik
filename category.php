<?php
 include_once ('header.php');
 ?>
<section class="category py-4">
    <div class="container">
        <?php
            $category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
            if (!$category_id) { header('Location: 404.php'); exit(); }
            $category = get_category_title($category_id);
            if (!$category) { header('Location: 404.php'); exit(); }
            
            $doctors = get_doctors_by_category($category_id);
        ?>
        <h2 class="mt-4 mb-1 fw-bolder">
            <?=$lang['specialization']?>
            <span class="text-primary"><?=$category['title']?></span>
        </h2>
        <p class="text-muted mb-4"><?=$lang['doctors_found']?> <strong><?=count($doctors)?></strong></p>
        <hr>
        <div class="row">
            <?php if (empty($doctors)): ?>
            <div class="col-12">
                <div class="alert alert-info"><?=$lang['no_doctors_cat']?></div>
            </div>
            <?php endif; ?>
            <?php foreach ($doctors as $doctor):?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <img class="card-img-top" src="<?=$doctor['image']?>" alt="<?=$doctor['doctor_name']?>" style="height: 220px; object-fit: cover; object-position: center top;" />
                    <div class="card-body d-flex flex-column">
                        <div class="small text-primary fw-bold mb-1"><?=$doctor['datetime']=date('d.m.Y', strtotime($doctor['datetime']));?></div>
                        <h3 class="card-title h5 fw-bolder"><?=$doctor['doctor_name']?></h3>
                        <p class="card-text text-muted flex-grow-1"><?=mb_substr($doctor['specialization'],0,120,'utf-8').(mb_strlen($doctor['specialization'])>120?'...':'')?></p>
                        <a class="btn btn-outline-primary mt-auto" href="post.php?post_id=<?=$doctor['id']?>"><?=$lang['details']?></a>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
        <a class="btn btn-secondary mb-4" href="index.php"><?=$lang['all_doctors']?></a>
    </div>
</section>
<?php require_once('footer.php'); ?>
