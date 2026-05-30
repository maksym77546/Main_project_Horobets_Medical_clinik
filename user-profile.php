<?php
include_once ('header.php');

if (!is_user_logged_in()) {
    header('Location: user-login.php');
    exit();
}

$user = get_user_by_id($_SESSION['user_id']);
if (!$user) {
    header('Location: user-logout.php');
    exit();
}
?>
<section class="py-5 bg-light">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-header bg-primary text-white py-3 rounded-top-4">
                        <h4 class="mb-0"><i class="bi bi-person-circle"></i> <?=$lang['profile_title']?></h4>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <h5 class="border-bottom pb-2 mb-4"><?=$lang['profile_info']?></h5>
                        
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold text-muted"><?=$lang['profile_name']?></div>
                            <div class="col-sm-8 fs-5"><?=htmlspecialchars($user['full_name'])?></div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold text-muted"><?=$lang['profile_email']?></div>
                            <div class="col-sm-8"><?=htmlspecialchars($user['email'])?></div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold text-muted"><?=$lang['profile_phone']?></div>
                            <div class="col-sm-8"><?=htmlspecialchars($user['phone']) ?: "<span class='text-muted fst-italic'>{$lang['profile_not_set']}</span>"?></div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-sm-4 fw-bold text-muted"><?=$lang['profile_registered']?></div>
                            <div class="col-sm-8"><?=date('d.m.Y H:i', strtotime($user['created_at']))?></div>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <a href="index.php" class="btn btn-outline-primary"><i class="bi bi-house-door"></i> <?=$lang['nav_home']?></a>
                            <a href="user-logout.php" class="btn btn-outline-danger"><i class="bi bi-box-arrow-right"></i> <?=$lang['nav_logout']?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once('footer.php'); ?>
