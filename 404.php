<?php
include_once ('header.php');
?>
<section class="py-5">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <h1 class="display-1 fw-bold text-primary mb-3">404</h1>
                <h2 class="mb-4"><?=$lang['404_title']?></h2>
                <p class="lead text-muted mb-5"><?=$lang['404_message']?></p>
                <a class="btn btn-primary btn-lg" href="index.php">
                    <i class="bi bi-house-door me-2"></i> <?=$lang['404_home']?>
                </a>
            </div>
        </div>
    </div>
</section>
<?php require_once('footer.php'); ?>
